<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ApplicationsFixture
 */
class ApplicationsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'student_id' => 1,
                'supervisor_id' => 1,
                'company_id' => 1,
                'application_date' => '2025-07-20',
                'start_date' => '2025-07-20',
                'end_date' => '2025-07-20',
                'pa_name' => 'Lorem ipsum dolor sit amet',
                'pa_phone' => 'Lorem ipsum dolor ',
                'pa_email' => 'Lorem ipsum dolor sit amet',
                'pa_position' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-07-20 14:50:52',
                'modified' => '2025-07-20 14:50:52',
            ],
        ];
        parent::init();
    }
}
