<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Companies Model
 *
 * @property \App\Model\Table\ApplicationsTable&\Cake\ORM\Association\HasMany $Applications
 * @property \App\Model\Table\SupervisorsTable&\Cake\ORM\Association\HasMany $Supervisors
 *
 * @method \App\Model\Entity\Company newEmptyEntity()
 * @method \App\Model\Entity\Company newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Company> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Company get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Company findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Company patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Company> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Company|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Company saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Company>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Company>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Company>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Company> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Company>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Company>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Company>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Company> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CompaniesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('companies');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('AuditStash.AuditLog');
        $this->addBehavior('Search.Search');

        // Proper hasMany with cascade delete enabled
        $this->hasMany('Applications', [
            'foreignKey' => 'company_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);

        $this->hasMany('Supervisors', [
            'foreignKey' => 'company_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);

        // Search manager
        $this->searchManager()
            ->value('id')
            ->add('search', 'Search.Like', [
                'fieldMode' => 'OR',
                'multiValue' => true,
                'multiValueSeparator' => '|',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['id'],
            ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('address_line_1')
            ->maxLength('address_line_1', 255)
            ->notEmptyString('address_line_1');

        $validator
            ->scalar('address_line_2')
            ->maxLength('address_line_2', 255)
            ->requirePresence('address_line_2', 'create')
            ->notEmptyString('address_line_2');

        $validator
            ->scalar('postcode')
            ->maxLength('postcode', 10)
            ->requirePresence('postcode', 'create')
            ->notEmptyString('postcode');

        $validator
            ->scalar('city')
            ->maxLength('city', 100)
            ->requirePresence('city', 'create')
            ->notEmptyString('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 100)
            ->requirePresence('state', 'create')
            ->notEmptyString('state');

        $validator
            ->scalar('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        return $validator;
    }
}
