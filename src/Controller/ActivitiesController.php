<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Activities Controller
 *
 * @property \App\Model\Table\ActivitiesTable $Activities
 */
class ActivitiesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        // Option B (preferred)
        $this->loadComponent('Ajax.Ajax', [
            'actions' => ['edit'],
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function statesAjaxActivity()
    {
        $this->request->allowMethod('ajax');
        $id = $this->request->getQuery('id'); // Get the id from the AJAX request

        if (!$id) {
            throw new NotFoundException();
        }
        $role = $this->fetchTable('Roles')->find()->all();

        $result = $this->Activities->get($id, ['contain' => []]); // Use 'contain' instead of contain:
        $response = [
            'roles' => $role,
            'result' => $result,
        ];

        return $this->response->withType('application/json')->withStringBody(json_encode($response));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate['limit'] = 200; // Set the limit to 50 activities per page
        $query = $this->Activities->find()
            ->contain(['Roles']);
        $activities = $this->paginate($query, ['limit' => 5000]); // Limit set to 5000

        $try = $this->paginate($this->Activities->find('all'));
        $roles = $this->fetchTable('Roles');
        $roles = $roles->find();
        $roles = $this->paginate($roles);
        $this->set(compact(['roles','activities']));
    }

    /**
     * View method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $activity = $this->Activities->get($id, contain: ['Roles']);
        $this->set(compact('activity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $activity = $this->Activities->newEmptyEntity();

        if ($this->request->is('post')) {
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());

            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));

                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('The activity could not be saved. Please, try again.'));

                return $this->redirect($this->referer());
            }
        }
        $roles = $this->Activities->Roles->find('list', limit: 200)->all();
        $this->set(compact('activity', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $activity = $this->Activities->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The activity could not be saved. Please, try again.'));
        }
        $roles = $this->Activities->Roles->find('list', limit: 200)->all();
        $this->set(compact('activity', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activity = $this->Activities->get($id);
        if ($this->Activities->delete($activity)) {
            $this->Flash->success(__('The activity has been deleted.'));
        } else {
            $this->Flash->error(__('The activity could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }
}
