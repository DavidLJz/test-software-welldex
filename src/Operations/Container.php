<?php

namespace Operations;

/**
 * 
 */
class Container
{
	
	function __construct(
		string $folio, string $tipo, array $dimensiones, \DateTime $fecha_descargo
	)
	{
		$this->folio = $folio;
		$this->tipo = $tipo;
		$this->dimensiones = $dimensiones;
		$this->fecha_descargo = $fecha_descargo;
	}

	function __get(string $name)
	{
		if ( !property_exists($this, $name) ) {
			throw new \InvalidArgumentException("Propiedad con nombre {$name} no existe");
		}

		return $this->{$name};
	}
}