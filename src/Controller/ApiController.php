<?php
declare(strict_types=1);

namespace SPC\Controller;

use Cake\Controller\Controller;


class ApiController extends Controller
{
    protected const string CONTROL_REMOTO_CACHE = 'active_remote_broadcast';

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }
}
