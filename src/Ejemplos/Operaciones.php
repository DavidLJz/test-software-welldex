<?php

namespace Ejemplos;

use Containers\Container;
use Operations\Operation;
use Operations\Import;
use Operations\Export;

/**
 * 
 */
class Operaciones
{
	
	function __construct(Operation $operacion)
	{
		$this->operacion = $operacion;

		if ( $operacion instanceof Import ) {
			$this->type = 'Importación';
		} else {
			$this->type = 'Exportación';
		}
	}

	public function html() :string
	{
		$obj = $this->operacion;

		$str = '';

		$str .= '<style>table, th, td { border:1px solid black; border-collapse:collapse; padding:10px }</style>';

		$str .= '<h3>Detalles de '. $this->type .'</h3>';
		$str .= 'Referencia: ' . $obj->referencia . '<br>';
		$str .= 'Referencia: ' . $obj->referencia . '<br>';

		if ( $this->type === 'Importación' ) {
			$str_country = 'País de origen';
			$str_date = 'Fecha de arribo';
		} else {
			$str_country = 'País de destino';
			$str_date = 'Fecha de zarpe';
		}
			
		$str .= $str_country .': '. $obj->pais_origen . '</br>';

		// fecha de arribo en cualquier formato de fecha
		$fecha_arribo_a = $obj->fecha_arribo->format('d/m/Y h:i a');
		$fecha_arribo_b = $obj->fecha_arribo->format('Y-m-d H:i');

		$str .= $str_date . ': ' . $fecha_arribo_a . '<br>';
		$str .= $str_date . ': ' . '(formato Y-m-d H:i): ' . $fecha_arribo_b . '<br>';

		$str .= 'Status: ' . $obj->status . '</br>';

		$str .= '<br>';

		$str .= 'Contenedores/Carga : </br></br>';

		if ( $obj->status !== 'Descargo' ) {
			$str .= '<table>';

			foreach ($obj->carga as $n => $carga) {
				$str .= '<tr>';

				if ( $obj->tipo_mercancia == 'contenerizada' ) {
					$str .= '<td>Contenedor '. ($n+1) .'</td>';

					$str .= '<td>';
					$str .= 'Folio: ' . $carga->container_id . '<br>';
					$str .= 'Tipo: ' . $carga->tipo . '<br>';
					$str .= "Dimensiones: {$carga->dimensionesString()}</br>";
					$str .= '</td>';
				} else {

				}

				$str .= '</tr>';
			}

			$str .= '</table>';
		}

		else {
			$str .= 'Descargada';
		}

		$str .= '<br>';

		return $str;
	}
}