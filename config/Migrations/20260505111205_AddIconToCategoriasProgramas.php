<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddIconToCategoriasProgramas extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('categorias_programas');
        $table->addColumn('icon', 'string', [
            'limit' => 128,
            'null' => false,
            'default' => ''
        ]);
        $table->update();
    }
}