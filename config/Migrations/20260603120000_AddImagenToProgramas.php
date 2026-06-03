<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddImagenToProgramas extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('programas');
        $table->addColumn('imagen', 'string', [
            'limit' => 255,
            'null' => true,
            'default' => null,
        ]);
        $table->update();
    }
}
