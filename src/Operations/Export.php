<?php

namespace Operations;

/**
 * 
 */
class Export extends Operation
{
	protected $fecha_zarpe, $pais_destino;
	
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

		$this->fecha_zarpe = $time;
		$this->pais_destino = $pais;
	}

	public function actualizarFechaZarpe($time) :self
	{
		if ( !$time instanceof \DateTime ) {
			if ( empty((int) $time) ) {
				throw new \InvalidArgumentException('Parametro time debe ser DateTime o timestamp');
			}

			$eta = $this->getDateTimeObj((int) $time);
		}

		$this->fecha_zarpe = $eta;

		$d = (new \DateTime('@' . time()))->setTimezone(new \DateTimeZone('America/Mexico_City'));

		if ( $eta->getTimestamp() > $d->getTimestamp() ) {
			$this->status = 'ETD';
		}

		return $this;
	}
}