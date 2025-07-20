<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
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
                <li><?= $this->Html->link(__('Edit Company'), ['action' => 'edit', $company->id], ['class' => 'dropdown-item']) ?></li>
                <li><?= $this->Form->postLink(__('Delete Company'), ['action' => 'delete', $company->id], ['confirm' => __('Are you sure?'), 'class' => 'dropdown-item']) ?></li>
                <li><hr class="dropdown-divider"></li>
                <li><?= $this->Html->link(__('List Companies'), ['action' => 'index'], ['class' => 'dropdown-item']) ?></li>
                <li><?= $this->Html->link(__('New Company'), ['action' => 'add'], ['class' => 'dropdown-item']) ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="line mb-4 border-bottom border-warning"></div>

<!-- Main Content -->
<div class="row">
    <div class="col-lg-9">
        <!-- Company Info -->
        <div class="card bg-dark text-light border-warning border-2 shadow rounded-0 mb-4">
            <div class="card-body">
                <h4 class="text-warning"><i class="fa-solid fa-building me-2"></i><?= h($company->name) ?></h4>
                <table class="table table-dark table-bordered align-middle">
                    <tr><th>Name</th><td><?= h($company->name) ?></td></tr>
                    <tr><th>Email</th><td><?= h($company->email) ?></td></tr>
                    <tr><th>Address Line 1</th><td><?= h($company->address_line_1) ?></td></tr>
                    <tr><th>Address Line 2</th><td><?= h($company->address_line_2) ?></td></tr>
                    <tr><th>Postcode</th><td><?= h($company->postcode) ?></td></tr>
                    <tr><th>City</th><td><?= h($company->city) ?></td></tr>
                    <tr><th>State</th><td><?= h($company->state) ?></td></tr>
                    <tr><th>Status</th>
                        <td>
                            <?= $company->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' ?>
                        </td>
                    </tr>
                     <th>Created</th>
    <td><?= $company->created->format('d M Y') ?></td>
</tr>
<tr>
    <th>Modified</th>
    <td><?= $company->modified->format('d M Y') ?></td>
</tr>
                </table>
            </div>
        </div>

        <!-- Related Applications -->
        <div class="card bg-dark text-light border-warning border-2 shadow rounded-0 mb-4">
            <div class="card-body">
                <h5 class="text-warning mb-3"><i class="fa-solid fa-clipboard-list me-2"></i>Related Applications</h5>
                <?php if (!empty($company->applications)) : ?>
                    <div class="table-responsive">
                        <table class="table table-dark table-striped table-bordered align-middle">
                            <thead class="table-warning text-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Supervisor</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($company->applications as $app) : ?>
                                <tr>
                                    <td><?= h($app->id) ?></td>
                                    <td><?= h($app->student_id) ?></td>
                                    <td><?= h($app->supervisor_id) ?></td>
                                    <td><?= h($app->start_date) ?></td>
                                    <td><?= h($app->end_date) ?></td>
                                    <td><?= h($app->status) ?></td>
                                    <td class="text-center">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Applications', 'action' => 'view', $app->id], ['class' => 'btn btn-sm btn-outline-primary me-1']) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Applications', 'action' => 'edit', $app->id], ['class' => 'btn btn-sm btn-outline-warning me-1']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Applications', 'action' => 'delete', $app->id], ['confirm' => __('Are you sure?'), 'class' => 'btn btn-sm btn-outline-danger']) ?>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <p class="text-muted">No applications available.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Related Supervisors -->
        <div class="card bg-dark text-light border-warning border-2 shadow rounded-0 mb-4">
            <div class="card-body">
                <h5 class="text-warning mb-3"><i class="fa-solid fa-chalkboard-user me-2"></i>Related Supervisors</h5>
                <?php if (!empty($company->supervisors)) : ?>
                    <div class="table-responsive">
                        <table class="table table-dark table-bordered align-middle">
                            <thead class="table-warning text-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($company->supervisors as $sup) : ?>
                                <tr>
                                    <td><?= h($sup->id) ?></td>
                                    <td><?= h($sup->phone) ?></td>
                                    <td><?= h($sup->email) ?></td>
                                    <td><?= h($sup->department) ?></td>
                                    <td><?= h($sup->status) ?></td>
                                    <td class="text-center">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Supervisors', 'action' => 'view', $sup->id], ['class' => 'btn btn-sm btn-outline-primary me-1']) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Supervisors', 'action' => 'edit', $sup->id], ['class' => 'btn btn-sm btn-outline-warning me-1']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Supervisors', 'action' => 'delete', $sup->id], ['confirm' => __('Are you sure?'), 'class' => 'btn btn-sm btn-outline-danger']) ?>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <p class="text-muted">No supervisors linked to this company.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Optional Right Column -->
    <div class="col-lg-3">
        <!-- You can place company logo, tags, or badges here -->
    </div>
</div>
