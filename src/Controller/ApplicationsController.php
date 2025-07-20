<?php
declare(strict_types=1);

namespace App\Controller;

use AuditStash\Meta\RequestMetadata;
use Cake\Event\EventManager;
use Cake\Routing\Router;

/**
 * Applications Controller
 *
 * @property \App\Model\Table\ApplicationsTable $Applications
 */
class ApplicationsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Search.Search', [
            'actions' => ['index'],
        ]);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
    }

    public function json()
    {
        $this->viewBuilder()->setLayout('json');
        $this->set('applications', $this->paginate());
        $this->viewBuilder()->setOption('serialize', 'applications');
    }

    public function csv()
    {
        $this->response = $this->response->withDownload('applications.csv');
        $applications = $this->Applications->find();
        $_serialize = 'applications';

        $this->viewBuilder()->setClassName('CsvView.Csv');
        $this->set(compact('applications', '_serialize'));
    }

    public function pdfList()
    {
        $this->viewBuilder()->enableAutoLayout(false);
        $this->paginate = [
            'contain' => ['Students', 'Supervisors', 'Companies'],
            'maxLimit' => 10,
        ];
        $applications = $this->paginate($this->Applications);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption('pdfConfig', [
            'orientation' => 'portrait',
            'download' => true,
            'filename' => 'applications_List.pdf'
        ]);
        $this->set(compact('applications'));
    }

    public function index()
    {
        $this->set('title', 'Applications List');
        $this->paginate = ['maxLimit' => 10];

        $query = $this->Applications->find('search', search: $this->request->getQueryParams())
            ->contain(['Students', 'Supervisors', 'Companies']);
        $applications = $this->paginate($query);

        $this->set('total_applications', $this->Applications->find()->count());
        $this->set('total_applications_archived', $this->Applications->find()->where(['status' => 2])->count());
        $this->set('total_applications_active', $this->Applications->find()->where(['status' => 1])->count());
        $this->set('total_applications_disabled', $this->Applications->find()->where(['status' => 0])->count());

        $months = range(1, 12);
        foreach ($months as $month) {
            $this->set(strtolower(date('F', mktime(0, 0, 0, $month, 10))), 
                $this->Applications->find()->where([
                    'MONTH(created)' => $month,
                    'YEAR(created)' => date('Y')
                ])->count()
            );
        }

        $expectedMonths = [];
        for ($i = 11; $i >= 0; $i--) {
            $expectedMonths[] = date('M-Y', strtotime("-$i months"));
        }

        $query = $this->Applications->find();
        $query->select([
            'count' => $query->func()->count('*'),
            'date' => $query->func()->date_format(['created' => 'identifier', "%b-%Y"]),
            'month' => 'MONTH(created)',
            'year' => 'YEAR(created)'
        ])
            ->where([
                'created >=' => date('Y-m-01', strtotime('-11 months')),
                'created <=' => date('Y-m-t')
            ])
            ->groupBy(['year', 'month'])
            ->orderBy(['year' => 'ASC', 'month' => 'ASC']);

        $results = $query->all()->toArray();

        $totalByMonth = [];
        foreach ($expectedMonths as $expectedMonth) {
            $found = false;
            $count = 0;

            foreach ($results as $result) {
                if ($expectedMonth === $result->date) {
                    $found = true;
                    $count = $result->count;
                    break;
                }
            }

            $totalByMonth[] = ['month' => $expectedMonth, 'count' => $count];
        }

        $this->set([
            'results' => $totalByMonth,
            '_serialize' => ['results']
        ]);

        $dataArray = $totalByMonth;
        $monthArray = array_column($dataArray, 'month');
        $countArray = array_column($dataArray, 'count');

        $this->set(compact('applications', 'monthArray', 'countArray'));
    }

    public function view($id = null)
    {
        $this->set('title', 'Applications Details');
        $application = $this->Applications->get($id, contain: ['Students', 'Supervisors', 'Companies']);
        $this->set(compact('application'));
    }

    public function download($id = null)
    {
        $this->request->allowMethod(['get']);
        $application = $this->Applications->get($id, [
            'contain' => ['Students', 'Supervisors', 'Companies']
        ]);

        $this->viewBuilder()
            ->setClassName('CakePdf.Pdf')
            ->setTemplatePath('Applications')
            ->setTemplate('pdf')
            ->setOption('pdfConfig', [
                'download' => true,
                'filename' => 'Internship_Application_' . $application->id . '.pdf'
            ]);

        $this->set(compact('application'));
    }

    public function pdfLetter($id = null)
    {
        $this->request->allowMethod(['get']);

        $application = $this->Applications->get($id, [
            'contain' => ['Students', 'Supervisors', 'Companies']
        ]);

        $this->viewBuilder()
            ->setClassName('CakePdf.Pdf')
            ->setTemplatePath('Applications')
            ->setTemplate('pdf')
            ->setOption('pdfConfig', [
                'download' => true,
                'filename' => 'Internship_Letter_' . $application->id . '.pdf'
            ]);

        $this->set(compact('application'));
    }

    public function add()
    {
        $this->set('title', 'New Applications');
        $application = $this->Applications->newEmptyEntity();

        if ($this->request->is('post')) {
            $application = $this->Applications->patchEntity($application, $this->request->getData());
            if ($this->Applications->save($application)) {
                $this->Flash->success(__('The application has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The application could not be saved. Please, try again.'));
        }

        $students = $this->Applications->Students->find('list', ['limit' => 200])->all();
        $supervisors = $this->Applications->Supervisors->find('list', ['limit' => 200])->all();
        $companies = $this->Applications->Companies->find('list', ['limit' => 200])->all();
        $this->set(compact('application', 'students', 'supervisors', 'companies'));
    }

    public function edit($id = null)
    {
        $this->set('title', 'Applications Edit');
        $application = $this->Applications->get($id, ['contain' => []]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $application = $this->Applications->patchEntity($application, $this->request->getData());
            if ($this->Applications->save($application)) {
                $this->Flash->success(__('The application has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The application could not be saved. Please, try again.'));
        }

        $students = $this->Applications->Students->find('list', ['limit' => 200])->all();
        $supervisors = $this->Applications->Supervisors->find('list', ['limit' => 200])->all();
        $companies = $this->Applications->Companies->find('list', ['limit' => 200])->all();
        $this->set(compact('application', 'students', 'supervisors', 'companies'));
    }

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

    public function archived($id = null)
    {
        $this->set('title', 'Applications Edit');
        $application = $this->Applications->get($id, ['contain' => []]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $application = $this->Applications->patchEntity($application, $this->request->getData());
            $application->status = 2; // archived
            if ($this->Applications->save($application)) {
                $this->Flash->success(__('The application has been archived.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The application could not be archived. Please, try again.'));
        }

        $this->set(compact('application'));
    }
}
