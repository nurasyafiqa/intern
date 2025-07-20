<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Applications Controller
 *
 * @property \App\Model\Table\ApplicationsTable $Applications
 * @method \App\Model\Entity\Application[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ApplicationsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Students');
        $this->loadModel('Companies');
        $this->loadModel('Supervisors');
        $this->loadComponent('Paginator');
    }

    // List all applications
    public function index()
    {
        $this->set('title', 'Applications List');
        $applications = $this->Applications->find('all', [
            'contain' => ['Students', 'Companies', 'Supervisors']
        ]);

        $this->set(compact('applications'));
    }

    // View internship application letter
    public function view($id = null)
    {
        $this->set('title', 'Application Details');

        $application = $this->Applications->get($id, [
            'contain' => ['Students', 'Companies', 'Supervisors'],
        ]);

        $this->set(compact('application'));
    }

    // Add new application
    public function add()
    {
        $this->set('title', 'Add Application');
        $application = $this->Applications->newEmptyEntity();

        if ($this->request->is('post')) {
            $application = $this->Applications->patchEntity($application, $this->request->getData());
            if ($this->Applications->save($application)) {
                $this->Flash->success(__('The application has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The application could not be saved. Please, try again.'));
        }

        $students = $this->Students->find('list', ['limit' => 200])->toArray();
        $companies = $this->Companies->find('list', ['limit' => 200])->toArray();
        $supervisors = $this->Supervisors->find('list', ['limit' => 200])->toArray();

        $this->set(compact('application', 'students', 'companies', 'supervisors'));
    }

    // Edit existing application
    public function edit($id = null)
    {
        $this->set('title', 'Edit Application');

        $application = $this->Applications->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $application = $this->Applications->patchEntity($application, $this->request->getData());
            if ($this->Applications->save($application)) {
                $this->Flash->success(__('The application has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The application could not be updated. Please, try again.'));
        }

        $students = $this->Students->find('list', ['limit' => 200])->toArray();
        $companies = $this->Companies->find('list', ['limit' => 200])->toArray();

        $supervisors = $this->Supervisors->find()
            ->where(['status' => 'Active'])
            ->all()
            ->combine('id', function ($supervisor) {
                return $supervisor->email . ' (' . $supervisor->department . ')';
            })
            ->toArray();

        $this->set(compact('application', 'students', 'companies', 'supervisors'));
    }

    // Delete application
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $application = $this->Applications->get($id);

        if ($this->Applications->delete($application)) {
            $this->Flash->success(__('The application has been deleted.'));
        } else {
            $this->Flash->error(__('The application could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
