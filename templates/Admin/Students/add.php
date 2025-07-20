<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
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
            <?= $this->Html->link(__('List Students'), ['action' => 'index'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?>
				</div>
		</div>
    </div>
</div>
<div class="line mb-4"></div>
<!--/Header-->

<div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow">
    <div class="card-body text-body-secondary">
<?= $this->Form->create($student) ?>
<fieldset>
    <legend><?= __('Add Student') ?></legend>

    <?= $this->Form->control('name'); ?>
    <?= $this->Form->control('email'); ?>
    <?= $this->Form->control('phone'); ?>
    <?= $this->Form->control('program'); ?>

    <!-- Semester Dropdown (4 to 8) -->
    <?= $this->Form->control('semester', [
        'options' => ['4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8'],
        'empty' => 'Select Semester'
    ]); ?>

    <!-- Faculty Dropdown (UITM) -->
    <?= $this->Form->control('faculty', [
        'options' => [
            'Faculty of Applied Sciences' => 'Faculty of Applied Sciences',
            'Faculty of Business and Management' => 'Faculty of Business and Management',
            'Faculty of Computer and Mathematical Sciences' => 'Faculty of Computer and Mathematical Sciences',
            'Faculty of Communication and Media Studies' => 'Faculty of Communication and Media Studies',
            'Faculty of Education' => 'Faculty of Education',
            'Faculty of Engineering' => 'Faculty of Engineering',
            'Faculty of Health Sciences' => 'Faculty of Health Sciences',
            'Faculty of Law' => 'Faculty of Law',
            'Faculty of Medicine' => 'Faculty of Medicine',
            'Faculty of Pharmacy' => 'Faculty of Pharmacy',
            'Faculty of Sport Science and Recreation' => 'Faculty of Sport Science and Recreation',
            'Faculty of Music' => 'Faculty of Music',
        ],
        'empty' => 'Select Faculty'
    ]); ?>

    <?= $this->Form->control('resume'); ?>

    <!-- Status Dropdown -->
    <?= $this->Form->control('status', [
        'options' => [
            'Active' => 'Active',
            'Graduated' => 'Graduated',
            'Inactive' => 'Inactive',
        ],
        'empty' => 'Select Status'
    ]); ?>

</fieldset>
<div class="text-end">
    <?= $this->Form->button('Reset', ['type' => 'reset', 'class' => 'btn btn-outline-warning']); ?>
    <?= $this->Form->button(__('Submit'), ['type' => 'submit', 'class' => 'btn btn-outline-primary']) ?>
</div>
<?= $this->Form->end() ?>

    </div>
</div>