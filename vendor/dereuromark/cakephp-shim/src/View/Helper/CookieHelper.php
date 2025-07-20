<?php

namespace Shim\View\Helper;

use Cake\View\Helper;
use InvalidArgumentException;

/**
 * Cookie Helper.
 */
class CookieHelper extends Helper {

	/**
	 * Return all cookie names available.
	 *
	 * @return array<string>
	 */
	public function getCookies(): array {
		$cookies = $this->_View->getRequest()->getCookieParams();
		if (!$cookies) {
			return [];
		}

		return array_keys($cookies);
	}

	/**
	 * Reads a cookie value for a key or return values for all keys.
	 *
	 * In your view: `$this->Cookie->read('key');`
	 *
	 * @param string|null $key The name of the cookie key you want to read
	 * @param string|null $default
	 * @return mixed Values from the cookie vars
	 */
	public function read(?string $key = null, ?string $default = null): mixed {
		if ($key === null) {
			throw new InvalidArgumentException('key required');
		}

		return $this->_View->getRequest()->getCookie($key, $default);
	}

	/**
	 * Checks if a cookie key has been set.
	 *
	 * In your view: `$this->Cookie->check('key');`
	 *
	 * @param string $key Cookie name to check.
	 * @return bool
	 */
	public function check(string $key): bool {
		return $this->_View->getRequest()->getCookie($key) !== null;
	}

	/**
	 * Event listeners.
	 *
	 * @return array
	 */
	public function implementedEvents(): array {
		return [];
	}

}
