<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TasksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $tasks = $this->Tasks->find()
            ->select([
                'Tasks.id',
                'Tasks.description',
                'Tasks.responsibility',
                'Tasks.status',
                'Tasks.deadline',
                'Tasks.responsibility',
                'Tasks.description_color',  
                'start' => 'Shifts.start_time',
                'end' => 'Shifts.end_time',
                'rosterid' => 'Shifts.roster_id',
                'role' => 'Roles.name',
                'l_name' => 'Users.l_name',
                'f_name' => 'Users.f_name',
            ])
            ->contain(['Shifts' => ['Users', 'Roles']])
            ->toArray();

        $this->set(compact('tasks'));
    }

    /**
     * View method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $task = $this->Tasks->get($id, [
            'contain' => ['Shifts']
        ]);

        if (!$task) {
            throw new \Cake\Datasource\Exception\RecordNotFoundException(__('Task not found.'));
        }

        $this->set(compact('task'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $task = $this->Tasks->newEmptyEntity();

        if ($this->request->is('ajax')) {
            $data = $this->request->getQuery('data');
            if ($data) {
                // Accessing individual attributes
                $task->description = $data['description'];
                $task->responsibility = $data['responsibility'];
                $task->status = $data['status'];
                $task->deadline = $data['deadline'] ?? null;
                $task->shift_id = $data['shift_id'];

                // Attempt to save the task
                if ($this->Tasks->save($task)) {
                    $response = [
                        'status' => 'success',
                        'message' => 'The task has been saved successfully.'
                    ];
                    return $this->response->withType('application/json')->withStringBody(json_encode($response));
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'The task could not be saved. Please, try again.'
                    ];
                    return $this->response->withType('application/json')->withStringBody(json_encode($response));
                }
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Invalid data.'
                ];
                return $this->response->withType('application/json')->withStringBody(json_encode($response));
            }

        }

        if ($this->request->is('post')) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('The task has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The task could not be saved. Please, try again.'));
        }

        $shifts = $this->Tasks->Shifts->find('list', ['limit' => 200])->all();
        $this->set(compact('task', 'shifts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!$id){
            if ($this->request->is(['patch', 'post', 'put', 'ajax'])) {
                $data = $this->request->getQuery('data');
                
                $id = $data['id'];
                // $task = $this->Tasks->get($id, [
                //     'contain' => [],
                // ]);
                $task = $this->Tasks->get($id);
                if($data['description'])$task->description = $data['description'];
                if($data['responsibility'])$task->responsibility = $data['responsibility'];
                if($data['deadline'])$task->deadline = $data['deadline'];
                if($data['status'])$task->status = $data['status'];
                if ($this->Tasks->save($task)) {
                    $this->Flash->success(__('The task has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
        $task = $this->Tasks->get($id);

        if (!$task) {
            $this->Flash->error(__('Task not found.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());

            if (empty($task->responsibility)) {
                $task->responsibility = 'No specific responsibility assigned.';
            }

            if (empty($task->description_color)) {
                $task->description_color = 'green'; 
            }

            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('The task has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The task could not be saved. Please, try again.'));
        }

        $this->set(compact('task'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $task = $this->Tasks->get($id);
        if ($this->Tasks->delete($task)) {
            $this->Flash->success(__('The task has been deleted.'));
        } else {
            $this->Flash->error(__('The task could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Fetch tasks based on the shift ID (for AJAX requests)
     */
    public function getTasks()
    {
        $this->request->allowMethod('ajax');
        if ($this->request->is('ajax')) {
            $shiftId = $this->request->getQuery('data');
            // Assuming $shiftId is properly sanitized and validated
            $task = $this->Tasks->find()->where(['shift_id' => $shiftId])->first();

            if ($task) {
                return $this->response->withType('application/json')->withStringBody(json_encode($task));
            } else {
                // Respond with an error message if no task is found
                $errorResponse = ['error' => 'No task found for the provided shift ID'];

                return $this->response->withType('application/json')->withStringBody(json_encode($errorResponse));
            }
        }
    }
}
