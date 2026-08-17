<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class RemoveGhostAsignaciones extends BaseMigration
{
    public function up(): void
    {
        $this->execute('DELETE FROM asignaciones WHERE locutorID = 999');
    }

    public function down(): void
    {
    }
}