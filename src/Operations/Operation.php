<?php

namespace Operations;

use Containers\Container;
use Traits\DateHandling;

/**
 * 
 */
abstract class Operation
{
	use DateHandling;

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

		$this->registrarMercancias($mercancias);

		$this->referencia = uniqid();
	}

	public function actualizarReferencia(string $value) :self
	{
		$this->referencia = $value;
		return $this;
	}

	public function actualizarPedimento($value) :self
	{
		$this->pedimento = $value;
		return $this;
	}

	public function actualizarAduana($value) :self
	{
		$this->aduana = $value;
		return $this;
	}

	public function actualizarCliente($value) :self
	{
		$this->cliente = $value;
		return $this;
	}

	public function actualizarPatente($value) :self
	{
		$this->patente = $value;
		return $this;
	}

	protected function actualizarTipoMercancia(string $value) :self
	{
		$this->tipo_mercancia = $value;
		return $this;
	}

	protected function actualizarStatus(string $value) :self
	{
		$this->tipo_operacion = $value;
		return $this;
	}

	function __get(string $name)
	{
		if ( !property_exists($this, $name) ) {
			throw new \InvalidArgumentException("Propiedad con nombre {$name} no existe");
		}

		return $this->{$name};
	}

	protected function registrarMercancias(array $mercancias) :void
	{
		foreach ($mercancias as $m) {
			if ( $this->tipo_mercancia === 'contenerizada' ) {
				if ( empty($m['fecha_descargo']) ) {
					continue;
				}

				$time = $this->createDateTime($m['fecha_descargo']);

				$container = new Container(
					$m['container_id'], $m['tipo'], $m['dimensiones'], $time
				);

				$this->carga[] = $container;
			}

			// Si es carga suelta, la descripción de la carga y la cantidad de la misma
			elseif ( $this->tipo_mercancia === 'carga_suelta' ) {
				$this->carga = [
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

	protected function getContainer(string $container_id) :?Container
	{
		foreach ($this->carga as $container) {
			if ( $container->container_id == $container_id ) {
				return $container;
			}
		}

		return null;
	}

	protected function contabilizarDescargas() :int
	{
		$x = 0;

		if ( $this->tipo_mercancia === 'contenerizada' ) {
			foreach ($this->carga as $container) {
				if ( $container->status == 'Descargado' ) {
					$x++;
				}
			}

			if ( count($this->carga) == $x )  {
				$this->status = 'Descargo';
			}

		} else {
			if ($this->carga['cantidad'] == 0) {
				$this->status = 'Descargo';
			}
		}

		return $x;
	}

	public function registrarDescarga(int $amount=1, ?string $container_id=null, $time=null) :self
	{
		$time = $this->createDateTime($time);

		if ( $this->tipo_mercancia === 'contenerizada' ) {
			if ( empty($container_id) ) {
				throw new \Exception('Debe proporcionar el id del contenedor');
			}

			$container = $this->getContainer($container_id);

			if ( empty($container) ) {
				throw new \Exception('No existe contenedor con id: ' . $container_id);
			}

			$container->registrarDescarga();
		}

		elseif ( $this->tipo_mercancia === 'carga_suelta' ) {
			if ( $this->carga['cantidad'] > 0 )	{
				$this->carga['cantidad'] -= $amount;
			}
		}

		$this->contabilizarDescargas();

		return $this;
	}
}