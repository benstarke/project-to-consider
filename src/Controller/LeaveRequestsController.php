<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LeaveRequests Controller
 *
 * @property \App\Model\Table\LeaveRequestsTable $LeaveRequests
 */
class LeaveRequestsController extends AppController {

    public function initialize(): void {
        parent::initialize();
        // $this->loadComponent('Paginator');
        // $this->loadModel('LeaveRequests'); // Explicitly load the model
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $query = $this->LeaveRequests->find()
            ->contain(['Users']);
        $leaveRequests = $this->paginate($query);

        $this->set(compact('leaveRequests'));
    }

    /**
     * View method
     *
     * @param string|null $id Leave Request id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        if ($id === null) {
            $this->Flash->error(__('Invalid leave request.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $leaveRequest = $this->LeaveRequests->get($id, [
                'contain' => ['Users'],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('The leave request does not exist.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('leaveRequest'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $leaveRequest = $this->LeaveRequests->newEmptyEntity();
        if ($this->request->is('post')) {
            $leaveRequest = $this->LeaveRequests->patchEntity($leaveRequest, $this->request->getData());

            // Add this line to set the user_id
            $leaveRequest->user_id = $this->Authentication->getIdentity()->id;

            if ($this->LeaveRequests->save($leaveRequest)) {
                $this->Flash->success(__('The leave request has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The leave request could not be saved. Please, try again.'));
        }
        $userList = $this->LeaveRequests->Users->find('all', ['limit' => 200])->all();
        $users = [];
        foreach ($userList as $item) {
            $users[$item->id] = $item->f_name . ' ' . $item->l_name;
        }
        $this->set(compact('leaveRequest', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Leave Request id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function edit($id = null) {
        $this->log("Edit action called with ID: " . $id, 'debug');

        if ($id === null) {
            $this->log("Attempt to edit leave request with null ID", 'error');
            $this->Flash->error(__('Invalid leave request.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $leaveRequest = $this->LeaveRequests->get($id, [
                'contain' => [],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->log("Leave request not found with ID: " . $id, 'error');
            $this->Flash->error(__('The leave request does not exist.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->log("Form submitted with data: " . json_encode($this->request->getData()), 'debug');
            $leaveRequest = $this->LeaveRequests->patchEntity($leaveRequest, $this->request->getData());
            // convert date format
            $startDate = $this->request->getData('start_date');
            $startDate = \DateTime::createFromFormat('m/d/y', $startDate);
            $leaveRequest->start_date = $startDate->format('Y-m-d');

            $endDate = $this->request->getData('end_date');
            $endDate = \DateTime::createFromFormat('m/d/y', $endDate);
            $leaveRequest->end_date = $endDate->format('Y-m-d');

            if ($this->LeaveRequests->save($leaveRequest)) {
                $this->log("Leave request saved successfully", 'debug');
                $this->Flash->success(__('The leave request has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->log("Failed to save leave request. Errors: " . json_encode($leaveRequest->getErrors()), 'error');
            $this->Flash->error(__('The leave request could not be saved. Please, try again.'));
        }

        $userList = $this->LeaveRequests->Users->find('all', ['limit' => 200])->all();
        $users = [];
        foreach ($userList as $item) {
            $users[$item->id] = $item->f_name . ' ' . $item->l_name;
        }
        $this->set(compact('leaveRequest', 'users'));
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $leaveRequest = $this->LeaveRequests->get($id);
            if ($this->LeaveRequests->delete($leaveRequest)) {
                $this->Flash->success(__('The leave request has been deleted.'));
            } else {
                $this->Flash->error(__('The leave request could not be deleted. Please, try again.'));
            }
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('The leave request could not be found.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function manageRequests() {
        $query = $this->LeaveRequests->find()
            ->contain(['Users' => ['fields' => ['id', 'f_name', 'l_name', 'email']]])
            ->where(['LeaveRequests.status' => 'pending'])
            ->order(['LeaveRequests.created' => 'DESC']);

        $leaveRequests = $this->paginate($query);

        $this->set(compact('leaveRequests'));
    }

    public function approve($id = null) {
        $this->request->allowMethod(['get', 'post']);

        if ($id === null) {
            $this->Flash->error(__('Invalid leave request ID.'));
            return $this->redirect(['action' => 'manageRequests']);
        }

        try {
            $leaveRequest = $this->LeaveRequests->get($id);
            $leaveRequest->status = 'approved';

            if ($this->LeaveRequests->save($leaveRequest)) {
                $this->Flash->success(__('The leave request has been approved.'));
            } else {
                $this->Flash->error(__('The leave request could not be approved. Please, try again.'));
            }
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('The leave request does not exist.'));
        }

        return $this->redirect(['action' => 'manageRequests']);
    }

    public function deny($id = null) {
        $this->request->allowMethod(['post', 'put']);
        $leaveRequest = $this->LeaveRequests->get($id);
        $leaveRequest->status = 'Denied';
        $leaveRequest->manager_comment = $this->request->getData('manager_comment');

        if ($this->LeaveRequests->save($leaveRequest)) {
            $this->Flash->success(__('The leave request has been denied.'));
        } else {
            $this->Flash->error(__('The leave request could not be denied. Please, try again.'));
        }

        return $this->redirect(['action' => 'manageRequests']);
    }
}
