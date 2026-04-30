<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateStreamTables extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/5/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        // Tabla: stream_hits
        // Desactivamos la creación automática del ID por defecto de Phinx
        $tableStreamHits = $this->table('stream_hits', ['id' => false, 'primary_key' => ['ID']]);
        $tableStreamHits
            ->addColumn('ID', 'biginteger', [
                'autoIncrement' => true,
                'signed' => false,
                'null' => false
            ])
            ->addColumn('format', 'enum', [
                'values' => ['mp3', 'hls'],
                'default' => 'mp3',
                'null' => false
            ])
            ->addColumn('referer', 'string', [
                'limit' => 255,
                'default' => '',
                'null' => false
            ])
            ->addColumn('refererType', 'enum', [
                'values' => ['domain', 'app', 'unknown'],
                'default' => 'unknown',
                'null' => false
            ])
            ->addColumn('ip', 'string', [
                'limit' => 45,
                'default' => '',
                'null' => false
            ])
            ->addColumn('userAgent', 'string', [
                'limit' => 512,
                'default' => '',
                'null' => false
            ])
            ->addColumn('country', 'string', [
                'limit' => 100,
                'default' => '',
                'null' => false
            ])
            ->addColumn('countryCode', 'string', [
                'limit' => 2,
                'default' => '',
                'null' => false
            ])
            ->addColumn('city', 'string', [
                'limit' => 100,
                'default' => '',
                'null' => false
            ])
            ->addColumn('zip', 'string', [
                'limit' => 20,
                'default' => '',
                'null' => false
            ])
            ->addColumn('lat', 'decimal', [
                'precision' => 10,
                'scale' => 7,
                'null' => true,
                'default' => null
            ])
            ->addColumn('lon', 'decimal', [
                'precision' => 10,
                'scale' => 7,
                'null' => true,
                'default' => null
            ])
            ->addColumn('createdAt', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'null' => false
            ])
            ->addIndex(['format'])
            ->addIndex(['referer'])
            ->addIndex(['refererType'])
            ->addIndex(['createdAt'])
            ->addIndex(['ip'])
            ->create();
    }
}
