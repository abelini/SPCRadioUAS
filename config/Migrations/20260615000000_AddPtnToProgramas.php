<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddPtnToProgramas extends BaseMigration
{
    public function up(): void
    {
        $this->execute('UPDATE programas SET pty = 0 WHERE pty IS NULL');
        $table = $this->table('programas');
        $table->changeColumn('pty', 'smallinteger', [
            'null' => false,
            'default' => 0,
            'signed' => false,
        ]);
        $table->addColumn('ptn', 'string', [
            'limit' => 8,
            'null' => false,
            'default' => '',
        ]);
        $table->update();
    }

    public function down(): void
    {
        $table = $this->table('programas');
        $table->changeColumn('pty', 'smallinteger', [
            'null' => true,
            'default' => null,
            'signed' => false,
        ]);
        $table->removeColumn('ptn');
        $table->update();
    }
}
