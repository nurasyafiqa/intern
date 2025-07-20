<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Company Entity
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $address_line_1
 * @property string $address_line_2
 * @property string $postcode
 * @property string $city
 * @property string $state
 * @property string $status
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Application[] $applications
 * @property \App\Model\Entity\Supervisor[] $supervisors
 */
class Company extends Entity
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
        'name' => true,
        'email' => true,
        'address_line_1' => true,
        'address_line_2' => true,
        'postcode' => true,
        'city' => true,
        'state' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'applications' => true,
        'supervisors' => true,
    ];
}
