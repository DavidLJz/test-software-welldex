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

		if ( empty($time) ) {
			throw new \InvalidArgumentException('Debe proporcionar parametro time');
		}

		$this->fecha_zarpe = $this->createDateTime($time);
		$this->pais_destino = $pais;

		$this->tipo_operacion = 'Exportación';
	}

	public function actualizarFechaZarpe($time) :self
	{
		$eta = $this->createDateTime($time);

		$this->fecha_zarpe = $eta;

		$d = $this->createDateTime();

		if ( $eta->getTimestamp() > $d->getTimestamp() ) {
			$this->status = 'ETD';
		}

		return $this;
	}
}