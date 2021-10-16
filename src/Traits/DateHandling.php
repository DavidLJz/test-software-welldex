<?php

namespace Traits;

use DateTime;
use DateTimeZone;

/**
 * 
 */
trait DateHandling
{
	protected function getDateTimeFromTimestamp(int $timestamp) :DateTime
	{
		$dateTime = new DateTime('@' . $timestamp);
		$dateTime->setTimezone(new DateTimeZone('America/Mexico_City'));

		return $dateTime;
	}

	public function createDateTime($time=null) :?DateTime
	{
		if ( empty($time) ) {
			return (new DateTime( '@' . time() ))->setTimezone(
				new DateTimeZone('America/Mexico_City')
			);
		}

		if ( !is_numeric($time) ) {
			$d = DateTime::createFromFormat('Y-m-d H:i', $time);

			if ( !$d ) {
				throw new \Exception(
					'La fecha debe seguir el siguiente formato: Y-m-d H:i'
				);
			}

			return $d;
		}

		else {
			if ( empty((int) $time) ) {
				throw new \InvalidArgumentException('Parametro debe ser string o timestamp');
			}

			return $this->getDateTimeFromTimestamp($time);
		}

		return null;
	}
}