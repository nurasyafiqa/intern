<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Application $application
 * @var string[]|\Cake\Collection\CollectionInterface $students
 * @var string[]|\Cake\Collection\CollectionInterface $comapany
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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $application->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $application->id), 'class' => 'dropdown-item', 'escapeTitle' => false]
            ) ?>
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
                <legend><?= __('Edit Application') ?></legend>
                
                    <?php echo $this->Form->control('student_id', ['options' => $students, 'empty' => 'Please select']); ?>
                    <?php echo $this->Form->control('company_id', ['options' => $company, 'empty' => 'Please select']); ?>
                    <?php echo $this->Form->control('application_date', ['type' => 'text', 'id' => 'application_date']); ?>
            <?php echo $this->Form->control('start_date', ['type' => 'text', 'id' => 'start_date']); ?>
            <?php echo $this->Form->control('end_date', ['type' => 'text', 'id' => 'end_date']); ?>
                    <?php echo $this->Form->control('company_name'); ?>
                    <?php echo $this->Form->control('company_address1'); ?>
                    <?php echo $this->Form->control('company_address2'); ?>
                    <?php echo $this->Form->control('postcode'); ?>
                    <?php echo $this->Form->control('city'); ?>
                    <?php echo $this->Form->control('state'); ?>
                    <?php echo $this->Form->control('contact_person'); ?>
                    <?php echo $this->Form->control('email'); ?>
                    <?php echo $this->Form->control('phone'); ?>
                    <?php echo $this->Form->control('status'); ?>
               
            </fieldset>
				<div class="text-end">
				  <?= $this->Form->button('Reset', ['type' => 'reset', 'class' => 'btn btn-outline-warning']); ?>
				  <?= $this->Form->button(__('Submit'),['type' => 'submit', 'class' => 'btn btn-outline-primary']) ?>
                </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<!-- Masukkan Skrip untuk Datepicker -->
<?= $this->Html->css('https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.4/jquery.datetimepicker.min.css') ?>
<?= $this->Html->script('https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js') ?>
<?= $this->Html->script('https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.4/jquery.datetimepicker.full.min.js') ?>

<script>
    $(document).ready(function() {
        $('#application_date, #start_date, #end_date').datetimepicker({
            format: 'Y-m-d',
            timepicker: false
        });
    });
</script>