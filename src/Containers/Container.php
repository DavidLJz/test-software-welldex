<?php

namespace Containers;

use DateTime;
use Traits\DateHandling;

/**
 * 
 */
class Container
{
	protected $container_id, $tipo, $dimensiones, $fecha_descargo;

	use DateHandling;
	
	function __construct(
		string $container_id, string $tipo, array $dimensiones, ?DateTime $fecha_descargo=null
	)
	{
		if ( !preg_match('/^[\da-z]{5,}$/i', $container_id) ) {
			throw new \InvalidArgumentException(
				'El container_id debe ser un string alfanumerico'
			);
		}

		$this->container_id = strtolower($container_id);

		$this->tipo = $tipo;
		$this->dimensiones = $dimensiones;
		$this->fecha_descargo = $fecha_descargo;
	}

	public function actualizarFechaDescarga($time) :self
	{
		$time = $this->createDateTime($time);

		$this->fecha_descargo = $time;

		return $this;
	}

	function __get(string $name)
	{
		if ( !property_exists($this, $name) ) {
			throw new \InvalidArgumentException("Propiedad con nombre {$name} no existe");
		}

		return $this->{$name};
	}
}