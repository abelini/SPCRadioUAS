<?php
declare(strict_types=1);

namespace SPC\Trait;


trait APICacheTrait
{
    protected const string CONTROL_REMOTO_CACHE = 'active_remote_broadcast';

    protected const int MAX_REMOTE_CONTROL_TIME = 2 * 60 * 60;
}