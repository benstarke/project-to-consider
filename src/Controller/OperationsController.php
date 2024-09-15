<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Operations Controller
 *
 * @property \App\Model\Table\OperationsTable $Operations
 */
class OperationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Operations->find();
        $operations = $this->paginate($query);

        $this->set(compact('operations'));
    }

    /**
     * View method
     *
     * @param string|null $id Operation id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $operation = $this->Operations->get($id, contain: []);
        $this->set(compact('operation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $operations = $this->Operations->find()->all()->toArray();
        // if ($this->request->is('post')) {
        //     $data = $this->request->getData();
        //     $checkFlash = false;
        //     if (isset($data)) {
        //         foreach ($data as $day) {
        //             $operation = $this->Operations->newEmptyEntity();
        //             $operation = $this->Operations->patchEntity($operation, $day);
        //             if ($this->Operations->save($operation)) {
        //                 $checkFlash = !$checkFlash;
        //             }
        //         }
        //         if ($checkFlash) {
        //             $this->Flash->success(__('The operation has been saved.'));
        //         } else {
        //             $this->Flash->error(__('The operation could not be saved. Please, try again.'));

        //             return $this->redirect($this->referer());
        //         }
        //     }
        //     $this->Flash->error(__('The operation could not be saved. Please, try again.'));
        // }
        $this->set(compact('operations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Operation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit()
    {
        $numbers = [
            [0, 'Monday'],
            [1, 'Tuesday'],
            [2, 'Wednesday'],
            [3, 'Thursday'],
            [4, 'Friday'],
            [5, 'Saturday'],
            [6, 'Sunday'],
        ];
        // $operation = $this->Operations->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $checkFlash = false;
            $operations = $this->Operations->find()->all()->toArray();
            $data = $this->request->getData();
            if (isset($data)) {
                foreach ($numbers as $number) {
                    $existoperation = $operations[$number[0]];
                    $existoperation = $this->Operations->patchEntity($existoperation, $data[$number[1]]);
                    $this->Operations->save($existoperation);
                    if ($this->Operations->save($existoperation)) {
                        // Check if both the index $number[1] and the key 'day_start' are set in the $data array
                        if (isset($data[$number[1]]) && isset($data[$number[1]]['day_start'])) {
                         // If 'day_start' is defined, debug its value
                        } else {
                            // If 'day_start' is not defined, print 'HI'
                            $existoperation->day_start = null;
                            $existoperation->day_end = null;
                            $this->Operations->save($existoperation);
                        }
                        $checkFlash = !$checkFlash;
                    }
                }
                if ($checkFlash) {
                    $this->Flash->success(__('The operation has been saved.'));

                    return $this->redirect($this->referer());
                } else {
                    $this->Flash->error(__('The opeasdration could not be saved. Please, try again.'));

                    return $this->redirect($this->referer());
                }
            }
        }
        $this->set(compact('operation'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Operation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $operation = $this->Operations->get($id);
        if ($this->Operations->delete($operation)) {
            $this->Flash->success(__('The operation has been deleted.'));
        } else {
            $this->Flash->error(__('The operation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
