<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Availabilities Controller
 *
 * @property \App\Model\Table\AvailabilitiesTable $Availabilities
 */
class AvailabilitiesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Availabilities->find()
            ->contain(['Users']);
        $availabilities = $this->paginate($query, ['limit' => 5000]); // Limit set to 5000


        $this->set(compact('availabilities'));
    }

    /**
     * View method
     *
     * @param string|null $id Availability id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $availability = $this->Availabilities->get($id, contain: ['Users']);
        $this->set(compact('availability'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $availability = $this->Availabilities->newEmptyEntity();
        if ($this->request->is('post')) {
            $availability = $this->Availabilities->patchEntity($availability, $this->request->getData());
            if ($this->Availabilities->save($availability)) {
                $this->Flash->success(__('The availability has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The availability could not be saved. Please, try again.'));
        }
        $users = $this->Availabilities->Users->find('list', limit: 200)->all();
        $this->set(compact('availability', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Availability id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $availability = $this->Availabilities->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $availability = $this->Availabilities->patchEntity($availability, $this->request->getData());
            if ($this->Availabilities->save($availability)) {
                $this->Flash->success(__('The availability has been saved.'));

                return $this->redirect(['controller' => 'Pages']);
            }
            $this->Flash->error(__('The availability could not be saved. Please, try again.'));
        }
        $users = $this->Availabilities->Users->find('list', limit: 200)->all();
        $this->set(compact('availability', 'users'));
    }

    public function myavailabilities()
    {
        $identity = $this->request->getAttribute('identity');
        $id = $identity->get('id');
        $availability = $this->Availabilities->find()->where(['user_id'=>$id])->first();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $availability = $this->Availabilities->patchEntity($availability, $this->request->getData());
            if ($this->Availabilities->save($availability)) {
                $this->Flash->success(__('The availability has been saved.'));

                return $this->redirect(['controller' => 'Users', 'action' => 'profile']);
            }
            $this->Flash->error(__('The availability could not be saved. Please, try again.'));
        }
        $users = $this->Availabilities->Users->find('list', limit: 200)->all();
        $this->set(compact('availability', 'users'));
        $this->render('edit');
    }

    /**
     * Delete method
     *
     * @param string|null $id Availability id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $availability = $this->Availabilities->get($id);
        if ($this->Availabilities->delete($availability)) {
            $this->Flash->success(__('The availability has been deleted.'));
        } else {
            $this->Flash->error(__('The availability could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
