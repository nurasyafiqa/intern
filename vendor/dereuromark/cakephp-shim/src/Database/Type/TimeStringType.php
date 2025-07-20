<?php

namespace Shim\Database\Type;

use Cake\Database\Driver;
use Cake\Database\Type\BaseType;
use PDO;

/**
 * Experimental time type (as string)
 *
 * Needs:
 * - \Cake\Database\TypeFactory::map('time'), 'Shim\Database\Type\TimeStringType'); in bootstrap
 * - Manual FormHelper $this->Form->control('closing_time', ['type' => 'time']);
 */
class TimeStringType extends BaseType {

	/**
	 * If 24:00:00 should be normalized to 00:00:00, defaults to false as this could change
	 * meaning in time diffs.
	 *
	 * @var bool
	 */
	public static bool $normalizeUpperBoundary = false;

	/**
	 * @param array|string $value The value to convert.
	 * @param \Cake\Database\Driver $driver The driver instance to convert with.
	 * @return string|null
	 */
	public function toDatabase(mixed $value, Driver $driver): mixed {
		if (is_array($value)) {
			$value = $this->fromArray($value);
		}
		if ($value !== null) {
			$value = $this->normalize($value);
		}
		if ($value === null) {
			return null;
		}

		return $value;
	}

	/**
	 * Convert binary into resource handles
	 *
	 * @param string|null $value The value to convert.
	 * @param \Cake\Database\Driver $driver The driver instance to convert with.
	 * @return string|null
	 */
	public function toPHP(mixed $value, Driver $driver): mixed {
		if ($value === null) {
			return null;
		}

		return $value;
	}

	/**
	 * @param mixed $value The value to convert.
	 * @return mixed Converted value.
	 */
	public function marshal(mixed $value): mixed {
		if (is_array($value)) {
			$value = $this->fromArray($value);
		}
		if ($value !== null) {
			$value = $this->normalize($value);
		}
		if ($value === null) {
			return null;
		}

		return $value;
	}

	/**
	 * Get the correct PDO binding type for time data.
	 *
	 * @param mixed $value The value being bound.
	 * @param \Cake\Database\Driver $driver The driver.
	 * @return int
	 */
	public function toStatement(mixed $value, Driver $driver): int {
		return PDO::PARAM_STR;
	}

	/**
	 * @param array $value
	 *
	 * @return string|null
	 */
	protected function fromArray(array $value): ?string {
		$hours = isset($value['hour']) ? str_pad($value['hour'], 2, '0', STR_PAD_LEFT) : '00';
		$minutes = isset($value['minute']) ? str_pad($value['minute'], 2, '0', STR_PAD_LEFT) : '00';
		$seconds = isset($value['second']) ? str_pad($value['second'], 2, '0', STR_PAD_LEFT) : '00';

		return $hours . ':' . $minutes . ':' . $seconds;
	}

	/**
	 * @param string $value
	 * @return string|null
	 */
	protected function normalize(string $value): ?string {
		if (!preg_match('#^(([0-1][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]|24:00:00)$#', $value)) {
			return null;
		}
		if (static::$normalizeUpperBoundary && $value === '24:00:00') {
			return '00:00:00';
		}

		return $value;
	}

}
