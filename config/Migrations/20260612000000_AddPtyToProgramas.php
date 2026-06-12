<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddPtyToProgramas extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('programas');
        $table->addColumn('pty', 'smallinteger', [
            'null' => true,
            'default' => null,
            'signed' => false,
        ]);
        $table->update();
    }
}
