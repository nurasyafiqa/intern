<?php

namespace Tools\Test\TestCase\Model\Behavior;

use Shim\TestSuite\TestCase;
use Tools\Model\Behavior\TypeMapBehavior;
use Tools\Model\Table\Table;

class TypeMapBehaviorTest extends TestCase {

	/**
	 * @var array
	 */
	protected array $fixtures = [
		'plugin.Tools.Data',
	];

	/**
	 * @var \Tools\Model\Behavior\TypeMapBehavior
	 */
	protected TypeMapBehavior $TypeMapBehavior;

	/**
	 * @var \Tools\Model\Table\Table
	 */
	protected Table $Table;

	/**
	 * Tests that we can disable array conversion for edit forms if we need to modify the JSON directly.
	 *
	 * @return void
	 */
	public function testFields() {
		$this->Table = $this->getTableLocator()->get('Data');
		$this->Table->addBehavior('Tools.Jsonable', ['fields' => ['data_array']]);

		$entity = $this->Table->newEmptyEntity();

		$data = [
			'name' => 'FooBar',
			'data_json' => ['x' => 'y'],
			'data_array' => ['x' => 'y'],
		];
		$entity = $this->Table->patchEntity($entity, $data);
		$this->assertEmpty($entity->getErrors());

		$this->Table->saveOrFail($entity);
		$this->assertSame($data['data_json'], $entity->data_json);
		$this->assertSame('{"x":"y"}', $entity->data_array);

		$savedEntity = $this->Table->get($entity->id);

		$this->assertSame($data['data_json'], $savedEntity->data_json);
		$this->assertSame($data['data_array'], $savedEntity->data_array);

		// Now let's disable the array conversion per type
		$this->Table->removeBehavior('Jsonable');
		$this->Table->addBehavior('Tools.TypeMap', ['fields' => ['data_json' => 'text']]);
		$entity = $this->Table->get($entity->id);

		$this->assertSame('{"x":"y"}', $entity->data_json);
		$this->assertSame('{"x":"y"}', $entity->data_array);

		$data = [
			'data_json' => '{"x":"z"}',
			'data_array' => '{"x":"z"}',
		];
		$entity = $this->Table->patchEntity($entity, $data);
		$this->Table->saveOrFail($entity);

		$savedEntity = $this->Table->get($entity->id);
		$this->assertSame($data['data_json'], $savedEntity->data_json);
		$this->assertSame($data['data_array'], $savedEntity->data_array);
	}

}
