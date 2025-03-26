<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class DetalleIncidencia extends Entity {
	
	protected const array LABELS = [
		'fire' => 'Incendio en algún área o equipo',
		'moist' => 'Inundaciones, filtraciones, goteras o humedad',
		'ventilation' => 'El equipo de enfriamiento dejó de funcionar',
		'locks' => 'Problemas en cerraduras de puertas',
		'blackout' => 'Cortes en el suministro eléctrico',
		'lost_signal' => 'Pérdida de señal en el equipo de monitoreo de radio',
		'alarm_on' => 'Sonidos extraños o alarmas sonoras',
		'leds' => 'Indicadores luminosos fuera de lo común',
		'burning_smell' => 'Olor a quemado u otro extraño',
		'invaded' => 'Ingreso de personas no identificadas',
		'walls_cracked' => 'Fisuras o rupturas en muros o bardas perimetrales',
		'antenna_bent' => 'Deformaciones perceptibles en la torre',
		'antenna_lights_off' => 'Fallas en la iluminación de la torre',
		'antenna_anchor_bent' => 'Fisuras o rupturas en las anclas de la torre',
	];
	
    protected array $_accessible = [
        'bitacoraID' => true,
        'fire' => true,
        'moist' => true,
        'ventilation' => true,
        'locks' => true,
        'blackout' => true,
        'lost_signal' => true,
        'alarm_on' => true,
        'leds' => true,
        'burning_smell' => true,
        'invaded' => true,
        'walls_cracked' => true,
        'antenna_bent' => true,
        'antenna_lights_off' => true,
        'antenna_anchor_bent' => true,
        'blackout_duration' => true,
        'lost_signal_duration' => true,
    ];
    
    public function getLabels() : array {
	    return self::LABELS;
    }
}
