<?php
declare(strict_types=1);

namespace SPC\Command;


use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Datasource\ConnectionManager;

class MigrateDataCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io): int
    {
        $sqliteConn = ConnectionManager::get('SQLite');
        $mysqlConn = ConnectionManager::get('default');

        $io->out('<info>Calculando volumen de datos...</info>');

        // Obtenemos el total para la barra de progreso sin cargar los datos aún
        $totalCount = $sqliteConn->execute("SELECT COUNT(*) FROM stream_hits")->fetch()[0];

        if ($totalCount == 0) {
            $io->warning('La tabla de SQLite está vacía.');
            return static::CODE_SUCCESS;
        }

        $io->out(sprintf('<info>Migrando %d registros...</info>', $totalCount));

        // Iniciamos la barra de progreso
        $progress = $io->helper('Progress');
        $progress->init(['total' => $totalCount, 'width' => 40]);

        // Iniciamos una transacción en MySQL para máxima velocidad
        $mysqlConn->begin();

        try {
            // Usamos el statement como iterador (no fetchAll) para ahorrar RAM
            $statement = $sqliteConn->execute("SELECT * FROM stream_hits");

            while ($row = $statement->fetch('assoc')) {
                $dataToInsert = [
                    'format' => $row['format'] ?? 'hls',
                    'referer' => $row['referer'] ?? '',
                    'refererType' => $row['referer_type'] ?? 'app', // Mapeado
                    'ip' => $row['ip'] ?? '',
                    'userAgent' => $row['user_agent'] ?? '',    // Mapeado
                    'country' => $row['country'] ?? '',
                    'countryCode' => $row['country_code'] ?? '',  // Mapeado
                    'city' => $row['city'] ?? '',
                    'zip' => $row['zip'] ?? '',
                    'lat' => $row['lat'] ?? null,
                    'lon' => $row['lon'] ?? null,
                    'created' => $row['created_at'] ?? date('Y-m-d H:i:s'), // Mapeado
                    'modified' => $row['modified'] ?? date('Y-m-d H:i:s'),
                ];

                $mysqlConn->insert('stream_hits', $dataToInsert);

                $progress->increment(1);
                $progress->draw();
            }

            // Consolidamos los cambios en MySQL
            $mysqlConn->commit();
            $io->out("");
            $io->success(sprintf('Se han migrado %d registros correctamente.', $totalCount));

        } catch (\Exception $e) {
            // Si algo falla, deshacemos los cambios para no dejar datos a medias
            $mysqlConn->rollback();
            $io->out("");
            $io->error("Error durante la migración: " . $e->getMessage());
            return static::CODE_ERROR;
        }

        return static::CODE_SUCCESS;
    }
}