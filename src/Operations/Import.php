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

		if ( empty($time) ) {
			throw new \InvalidArgumentException('Debe proporcionar parametro time');
		}

		$this->fecha_arribo = $this->createDateTime($time);
		$this->pais_origen = $pais;

		$this->tipo_operacion = 'Importación';
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

	public function actualizarPaisOrigen($value) :self
	{
		$this->pais_origen = $value;
		return $this;
	}
}