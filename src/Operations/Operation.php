<?php

namespace Operations;

use Containers\Container;

/**
 * 
 */
abstract class Operation
{
	protected $referencia, $pedimento, $cliente;
	protected $aduana, $patente, $tipo_mercancia, $tipo_operacion, $status;
	protected $carga = [];
	
	function __construct(string $tipo_mercancia, array $mercancias, string $status)
	{
		$this->status = $status;
		$this->tipo_mercancia = $tipo_mercancia;

		if ( empty($mercancias) && $tipo_mercancia === 'contenerizada' ) {
			throw new \Exception('La operación no puede ser creada sin contenedores');
		}

		$this->procesarMercancias($mercancias);
	}

	// setter global
	public function set(string $key, $val) :self
	{
		if ( !property_exists($this, $key) ) {
			throw new \InvalidArgumentException("Propiedad con nombre {$key} no existe");
		}

		$this->{$key} = $val;

		return $this;
	}

	function __get(string $name)
	{
		if ( !property_exists($this, $name) ) {
			throw new \InvalidArgumentException("Propiedad con nombre {$name} no existe");
		}

		return $this->{$name};
	}

	protected function getDateTimeObj(int $timestamp) :\DateTime
	{
		$dateTime = new \DateTime('@' . $timestamp);
		$dateTime->setTimezone(new \DateTimeZone('America/Mexico_City'));

		return $dateTime;
	}

	protected function procesarMercancias(array $mercancias) :void
	{
		foreach ($mercancias as $m) {
			if ( $this->tipo_mercancia === 'contenerizada' ) {
				if ( empty((int) $m['fecha_descargo']) ) {
					continue;
				}
						
				$time = $this->getDateTimeObj((int) $m['fecha_descargo']);

				$container = new Container(
					$m['folio'], $m['tipo'], $m['dimensiones'], $time
				);

				$this->carga[] = $container;
			}

			// Si es carga suelta, la descripción de la carga y la cantidad de la misma
			elseif ( $this->tipo_mercancia === 'carga_suelta' ) {
				$this->carga[] = [
					'cantidad' => $m['cantidad'] ?? 1,
					'descripcion' => $m['descripcion']
				];
			}
		}

		// la operación no puede ser creada sin contenedores
		if ( empty($this->carga) ) {
			throw new \Exception('Esta operación no tiene carga/contenedores');
		}
	}
}