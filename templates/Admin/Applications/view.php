<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Application> $applications
 */
?>

<div class="row text-body-secondary">
    <div class="col-md-8">
        <h1 class="my-0 page_title"><?= __('Applications') ?></h1>
        <h6 class="sub_title"><?= h($system_name ?? 'System') ?></h6>
    </div>
    <div class="col-md-4 text-end">
        <?= $this->Html->link(__('New Application'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
        <?= $this->Html->link(__('Export PDF'), ['action' => 'pdfList'], ['class' => 'btn btn-danger mx-1']) ?>
    </div>
</div>
<div class="line mb-3"></div>

<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <?= $this->Form->create(null, ['type' => 'get']) ?>
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <?= $this->Form->control('id', ['label' => 'ID', 'class' => 'form-control', 'value' => $this->request->getQuery('id')]) ?>
            </div>
            <div class="col-md-3">
                <?= $this->Form->control('department_id', [
                    'label' => 'Department',
                    'options' => $departments,
                    'empty' => 'All',
                    'class' => 'form-select',
                    'value' => $this->request->getQuery('department_id')
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= $this->Form->control('status', [
                    'label' => 'Status',
                    'options' => ['Pending' => 'Pending', 'Approved' => 'Approved', 'Rejected' => 'Rejected'],
                    'empty' => 'All',
                    'class' => 'form-select',
                    'value' => $this->request->getQuery('status')
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= $this->Form->control('search', ['label' => 'Keyword', 'class' => 'form-control', 'placeholder' => 'Company name, city, etc.', 'value' => $this->request->getQuery('search')]) ?>
            </div>
            <div class="col-md-12 mt-2 text-end">
                <?= $this->Form->button(__('Search'), ['class' => 'btn btn-primary']) ?>
                <?php if (!empty($isSearch)) : ?>
                    <?= $this->Html->link(__('Reset'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
                <?php endif; ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= __('Student') ?></th>
                    <th><?= __('Department') ?></th>
                    <th><?= __('Company Name') ?></th>
                    <th><?= __('Status') ?></th>
                    <th><?= __('Application Date') ?></th>
                    <th class="text-end"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $application): ?>
                <tr>
                    <td><?= h($application->id) ?></td>
                    <td><?= h($application->student->name ?? '-') ?></td>
                    <td><?= h($application->department->name ?? '-') ?></td>
                    <td><?= h($application->company_name) ?></td>
                    <td><?= h($application->status) ?></td>
                    <td><?= h($application->application_date->format('Y-m-d')) ?></td>
                    <td class="text-end">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $application->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $application->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $application->id], [
                            'confirm' => __('Are you sure you want to delete # {0}?', $application->id),
                            'class' => 'btn btn-sm btn-outline-danger'
                        ]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total')) ?>
            </div>
            <div>
                <?= $this->Paginator->prev('< ' . __('Previous'), ['class' => 'btn btn-outline-secondary']) ?>
                <?= $this->Paginator->numbers(['class' => 'pagination']) ?>
                <?= $this->Paginator->next(__('Next') . ' >', ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>
    </div>
</div>
