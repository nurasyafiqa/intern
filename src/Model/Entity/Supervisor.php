<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Supervisor Entity
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $department
 * @property string $status
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Application[] $applications
 */
class Supervisor extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'company_id' => true,
        'name' => true,
        'phone' => true,
        'email' => true,
        'department' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'applications' => true,
    ];
}
