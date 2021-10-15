<?php

require_once __DIR__ . '/vendor/autoload.php';

use Operations\Import;
use Operations\Export;

$import = new Import(time(), 'Argentina', 'contenerizada');

print_r($import);