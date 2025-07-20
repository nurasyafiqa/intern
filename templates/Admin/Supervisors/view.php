<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
 */
?>
<!-- Header -->
<div class="row text-body-secondary">
    <div class="col-10">
        <h1 class="my-0 page_title"><?= h($supervisor->name) ?></h1>
        <h6 class="sub_title text-body-secondary">Supervisor Details</h6>
    </div>
    <div class="col-2 text-end">
        <div class="dropdown mx-3 mt-2">
            <button class="btn p-0 border-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-bars text-primary"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li><?= $this->Html->link(__('Edit Supervisor'), ['action' => 'edit', $supervisor->id], ['class' => 'dropdown-item']) ?></li>
                <li><?= $this->Form->postLink(__('Delete Supervisor'), ['action' => 'delete', $supervisor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $supervisor->id), 'class' => 'dropdown-item']) ?></li>
                <li><hr class="dropdown-divider"></li>
                <li><?= $this->Html->link(__('List Supervisors'), ['action' => 'index'], ['class' => 'dropdown-item']) ?></li>
                <li><?= $this->Html->link(__('New Supervisor'), ['action' => 'add'], ['class' => 'dropdown-item']) ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="line mb-4"></div>
<!-- /Header -->

<div class="row">
    <div class="col-md-9">
        <div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow-sm">
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th><?= __('Supervisor') ?></th>
                        <td><?= $supervisor->supervisor ? $this->Html->link($supervisor->supervisor->name, ['controller' => 'Supervisors', 'action' => 'view', $supervisor->supervisor->id]) : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Name') ?></th>
                        <td><?= h($supervisor->name) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Email') ?></th>
                        <td><?= h($supervisor->email) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Phone') ?></th>
                        <td><?= h($supervisor->phone) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Department') ?></th>
                        <td><?= h($supervisor->department) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Status') ?></th>
                        <td>
                            <?php
                            switch ($supervisor->status) {
                                case 0:
                                    echo '<span class="badge text-bg-danger">Disabled</span>';
                                    break;
                                case 1:
                                    echo '<span class="badge text-bg-success">Active</span>';
                                    break;
                                case 2:
                                    echo '<span class="badge text-bg-secondary">Archived</span>';
                                    break;
                                default:
                                    echo '<span class="badge text-bg-light">Unknown</span>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('ID') ?></th>
                        <td><?= $this->Number->format($supervisor->id) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Created') ?></th>
                        <td><?= h($supervisor->created) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modified') ?></th>
                        <td><?= h($supervisor->modified) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <?php if (!empty($supervisor->employees)) : ?>
        <div class="card rounded-0 mb-3 bg-body border-0 shadow-sm">
            <div class="card-header bg-light">
                <strong>Employees under <?= h($supervisor->name) ?></strong>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('Name') ?></th>
                                <th><?= __('Email') ?></th>
                                <th><?= __('Phone') ?></th>
                                <th><?= __('Action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($supervisor->employees as $employee) : ?>
                            <tr>
                                <td><?= h($employee->id) ?></td>
                                <td><?= h($employee->name) ?></td>
                                <td><?= h($employee->email) ?></td>
                                <td><?= h($employee->phone) ?></td>
                                <td>
                                    <?= $this->Html->link('View', ['controller' => 'Employees', 'action' => 'view', $employee->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="col-md-3">
        <!-- Optional: Add supervisor card/profile summary or related links here -->
        <div class="card rounded-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fa-solid fa-user-tie fa-4x mb-3 text-muted"></i>
                <h5 class="card-title"><?= h($supervisor->name) ?></h5>
                <p class="card-text"><?= h($supervisor->department) ?></p>
                <span class="badge bg-info"><?= h($supervisor->email) ?></span>
            </div>
        </div>
    </div>
</div>
