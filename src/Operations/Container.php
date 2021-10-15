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
		if ( !preg_match('/^[\da-z]{5,}$/i', $folio) ) {
			throw new \InvalidArgumentException(
				'El folio debe ser un string alfanumerico'
			);
		}

		$this->folio = strtolower($folio);

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