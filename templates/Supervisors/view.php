<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
 */
?>

<!-- Header -->
<div class="row text-light">
    <div class="col-10">
        <h1 class="my-0 page_title"><?= h($title) ?></h1>
        <h6 class="sub_title text-warning"><?= h($system_name) ?></h6>
    </div>
    <div class="col-2 text-end">
        <div class="dropdown mx-3 mt-2">
            <button class="btn p-0 border-0" type="button" data-bs-toggle="dropdown">
                <i class="fa-solid fa-bars text-warning"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><?= $this->Html->link(__('Edit Supervisor'), ['action' => 'edit', $supervisor->id], ['class' => 'dropdown-item']) ?></li>
                <li><?= $this->Form->postLink(__('Delete Supervisor'), ['action' => 'delete', $supervisor->id], ['confirm' => __('Are you sure?'), 'class' => 'dropdown-item']) ?></li>
                <li><hr class="dropdown-divider"></li>
                <li><?= $this->Html->link(__('List Supervisors'), ['action' => 'index'], ['class' => 'dropdown-item']) ?></li>
                <li><?= $this->Html->link(__('New Supervisor'), ['action' => 'add'], ['class' => 'dropdown-item']) ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="line mb-4 border-bottom border-warning"></div>

<!-- Body -->
<div class="row">
    <div class="col-md-9">
        <!-- Supervisor Info Card -->
        <div class="card bg-dark border-warning border-2 rounded-0 shadow mb-4">
            <div class="card-body text-light">
                <h4 class="text-warning mb-4"><i class="fa-solid fa-chalkboard-user me-2"></i><?= h($supervisor->name) ?></h4>
                <div class="table-responsive">
                    <table class="table table-dark table-bordered table-striped align-middle mb-0">
                        <tr><th>Name</th><td><?= h($supervisor->name) ?></td></tr>
                        <tr><th>Company</th>
                            <td>
                                <?= $supervisor->hasValue('company') ? 
                                    $this->Html->link($supervisor->company->name, ['controller' => 'Companies', 'action' => 'view', $supervisor->company->id], ['class' => 'text-warning text-decoration-none']) : '' ?>
                            </td>
                        </tr>
                        <tr><th>Phone</th><td><?= h($supervisor->phone) ?></td></tr>
                        <tr><th>Email</th><td><?= h($supervisor->email) ?></td></tr>
                        <tr><th>Department</th><td><?= h($supervisor->department) ?></td></tr>
                        <tr><th>Status</th>
                            <td>
                                <?= $supervisor->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' ?>
                            </td>
                        </tr>
                        <tr><th>Created</th><td><?= $supervisor->created->format('d M Y') ?></td></tr>
                        <tr><th>Modified</th><td><?= $supervisor->modified->format('d M Y') ?></td></tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Related Applications -->
        <?php if (!empty($supervisor->applications)) : ?>
        <div class="card bg-dark border-warning border-2 rounded-0 shadow mb-4">
            <div class="card-body text-light">
                <h5 class="card-title text-warning"><i class="fa-solid fa-clipboard-list me-2"></i>Related Applications</h5>
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-bordered align-middle">
                        <thead class="table-warning text-dark">
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Company</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>PA Name</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($supervisor->applications as $application) : ?>
                            <tr>
                                <td><?= h($application->id) ?></td>
                                <td><?= h($application->student_id) ?></td>
                                <td><?= h($application->company_id) ?></td>
                                <td><?= h($application->start_date) ?></td>
                                <td><?= h($application->end_date) ?></td>
                                <td><?= h($application->pa_name) ?></td>
                                <td><?= h($application->status) ?></td>
                                <td class="text-center">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Applications', 'action' => 'view', $application->id], ['class' => 'btn btn-sm btn-outline-primary me-1']) ?>
                                    <?= $this->Html->link(__('Edit'), ['controller' => 'Applications', 'action' => 'edit', $application->id], ['class' => 'btn btn-sm btn-outline-warning me-1']) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Applications', 'action' => 'delete', $application->id], ['confirm' => __('Are you sure?'), 'class' => 'btn btn-sm btn-outline-danger']) ?>
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

    <!-- Optional Sidebar -->
    <div class="col-md-3">
        <!-- You may add profile image or tags here -->
    </div>
</div>
