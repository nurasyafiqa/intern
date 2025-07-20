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
			<legend class="mb-4"><?= __('Add Student') ?></legend>
			<div class="row">
				<div class="col-md-6 mb-3">
					<?= $this->Form->control('name', [
						'class' => 'form-control bg-dark text-white',
						'label' => 'Full Name'
					]) ?>
				</div>
				<div class="col-md-6 mb-3">
					<?= $this->Form->control('phone', [
						'class' => 'form-control bg-dark text-white'
					]) ?>
				</div>
				<div class="col-md-6 mb-3">
					<?= $this->Form->control('email', [
						'class' => 'form-control bg-dark text-white'
					]) ?>
				</div>
				<div class="col-md-6 mb-3">
					<?= $this->Form->control('program', [
						'class' => 'form-control bg-dark text-white'
					]) ?>
				</div>
				<div class="col-md-6 mb-3">
					<?= $this->Form->control('semester', [
						'type' => 'select',
						'options' => [4 => 'Semester 4', 5 => 'Semester 5', 6 => 'Semester 6', 7 => 'Semester 7', 8 => 'Semester 8'],
						'empty' => '-- Select Semester --',
						'label' => 'Semester',
						'class' => 'form-select bg-dark text-white'
					]) ?>
				</div>
				<div class="col-md-6 mb-3">
					<?= $this->Form->control('status', [
						'type' => 'select',
						'options' => [1 => 'Active', 0 => 'Inactive'],
						'empty' => '-- Select Status --',
						'label' => 'Status',
						'class' => 'form-select bg-dark text-white'
					]) ?>
				</div>
				<div class="col-md-12 mb-3">
					<?= $this->Form->control('resume', [
						'class' => 'form-control bg-dark text-white'
					]) ?>
				</div>
			</div>
		</fieldset>
		<div class="text-end mt-3">
			<?= $this->Form->button('Reset', ['type' => 'reset', 'class' => 'btn btn-outline-warning']) ?>
			<?= $this->Form->button(__('Submit'), ['type' => 'submit', 'class' => 'btn btn-outline-primary']) ?>
		</div>
		<?= $this->Form->end() ?>
	</div>
</div>
