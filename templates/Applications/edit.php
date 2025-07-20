<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Application $application
 * @var string[]|\Cake\Collection\CollectionInterface $students
 * @var string[]|\Cake\Collection\CollectionInterface $supervisors
 * @var string[]|\Cake\Collection\CollectionInterface $companies
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
                
                    <?php echo $this->Form->control('student_id', ['options' => $students]); ?>
                    <?php echo $this->Form->control('supervisor_id', ['options' => $supervisors]); ?>
                    <?php echo $this->Form->control('company_id', ['options' => $companies]); ?>
                    <?php echo $this->Form->control('application_date'); ?>
                    <?php echo $this->Form->control('start_date'); ?>
                    <?php echo $this->Form->control('end_date'); ?>
                    <?php echo $this->Form->control('pa_name'); ?>
                    <?php echo $this->Form->control('pa_phone'); ?>
                    <?php echo $this->Form->control('pa_email'); ?>
                    <?php echo $this->Form->control('pa_position'); ?>
                    <?php echo $this->Form->control('status'); ?>
               
            </fieldset>
				<div class="text-end">
				  <?= $this->Form->button('Reset', ['type' => 'reset', 'class' => 'btn btn-outline-warning']); ?>
				  <?= $this->Form->button(__('Submit'),['type' => 'submit', 'class' => 'btn btn-outline-primary']) ?>
                </div>
        <?= $this->Form->end() ?>
    </div>
</div>