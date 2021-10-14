<?php

/**
 * 
 */
class Export extends Operation
{
	protected $fecha_zarpe, $pais_destino;
	
	function __construct($time, string $pais, string $tipo_mercancia, string $status='Alta')
	{
		parent::__construct($tipo_mercancia, $status);

		if ( !$time instanceof DateTime ) {
			if ( !empty((int) $time) ) {
				$time = $this->getDateTimeObj((int) $time, $pais);
			}

			throw new InvalidArgumentException('Parametro time debe ser DateTime o timestamp');
		}

		$this->fecha_zarpe = $time;
		$this->pais_destino = $pais;

		if ( $tipo_mercancia === 'contenerizada' ) {

		}
	}
}