<?php

namespace Operations;

/**
 * 
 */
class Import extends Operation
{
	protected $fecha_arribo, $pais_origen;
	
	function __construct(
		$time, string $pais, string $tipo_mercancia, array $mercancias, string $status='Alta'
	)
	{
		parent::__construct($tipo_mercancia, $mercancias, $status);

		$time = $this->createDateTime($time);

		$this->fecha_arribo = $time;
		$this->pais_origen = $pais;
	}

	public function actualizarFechaArribo($time) :self
	{
		$eta = $this->createDateTime($time);

		$this->fecha_arribo = $eta;

		$d = $this->createDateTime();

		if ( $eta->getTimestamp() > $d->getTimestamp() ) {
			$this->status = 'ETA en Espera';
		}

		return $this;
	}
}