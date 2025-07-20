<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Application $application
 * @var \Cake\Collection\CollectionInterface|string[] $students
 * @var \Cake\Collection\CollectionInterface|string[] $company
 */
?>
<!--Header-->
<div class="row text-body-secondary">
    <div class="col-10">
        <h1 class="my-0 page_title"><?php echo $title; ?></h1>
        <h6 class="sub_title text-body-secondary"><?php echo $system_name; ?></h6>
    </div>
    <div class="col-2 text-end">
        <div class="dropdown mx-3 mt-2">
            <button class="btn p-0 border-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-bars text-primary"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                <?= $this->Html->link(__('List Applications'), ['action' => 'index'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?>
            </div>
        </div>
    </div>
</div>
<div class="line mb-4"></div>
<!--/Header-->

<div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow">
    <div class="card-body text-body-secondary">
        <?= $this->Form->create($application) ?>
        <fieldset>
            <legend><?= __('Add Application') ?></legend>

            <div class="row mb-3">
                <!-- Student Dropdown -->
                <div class="col-md-6">
                    <?= $this->Form->control('student_id', [
                        'options' => $students,  
                        'empty' => 'Select a Student',
                        'class' => 'form-control'
                    ]); ?>
                </div>

                <!-- company Dropdown -->
                <div class="col-md-6">
                    <?= $this->Form->control('company_id', [
                        'options' => $company,
                        'empty' => 'Select a company',
                        'class' => 'form-control'
                    ]); ?>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Status Dropdown (Active/Inactive) -->
                <div class="col-md-6">
                    <?= $this->Form->control('status', [
                        'type' => 'select',  
                        'options' => [
                            1 => 'Active',   
                            0 => 'Inactive'
                        ],
                        'empty' => 'Select Status',
                        'class' => 'form-control'
                    ]); ?>
                </div>

                <!-- Application Date -->
                <div class="col-md-6">
                    <?= $this->Form->control('application_date', ['class' => 'form-control']); ?>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Start Date -->
                <div class="col-md-6">
                    <?= $this->Form->control('start_date', ['class' => 'form-control']); ?>
                </div>

                <!-- End Date -->
                <div class="col-md-6">
                    <?= $this->Form->control('end_date', ['class' => 'form-control']); ?>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Company Name -->
                <div class="col-md-12">
                    <?= $this->Form->control('company_name', ['class' => 'form-control']); ?>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Company Address 1 -->
                <div class="col-md-12">
                    <?= $this->Form->control('company_address1', ['class' => 'form-control']); ?>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Company Address 2 -->
                <div class="col-md-12">
                    <?= $this->Form->control('company_address2', ['class' => 'form-control']); ?>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Postcode -->
                <div class="col-md-6">
                    <?= $this->Form->control('postcode', ['class' => 'form-control']); ?>
                </div>

                <!-- City -->
                <div class="col-md-6">
                    <?= $this->Form->control('city', ['class' => 'form-control']); ?>
                </div>
            </div>

            <div class="row mb-3">
                <!-- State -->
                <div class="col-md-6">
                    <?= $this->Form->control('state', ['class' => 'form-control']); ?>
                </div>

                <!-- Contact Person -->
                <div class="col-md-6">
                    <?= $this->Form->control('contact_person', ['class' => 'form-control']); ?>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Email -->
                <div class="col-md-6">
                    <?= $this->Form->control('email', ['class' => 'form-control']); ?>
                </div>

                <!-- Phone -->
                <div class="col-md-6">
                    <?= $this->Form->control('phone', ['class' => 'form-control']); ?>
                </div>
            </div>

        </fieldset>

        <div class="text-end">
            <?= $this->Form->button('Reset', ['type' => 'reset', 'class' => 'btn btn-outline-warning']); ?>
            <?= $this->Form->button(__('Submit'), ['type' => 'submit', 'class' => 'btn btn-outline-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
