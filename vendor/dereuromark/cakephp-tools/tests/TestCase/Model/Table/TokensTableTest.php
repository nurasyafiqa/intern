<?php

namespace Tools\Test\TestCase\Model\Table;

use Shim\TestSuite\TestCase;
use Tools\Model\Table\TokensTable;

class TokensTableTest extends TestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Tools.Tokens',
	];

	/**
	 * @var \Tools\Model\Table\TokensTable
	 */
	protected $Tokens;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->Tokens = $this->getTableLocator()->get('Tools.Tokens');
	}

	/**
	 * @return void
	 */
	public function tearDown(): void {
		$this->getTableLocator()->clear();

		parent::tearDown();
	}

	/**
	 * @return void
	 */
	public function testTokenInstance() {
		$this->assertInstanceOf(TokensTable::class, $this->Tokens);
	}

	/**
	 * @return void
	 */
	public function testGenerateKey() {
		$key = $this->Tokens->generateKey(4);
		$this->assertTrue(!empty($key) && strlen($key) === 4);
	}

	/**
	 * @return void
	 */
	public function testNewKeySpendKey() {
		$key = $this->Tokens->newKey('test', null, null, 'xyz');
		$this->assertTrue(!empty($key));

		$res = $this->Tokens->useKey('test', $key);
		$this->assertTrue(!empty($res));

		$res = $this->Tokens->useKey('test', $key);
		$this->assertTrue(!empty($res) && !empty($res->used));

		$res = $this->Tokens->useKey('test', $key . 'x');
		$this->assertNull($res);

		$res = $this->Tokens->useKey('testx', $key);
		$this->assertNull($res);
	}

	/**
	 * @return void
	 */
	public function testGarbageCollector() {
		$data = [
			'created' => date(FORMAT_DB_DATETIME, time() - 3 * MONTH),
			'type' => 'y',
			'token' => 'x',
		];
		$entity = $this->Tokens->newEntity($data, ['validate' => false]);
		$this->Tokens->save($entity);
		$count = $this->Tokens->find()->count();
		$this->Tokens->garbageCollector();
		$count2 = $this->Tokens->find()->count();
		$this->assertTrue($count > $count2);
	}

}
