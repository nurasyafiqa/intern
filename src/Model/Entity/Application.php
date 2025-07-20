<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Application Entity
 *
 * @property int $id
 * @property int $student_id
 * @property int $supervisor_id
 * @property int $company_id
 * @property \Cake\I18n\Date $application_date
 * @property \Cake\I18n\Date $start_date
 * @property \Cake\I18n\Date $end_date
 * @property string $pa_name
 * @property string $pa_phone
 * @property string $pa_email
 * @property string $pa_position
 * @property string $status
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Student $student
 * @property \App\Model\Entity\Supervisor $supervisor
 * @property \App\Model\Entity\Company $company
 */
class Application extends Entity
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
        'student_id' => true,
        'supervisor_id' => true,
        'company_id' => true,
        'application_date' => true,
        'start_date' => true,
        'end_date' => true,
        'pa_name' => true,
        'pa_phone' => true,
        'pa_email' => true,
        'pa_position' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'student' => true,
        'supervisor' => true,
        'company' => true,
    ];
}
