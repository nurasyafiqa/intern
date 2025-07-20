<?php

namespace Tools\Test\TestCase\Controller\Admin;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Shim\TestSuite\TestCase;
use Tools\View\Icon\BootstrapIcon;

/**
 * @uses \Tools\Controller\Admin\IconsController
 */
class IconsControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @return void
	 */
	public function testIcons() {
		$this->disableErrorHandlerMiddleware();

		Configure::write('Icon', [
			'sets' => [
				'bs' => BootstrapIcon::class,
			],
		]);
		$this->get(['prefix' => 'Admin', 'plugin' => 'Tools', 'controller' => 'Icons', 'action' => 'index']);

		$this->assertResponseCode(200);
	}

}
