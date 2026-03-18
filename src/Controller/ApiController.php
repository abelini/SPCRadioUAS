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
        $this->loadComponent('Flash');
    }

    /**
     * Desactiva CSRF y seguridad para todos los endpoints API
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // Desactivar CSRF completamente para API
        $this->getEventManager()->off($this->FormProtection);
    }
}
