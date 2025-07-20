<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<!-- Header -->
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
				<?= $this->Form->postLink(
					__('Delete'),
					['action' => 'delete', $supervisor->id],
					['confirm' => __('Are you sure you want to delete # {0}?', $supervisor->id), 'class' => 'dropdown-item', 'escapeTitle' => false]
				) ?>
				<?= $this->Html->link(__('List Supervisors'), ['action' => 'index'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?>
			</div>
		</div>
	</div>
</div>
<div class="line mb-4"></div>
<!-- /Header -->

<!-- Form Card -->
<div class="card rounded-0 bg-dark text-white shadow mb-3 border-0">
	<div class="card-body">
		<?= $this->Form->create($supervisor) ?>
		<fieldset>
			<legend class="text-warning"><?= __('Edit Supervisor') ?></legend>

			<div class="row">
				<div class="col-md-6 mb-3">
					<?= $this->Form->control('company_id', [
						'label' => 'Company',
						'options' => $companies,
						'empty' => '-- Select Company --',
						'class' => 'form-select'
					]) ?>
				</div>
				<div class="col-md-6 mb-3">
					<?= $this->Form->control('name', ['label' => 'Full Name']) ?>
				</div>
				<div class="col-md-6 mb-3">
					<?= $this->Form->control('phone', ['label' => 'Phone Number']) ?>
				</div>
				<div class="col-md-6 mb-3">
					<?= $this->Form->control('email', ['label' => 'Email Address']) ?>
				</div>
				<div class="col-md-6 mb-3">
					<?= $this->Form->control('department', ['label' => 'Department']) ?>
				</div>
				<div class="col-md-6 mb-3">
					<?= $this->Form->control('status', [
						'type' => 'select',
						'label' => 'Status',
						'options' => ['1' => 'Active', '0' => 'Inactive'],
						'empty' => '-- Select Status --',
						'class' => 'form-select'
					]) ?>
				</div>
			</div>
		</fieldset>

		<div class="text-end mt-4">
			<?= $this->Form->button('Reset', ['type' => 'reset', 'class' => 'btn btn-outline-warning me-2']) ?>
			<?= $this->Form->button(__('Submit'), ['type' => 'submit', 'class' => 'btn btn-outline-light']) ?>
		</div>
		<?= $this->Form->end() ?>
	</div>
</div>
