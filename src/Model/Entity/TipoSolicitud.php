<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;


class TipoSolicitud extends Entity implements \Stringable
{

	public const int SPOT_RECORDING = 1;

	public const int CEREMONY_MASTER = 2;

	public const int REMOTE_BROADCAST = 3;

	public function __toString(): string
	{
		return $this->icon;
	}
}
