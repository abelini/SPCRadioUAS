<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class MakePhotoNullableInUsuarios extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('usuarios');
        $table->changeColumn('photo', 'string', [
            'limit' => 255,
            'null' => true,
            'default' => null,
        ]);
        $table->update();
    }
}
