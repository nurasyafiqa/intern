<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 */
?>
<!--Header-->
<div class="row text-body-secondary">
	<div class="col-10">
		<h1 class="my-0 page_title text-white"><?= h($title) ?></h1>
		<h6 class="sub_title text-warning"><?= h($system_name) ?></h6>
	</div>
	<div class="col-2 text-end">
		<div class="dropdown mx-3 mt-2">
			<button class="btn p-0 border-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fa-solid fa-bars text-warning"></i>
			</button>
			<div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
				<?= $this->Form->postLink(
					__('Delete'),
					['action' => 'delete', $student->id],
					['confirm' => __('Are you sure you want to delete # {0}?', $student->id), 'class' => 'dropdown-item', 'escapeTitle' => false]
				) ?>
				<?= $this->Html->link(__('List Students'), ['action' => 'index'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?>
			</div>
		</div>
	</div>
</div>
<div class="line mb-4"></div>
<!--/Header-->

<div class="card rounded-0 mb-3 bg-dark border-0 shadow text-white">
    <div class="card-body">
        <?= $this->Form->create($student) ?>
        <fieldset>
            <legend class="text-warning"><?= __('Edit Student') ?></legend>

            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <?= $this->Form->control('name', [
                        'label' => ['class' => 'text-warning'],
                        'class' => 'form-control bg-dark text-white border-warning'
                    ]) ?>
                    <?= $this->Form->control('phone', [
                        'class' => 'form-control bg-dark text-white border-secondary'
                    ]) ?>
                    <?= $this->Form->control('email', [
                        'class' => 'form-control bg-dark text-white border-secondary'
                    ]) ?>
                    <?= $this->Form->control('program', [
                        'class' => 'form-control bg-dark text-white border-secondary'
                    ]) ?>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <!-- Semester Dropdown -->
                    <div class="mb-3">
                        <label for="semester" class="form-label text-warning">Semester</label>
                        <?= $this->Form->select('semester', [
                            '4' => 'Semester 4',
                            '5' => 'Semester 5',
                            '6' => 'Semester 6',
                            '7' => 'Semester 7',
                            '8' => 'Semester 8'
                        ], ['class' => 'form-select bg-dark text-white border-secondary', 'empty' => '-- Select Semester --']) ?>
                    </div>

                    <?= $this->Form->control('resume', [
                        'class' => 'form-control bg-dark text-white border-secondary'
                    ]) ?>

                    <!-- Status Dropdown -->
                    <div class="mb-3">
                        <label for="status" class="form-label text-warning">Status</label>
                        <?= $this->Form->select('status', [
                            'Active' => 'Active',
                            'Inactive' => 'Inactive'
                        ], ['class' => 'form-select bg-dark text-white border-secondary', 'empty' => '-- Select Status --']) ?>
                    </div>
                </div>
            </div>
        </fieldset>

        <div class="text-end mt-3">
            <?= $this->Form->button('Reset', ['type' => 'reset', 'class' => 'btn btn-outline-warning']) ?>
            <?= $this->Form->button(__('Submit'), ['type' => 'submit', 'class' => 'btn btn-warning']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
