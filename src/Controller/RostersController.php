<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\View\JsonView;
use Cake\View\XmlView;
/**
 * Rosters Controller
 *
 * @property \App\Model\Table\RostersTable $Rosters
 */
class RostersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

    // loading the request handler component in controller -- HAVING ISSUES
//    public function initialize(): void {
//        parent::initialize();
//
//        //$this->loadComponent('RequestHandler');
//    }

    public function viewClasses(): array
    {
        return [JsonView::class];
    }
    public function index() {
        // Initialize the query to fetch Rosters and associated Shifts
        $query = $this->Rosters->find()
            ->leftJoinWith('Shifts') // Use leftJoinWith to properly join Shifts
            ->select([
                'Rosters.id',
                'Rosters.roster_date',
                'Rosters.end_date',
                'Rosters.name',
                'shift_count' => $this->Rosters->find()->func()->count('Shifts.id') // Reference the function directly
            ])
            ->group(['Rosters.id', 'Rosters.roster_date', 'Rosters.end_date']);
    
        // Paginate the results with a limit of 5000
        $rosters = $this->paginate($query, ['limit' => 5000]);
    
        // Set the variable to be used in the view
        $this->set(compact('rosters'));
    }
    

    public function calendar() {
//Select and compact the object class that need to be render in the Calander ,currently need user name, role name and the shift start and end time
        // $identity = $this->request->getAttribute('identity');
        // $shifts = $this->fetchTable("Shifts")->find();
        // $users = $this->fetchTable("Users")->find();
        // if (!$identity->isAdmin) {
        //     $shifts->where(['user_id' => $identity->id]);
        //     $users->where(['id' => $identity->id]);
        // }
        // $shifts = $this->paginate($shifts);
        // $roles = $this->fetchTable("Roles")->find();
        // $roles = $this->paginate($roles);
        // $users = $this->paginate($users);

        $shifts = $this->fetchTable("Shifts")->find()
        ->select([
            'Shifts.id',
            'Shifts.start_time',
            'Shifts.end_time',
            'Shifts.user_id',
            'role_name' => 'Roles.name',
            'user_last' => 'Users.l_name',
            'user_first' => 'Users.f_name',
            'phone' => 'Users.phone',
            'email' => 'Users.email',
        ])
        ->contain(['Users', 'Roles']); 
       $this->set(compact('shifts'),  $this->paginate());


    }
    public function rostercalendar() {
        //Select and compact the object class that need to be render in the Calander ,currently need user name, role name and the shift start and end time
                $identity = $this->request->getAttribute('identity');
                $shifts = $this->fetchTable("Shifts")->find();
                $users = $this->fetchTable("Users")->find();
                if ($identity->isAdmin != 1) { //not admin
                    $shifts = $this->fetchTable("Shifts")->find()
                    ->select([
                        'Shifts.id',
                        'Shifts.start_time',
                        'Shifts.end_time',
                        'Shifts.user_id',
                        'role_name' => 'Roles.name',
                        'user_lastname' => 'Users.l_name',
                        'user_firstname' => 'Users.f_name',
                        'phone' => 'Users.phone',
                        'email' => 'Users.email',
                    ])
                    ->where(['user_id' => $identity->id])
                    ->contain(['Roles','Users']);
                }else{ // admin
                    $shifts = $this->fetchTable('Shifts')->find()
                    ->select([
                        'Shifts.id',
                        'Shifts.start_time',
                        'Shifts.end_time',
                        'Shifts.user_id',
                        'role_name' => 'Roles.name',
                        'user_lastname' => 'Users.l_name',
                        'user_firstname' => 'Users.f_name',
                        'phone' => 'Users.phone',
                        'email' => 'Users.email',
                    ])
                    ->contain(['Roles','Users']);
                }

               $this->set(compact('shifts'), $this->paginate());

        
        
            }
    /**
     * View method
     *
     * @param string|null $id Roster id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $users = $this->fetchTable('Users')->find()->all()->toArray();
        $roles = $this->fetchTable('Roles')->find()->all()->toArray();
        $roster = $this->Rosters->get($id, contain: ['Shifts']);
        $this->set(compact(['roster','users','roles']));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $roster = $this->Rosters->newEmptyEntity();
        if ($this->request->is('post')) {
            $roster = $this->Rosters->patchEntity($roster, $this->request->getData());
            if ($this->Rosters->save($roster)) {
                $this->Flash->success(__('The roster has been saved.'));

                //return $this->redirect(['action' => 'index']);
                return $this->redirect(['controller' => 'Shifts', 'action' => 'add', $roster->id]);

            }
            $this->Flash->error(__('This roster date ('.$roster->roster_date->format('d/m/y'). ' - '. $roster->end_date->format('d/m/y')  . ') already exists, please add shifts on it. ' ));

            return $this->redirect(['controller' => 'Rosters', 'action' => 'index']);
        }
        $this->set(compact('roster'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Roster id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $roster = $this->Rosters->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $roster = $this->Rosters->patchEntity($roster, $this->request->getData());
            if ($this->Rosters->save($roster)) {
                $this->Flash->success(__('The roster has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('This roster date ('.$roster->roster_date->format('d/m/y'). ' - '. $roster->end_date->format('d/m/y')  . ') already exists, please add shifts on it. ' ));

            return $this->redirect($this->referer());
        }
        $this->set(compact('roster'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Roster id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $roster = $this->Rosters->get($id);
        if ($this->Rosters->delete($roster)) {
            $this->Flash->success(__('The roster has been deleted.'));
        } else {
            $this->Flash->error(__('The roster could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
