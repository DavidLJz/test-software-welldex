<?php

require_once __DIR__ . '/vendor/autoload.php';

use Operations\Import;
use Operations\Export;
use Ejemplos\Operaciones;

$mercancias = [];

$id_contenedor = uniqid();

$mercancias[] = [
	'container_id' => $id_contenedor,
	'tipo' => 'Open Top',
	'descripcion' => '',
	'fecha_descargo' => time(),
	'dimensiones' => [
		'unidad' => 'm',
		'largo' => 5.9,
		'ancho' => 2.30,
		'alto' => 2.29,
	],

	// 'cantidad' => 1,
	// 'descripcion' => 'electronicos'
];

$import = new Import(time(), 'Argentina', 'contenerizada', $mercancias);

// setters
$import->actualizarReferencia(uniqid());
$import->actualizarFechaArribo( time() + (3600 * 24) );

//$import->registrarDescarga(1, $id_contenedor);

$ejemplo = new Operaciones($import);

echo $ejemplo->html();