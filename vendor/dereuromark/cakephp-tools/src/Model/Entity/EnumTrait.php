<?php

namespace Tools\Model\Entity;

trait EnumTrait {

	/**
	 * The main method for any enumeration, should be called statically
	 * Now also supports reordering/filtering
	 *
	 * @link https://www.dereuromark.de/2010/06/24/static-enums-or-semihardcoded-attributes/
	 * @param array<string|int>|string|int|null $value Integer or array of keys or NULL for complete array result
	 * @param array<string|int, mixed> $options Options
	 * @param string|null $default Default value
	 * @return array<string|int, mixed>|string|null
	 */
	public static function enum($value, array $options, $default = null) {
		if ($value !== null && !is_array($value)) {
			if (array_key_exists($value, $options)) {
				return $options[$value];
			}

			return $default;
		}
		if ($value !== null) {
			$newOptions = [];
			foreach ($value as $v) {
				$newOptions[$v] = $options[$v];
			}

			return $newOptions;
		}

		return $options;
	}

}
