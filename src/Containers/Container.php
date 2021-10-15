<?php

namespace Containers;

use DateTime;
use Traits\DateHandling;

/**
 * 
 */
class Container
{
	protected $container_id, $tipo, $dimensiones, $fecha_descargo, $status;

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

		$this->status = 'En transporte';
	}

	public function actualizarFechaDescarga($time=null) :self
	{
		$time = $this->createDateTime($time);

		$this->fecha_descargo = $time;

		return $this;
	}

	public function registrarDescarga() :self
	{
		$this->actualizarFechaDescarga();

		$this->status = 'Descargado';

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