<?php

namespace Shim\Model\Entity;

use Cake\Utility\Inflector;
use RuntimeException;

/**
 * Trait to read entity properties in a way that the return value is ensured (not nullable).
 *
 * - get{PropertyName}OrFail() must return the property or throws exception otherwise
 */
trait GetTrait {

	/**
	 * @param string $property
	 * @throws \RuntimeException
	 * @return mixed|null
	 */
	public function getOrFail(string $property): mixed {
		if (!isset($this->$property)) {
			throw new RuntimeException('$' . $property . ' is null, expected non-null value.');
		}

		return $this->$property;
	}

	/**
	 * @param string $name
	 * @param array $arguments
	 * @throws \RuntimeException
	 * @return mixed|null
	 */
	public function __call(string $name, array $arguments): mixed {
		if (!preg_match('/^get([A-Z][A-Za-z0-9]+)OrFail$/', $name, $matches)) {
			throw new RuntimeException('Method ' . $name . ' cannot be found; get{PropertyName}OrFail() expected.');
		}

		$property = Inflector::underscore($matches[1]);

		return $this->getOrFail($property);
	}

}
