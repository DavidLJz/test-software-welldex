<?php

namespace Operations;

/**
 * 
 */
abstract class Operation
{
	protected $referencia, $pedimento, $cliente;
	protected $aduana, $patente, $tipo_mercancia, $tipo_operacion, $status;
	protected $carga = [];
	
	function __construct(string $tipo_mercancia, string $status)
	{
		$this->status = $status;
		$this->tipo_mercancia = $tipo_mercancia;
	}

	// setter global
	public function set(string $key, $val) :self
	{
		if ( !property_exists($this, $key) ) {
			throw new \InvalidArgumentException("Propiedad con nombre {$key} no existe");
		}

		$this->{$key} = $val;

		return $this;
	}

	function __get(string $name)
	{
		if ( !property_exists($this, $name) ) {
			throw new \InvalidArgumentException("Propiedad con nombre {$name} no existe");
		}

		return $this->{$name};
	}

	protected function getDateTimeObj(int $timestamp) :\DateTime
	{
		$dateTime = new \DateTime('@' . $timestamp);

		return $dateTime;
	}

	protected function createContainer(array $params) :Container
	{
		extract($params);

		return new Container($folio, $tipo, $dimensiones, $fecha_descargo);
	}
}