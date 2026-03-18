<?php
declare(strict_types=1);

namespace SPC\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;


class ApiController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->components()->unload('FormProtection');
        $this->loadComponent('Flash');
    }

}
