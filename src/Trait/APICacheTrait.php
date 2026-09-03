<?php
declare(strict_types=1);

namespace SPC\Trait;

use Cake\Cache\Cache;
use Cake\I18n\Time;
use SPC\DTO\StreamData;
use SPC\Model\Entity\Programa;


trait APICacheTrait
{
    final protected const string CR_CACHE_KEY = 'active_remote_broadcast';

    final protected const string CR_CACHE_CONFIG = 'RC-Config';

    final protected const int CR_MAX_TIME = 2 * 60 * 60;

    final protected const string SCHEDULE_CACHE_KEY = 'schedule_override';

    final protected const string SCHEDULE_CACHE_CONFIG = 'Programme-Config';

    final protected const string LIVE_SHOW = 'live_show';

    final protected const string LIVE_BROADCAST = 'live_broadcast';


    protected function isOverrideActive(): bool
    {
        $override = Cache::read(self::SCHEDULE_CACHE_KEY, self::SCHEDULE_CACHE_CONFIG);
        if ($override === null) {
            return false;
        }

        if ($override['expires_at'] < time()) {
            Cache::delete(self::SCHEDULE_CACHE_KEY, self::SCHEDULE_CACHE_CONFIG);
            return false;
        }
        return true;
    }

	protected function getActiveOverride(): StreamData
	{
		$override = Cache::read(self::SCHEDULE_CACHE_KEY, self::SCHEDULE_CACHE_CONFIG);
		
		return new StreamData(
			programa: $override['programa'],
			produccion: $override['produccion'],
			pty: (int) $override['pty'],
			ptn: $override['ptn'],
			music: (bool) $override['music'],
			sm: (bool) $override['music'],
			conduccion: $override['conduccion'],
			image: Programa::getDefaultCover(musical: (bool) $override['music']),
			horaInicio: Time::createFromFormat('H:i', $override['hora_inicio']),
			durationMinutes: $override['duration_minutes'],
			expiresAt: $override['expires_at'],
		);
	}
}