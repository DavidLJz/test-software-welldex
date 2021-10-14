<?php

/**
 * 
 */
abstract class Operation
{
	protected $referencia, $pedimento, $cliente, $carga;
	protected $aduana, $patente, $tipo_mercancia, $tipo_operacion, $status;
	
	function __construct(string $tipo_mercancia, string $status)
	{
		$this->status = $status;
		$this->tipo_mercancia = $tipo_mercancia;

		$this->carga = [];
	}

	// setter global
	public function set(string $key, $val) :self
	{
		if ( !property_exists($this, $key) ) {
			throw new InvalidArgumentException("Propiedad con nombre {$key} no existe");
		}

		$this->{$key} = $val;

		return $this;
	}

	// getter global
	public function get(string $key)
	{
		if ( !property_exists($this, $key) ) {
			throw new InvalidArgumentException("Propiedad con nombre {$key} no existe");
		}

		return $this->{$key};
	}

	protected function getDateTimeObj(int $timestamp) :DateTime
	{
		$dateTime = new DateTime('@' . $timestamp);

		return $dateTime;
	}

	protected function createContainer(array $params) :Container
	{
		extract($params);

		return new Container($folio, $tipo, $dimensiones, $fecha_descargo);
	}
}