<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Application $application
 * @var \Cake\Collection\CollectionInterface|string[] $students
 * @var \Cake\Collection\CollectionInterface|string[] $supervisors
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<!--Header-->
<div class="row text-body-secondary">
    <div class="col-10">
        <h1 class="my-0 page_title"><?= h($title) ?></h1>
        <h6 class="sub_title text-body-secondary"><?= h($system_name) ?></h6>
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
            <legend class="mb-3"><?= __('Add Application') ?></legend>

            <?= $this->Form->control('student_id', [
                'options' => $students,
                'empty' => 'Select Student',
                'label' => 'Student'
            ]) ?>

            <?= $this->Form->control('supervisor_id', [
                'options' => $supervisors,
                'empty' => 'Select Supervisor',
                'label' => 'Supervisor'
            ]) ?>

            <?= $this->Form->control('company_id', [
                'options' => $companies,
                'empty' => 'Select Company',
                'label' => 'Company'
            ]) ?>

            <?= $this->Form->control('application_date', [
                'label' => 'Application Date',
                'type' => 'date'
            ]) ?>

            <?= $this->Form->control('start_date', [
                'label' => 'Start Date',
                'type' => 'date'
            ]) ?>

            <?= $this->Form->control('end_date', [
                'label' => 'End Date',
                'type' => 'date'
            ]) ?>

            <?= $this->Form->control('pa_name', [
                'label' => 'PA Name',
                'placeholder' => 'e.g. John Doe'
            ]) ?>

            <?= $this->Form->control('pa_phone', [
                'label' => 'PA Phone',
                'placeholder' => 'e.g. 0123456789'
            ]) ?>

            <?= $this->Form->control('pa_email', [
                'label' => 'PA Email',
                'placeholder' => 'e.g. pa@example.com'
            ]) ?>

            <?= $this->Form->control('pa_position', [
                'label' => 'PA Position',
                'placeholder' => 'e.g. HR Manager'
            ]) ?>

            <?= $this->Form->control('status', [
                'label' => 'Status',
                'placeholder' => 'e.g. Pending'
            ]) ?>
        </fieldset>

        <div class="text-end mt-4">
            <?= $this->Form->button('Reset', ['type' => 'reset', 'class' => 'btn btn-outline-warning']) ?>
            <?= $this->Form->button(__('Submit'), ['type' => 'submit', 'class' => 'btn btn-outline-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
