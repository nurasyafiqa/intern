<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
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
            <?= $this->Html->link(__('List Companies'), ['action' => 'index'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?>
				</div>
		</div>
    </div>
</div>
<div class="line mb-4"></div>
<!--/Header-->

<div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow">
    <div class="card-body text-body-secondary">
        <?= $this->Form->create($company) ?>
        <fieldset>
            <legend><?= __('Add Company') ?></legend>

            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <?= $this->Form->control('name', ['class' => 'form-control']) ?>
                    <?= $this->Form->control('email', ['class' => 'form-control']) ?>
                    <?= $this->Form->control('address_line_1', ['class' => 'form-control']) ?>
                    <?= $this->Form->control('postcode', ['class' => 'form-control']) ?>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <?= $this->Form->control('address_line_2', ['class' => 'form-control']) ?>
                    <?= $this->Form->control('city', ['class' => 'form-control']) ?>
                    <?= $this->Form->control('state', ['class' => 'form-control']) ?>

                <!-- Dropdown for status -->
                <div class="form-group">
                        <label for="status">Status</label>
                        <?= $this->Form->select('status', ['Active' => 'Active', 'Inactive' => 'Inactive'], ['class' => 'form-control', 'id' => 'status']) ?>
                    </div>
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
