<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use Cake\I18n\DateTime;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class StreamHitsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('stream_hits');
        $this->setDisplayField('format');
        $this->setPrimaryKey('ID');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always',
                ],
            ],
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->scalar('format')->requirePresence('format', 'create')->notEmptyString('format');
        $validator->scalar('referer')->maxLength('referer', 255)->requirePresence('referer', 'create')->notEmptyString('referer');
        $validator->scalar('refererType')->requirePresence('refererType', 'create')->notEmptyString('refererType');
        $validator->scalar('ip')->maxLength('ip', 45)->requirePresence('ip', 'create')->notEmptyString('ip');
        $validator->scalar('userAgent')->maxLength('userAgent', 512)->requirePresence('userAgent', 'create')->notEmptyString('userAgent');
        $validator->scalar('country')->maxLength('country', 64)->allowEmptyString('country');
        $validator->scalar('countryCode')->maxLength('countryCode', 2)->allowEmptyString('countryCode');
        $validator->scalar('city')->maxLength('city', 64)->allowEmptyString('city');
        $validator->scalar('zip')->maxLength('zip', 10)->allowEmptyString('zip');
        $validator->decimal('lat')->allowEmptyString('lat');
        $validator->decimal('lon')->allowEmptyString('lon');

        return $validator;
    }

    /**
     * Devuelve estadísticas resumen (KPIs)
     */
    public function getSummaryStats(string $from, string $to): array
    {
        $conn = $this->getConnection();
        $today = (new DateTime())->format('Y-m-d');

        $totalHits = (int) ($conn->execute('SELECT COUNT(*) as cnt FROM stream_hits WHERE created BETWEEN ? AND ?', [$from . ' 00:00:00', $to])->fetch('assoc')['cnt'] ?? 0);
        $uniqueReferers = (int) ($conn->execute('SELECT COUNT(DISTINCT referer) as cnt FROM stream_hits WHERE created BETWEEN ? AND ?', [$from . ' 00:00:00', $to])->fetch('assoc')['cnt'] ?? 0);
        $hitsToday = (int) ($conn->execute('SELECT COUNT(*) as cnt FROM stream_hits WHERE created >= ?', [$today . ' 00:00:00'])->fetch('assoc')['cnt'] ?? 0);
        $uniqueIpsToday = (int) ($conn->execute('SELECT COUNT(DISTINCT ip) as cnt FROM stream_hits WHERE created >= ?', [$today . ' 00:00:00'])->fetch('assoc')['cnt'] ?? 0);
        $topFormat = $conn->execute('SELECT format, COUNT(*) as cnt FROM stream_hits WHERE created BETWEEN ? AND ? GROUP BY format ORDER BY cnt DESC LIMIT 1', [$from . ' 00:00:00', $to])->fetch('assoc') ?: [];
        $topCountry = $conn->execute('SELECT country, countryCode, COUNT(*) as cnt FROM stream_hits WHERE created BETWEEN ? AND ? AND country IS NOT NULL AND country != "" GROUP BY countryCode ORDER BY cnt DESC LIMIT 1', [$from . ' 00:00:00', $to])->fetch('assoc') ?: [];

        return compact('totalHits', 'uniqueReferers', 'hitsToday', 'uniqueIpsToday', 'topFormat', 'topCountry');
    }

    /**
     * Devuelve datos para gráficas
     */
    public function getChartsData(string $from, string $to): array
    {
        $conn = $this->getConnection();

        $byFormat = $conn->execute('SELECT format, COUNT(*) as total FROM stream_hits WHERE created BETWEEN ? AND ? GROUP BY format ORDER BY total DESC LIMIT 10', [$from . ' 00:00:00', $to])->fetchAll('assoc');
        $byDay = $conn->execute('SELECT DATE(created) as day, format, COUNT(*) as total FROM stream_hits WHERE created BETWEEN ? AND ? GROUP BY day, format ORDER BY day ASC LIMIT 14', [$from . ' 00:00:00', $to])->fetchAll('assoc');
        $byHour = $conn->execute('SELECT HOUR(created) as hour, COUNT(*) as total FROM stream_hits WHERE created BETWEEN ? AND ? GROUP BY hour ORDER BY hour ASC', [$from . ' 00:00:00', $to])->fetchAll('assoc');

        $audioVsVideo = $conn->execute(
            'SELECT DATE(created) as day, SUM(CASE WHEN format = "mp3" THEN 1 ELSE 0 END) as audio, SUM(CASE WHEN format IN ("hls", "m3u8") THEN 1 ELSE 0 END) as video FROM stream_hits WHERE created BETWEEN ? AND ? GROUP BY day ORDER BY day ASC LIMIT 14',
            [$from . ' 00:00:00', $to]
        )->fetchAll('assoc');

        return compact('byFormat', 'byDay', 'byHour', 'audioVsVideo');
    }

    /**
     * Devuelve datos de tops
     */
    public function getTopsData(string $from, string $to): array
    {
        $conn = $this->getConnection();

        $topDomains = $conn->execute('SELECT referer, COUNT(*) as total FROM stream_hits WHERE created BETWEEN ? AND ? AND refererType = "domain" GROUP BY referer ORDER BY total DESC LIMIT 15', [$from . ' 00:00:00', $to])->fetchAll('assoc');
        $topApps = $conn->execute('SELECT referer, COUNT(*) as total FROM stream_hits WHERE created BETWEEN ? AND ? AND refererType = "app" GROUP BY referer ORDER BY total DESC LIMIT 15', [$from . ' 00:00:00', $to])->fetchAll('assoc');
        $topCountries = $conn->execute('SELECT country, countryCode, COUNT(*) as total FROM stream_hits WHERE created BETWEEN ? AND ? AND country IS NOT NULL AND country != "" GROUP BY countryCode ORDER BY total DESC LIMIT 15', [$from . ' 00:00:00', $to])->fetchAll('assoc');
        $topUserAgents = $conn->execute('SELECT userAgent, COUNT(*) as total FROM stream_hits WHERE created BETWEEN ? AND ? GROUP BY userAgent ORDER BY total DESC LIMIT 20', [$from . ' 00:00:00', $to])->fetchAll('assoc');

        return compact('topDomains', 'topApps', 'topCountries', 'topUserAgents');
    }

    /**
     * Devuelve datos geográficos agrupados por ciudad
     */
    public function getGeoData(string $from, string $to): array
    {
        $conn = $this->getConnection();

        return $conn->execute(
            'SELECT country, countryCode, city, 
                    MIN(lat) as lat, MIN(lon) as lon, COUNT(*) as total 
             FROM stream_hits 
             WHERE created BETWEEN ? AND ? AND lat IS NOT NULL AND lon IS NOT NULL AND city IS NOT NULL 
             GROUP BY LOWER(TRIM(city)), country, countryCode 
             ORDER BY total DESC LIMIT 100',
            [$from . ' 00:00:00', $to]
        )->fetchAll('assoc');
    }

    /**
     * Devuelve datos recientes
     */
    public function getRecentData(int $limit = 50): array
    {
        $conn = $this->getConnection();

        return $conn->execute('SELECT ID, format, referer, refererType, ip, country, countryCode, city, created FROM stream_hits ORDER BY ID DESC LIMIT ' . $limit)->fetchAll('assoc');
    }
}