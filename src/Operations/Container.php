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
}