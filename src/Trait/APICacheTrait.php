<?php
declare(strict_types=1);

namespace SPC\Trait;


trait APICacheTrait
{
    final protected const string CONTROL_REMOTO_CACHE = 'active_remote_broadcast';

    final protected const int MAX_REMOTE_CONTROL_TIME = 2 * 60 * 60;

    final protected const string LIVE_SHOW = 'live_show';

    final protected const string LIVE_BROADCAST = 'live_broadcast';
}