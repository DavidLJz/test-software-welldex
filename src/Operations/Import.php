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

		if ( !$time instanceof \DateTime ) {
			if ( empty((int) $time) ) {
				throw new \InvalidArgumentException('Parametro time debe ser DateTime o timestamp');
			}

			$time = $this->getDateTimeObj((int) $time);
		}

		$this->fecha_arribo = $time;
		$this->pais_origen = $pais;
	}

	public function actualizarFechaArribo($time) :self
	{
		if ( !$time instanceof \DateTime ) {
			if ( empty((int) $time) ) {
				throw new \InvalidArgumentException('Parametro time debe ser DateTime o timestamp');
			}

			$eta = $this->getDateTimeObj((int) $time);
		}

		$this->fecha_arribo = $eta;

		$d = (new \DateTime('@' . time()))->setTimezone(new \DateTimeZone('America/Mexico_City'));

		if ( $eta->getTimestamp() > $d->getTimestamp() ) {
			$this->status = 'ETA en Espera';
		}

		return $this;
	}
}