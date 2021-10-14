<?php

/**
 * 
 */
class Import extends Operation
{
	protected $fecha_origen, $pais_origen;
	
	function __construct($time, string $pais, string $tipo_mercancia, string $status='Alta')
	{
		parent::__construct($tipo_mercancia, $status);

		if ( !$time instanceof DateTime ) {
			if ( !empty((int) $time) ) {
				$time = $this->getDateTimeObj((int) $time, $pais);
			}

			throw new InvalidArgumentException('Parametro time debe ser DateTime o timestamp');
		}

		$this->fecha_origen = $time;
		$this->pais_origen = $pais;

		if ( $tipo_mercancia === 'contenerizada' ) {
			$this->carga[] = $this->createContainer([]);
		}

		else {
			$this->carga = [
				
			];
		}
	}
}