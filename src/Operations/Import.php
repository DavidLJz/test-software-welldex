<?php

namespace Operations;

/**
 * 
 */
class Import extends Operation
{
	protected $fecha_origen, $pais_origen;
	
	function __construct(
		$time, string $pais, string $tipo_mercancia, array $mercancias, string $status='Alta'
	)
	{
		parent::__construct($tipo_mercancia, $mercancias, $status);

		if ( !$time instanceof \DateTime ) {
			if ( empty((int) $time) ) {
				throw new \InvalidArgumentException('Parametro time debe ser DateTime o timestamp');
			}

			$time = $this->getDateTimeObj((int) $time);
		}

		$this->fecha_origen = $time;
		$this->pais_origen = $pais;
	}
}