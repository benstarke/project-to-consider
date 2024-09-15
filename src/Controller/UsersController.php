<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\Mailer\Mailer;
use Cake\Utility\Security;
use DateTimeZone;

use App\Model\Entity\Availability;


/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
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
        // In UsersController.php

    public function checkEmail()
    {
        $this->autoRender = false; // We don't need a view for this response
        if ($this->request->is('ajax')) {
            $email = $this->request->getQuery('email');
            $exists = $this->Users->exists(['email' => $email]);

            // Return true if exists, false otherwise
            return $this->response->withType('application/json')->withStringBody(json_encode($exists));
        }
    }

    public function index()
    {
        $query = $this->Users->find();
        $users = $this->paginate($query, ['limit' => 5000]); // Limit set to 5000
        $todayL = strtolower(date('l'));

        $userAvailabilities = $this->fetchTable('Availabilities')->find()
            ->orderDesc('id')
            ->all();
        // timezone fixed for Time Created
        foreach ($users as $user) {
            $user->created = $user->created->setTimezone('Australia/Melbourne');
            $user->isFree = '-';

            foreach ($userAvailabilities as $item) {
                if ($user->id == $item->user_id && ($user->isAdmin == 0)) {
                    if ($item->{$todayL}) {
                        $user->isFree = 'Available';
                        break;
                    } else {
                        $user->isFree = 'Unavailable';
                    }
                }
            }
        }

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $user = $this->Users->get($id, contain: ['Shifts']);
        $userAvailabilities = $this->fetchTable('Availabilities')
            ->find()
            ->where(['user_id' => $id])
            ->orderDesc('id')
            ->first();

        $this->set(compact('user','userAvailabilities'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            // Check if a file was uploaded

            $user = $this->Users->patchEntity($user, $this->request->getData());

            if (!empty($this->request->getData('avatarimg')['tmp_name'])) {
                // File was uploaded, process it normally
                $user->avatarimg = $this->request->getData('avatarimg');

                // Process the file upload...
            } else {
                // No file was uploaded, use the default image
                $user->avatarimg = '/img/userprofile/default.jpeg'; // Path to your default image
                // Save the default image path to the database or use it in your logic

            }


            if ($this->Users->save($user)) {

                // Create an Availability record for this user
                $availability = new Availability();
                $availability->user_id = $user->id;

                // Default availability being unavailable every day
                $availability->monday = false;
                $availability->tuesday = false;
                $availability->wednesday = false;
                $availability->thursday = false;
                $availability->friday = false;
                $availability->saturday = false;
                $availability->sunday = false;

                $this->Users->Availabilities->save($availability);

                // Now let's send the password reset email
                    $user->nonce = Security::randomString(128);
                    $user->nonce_expiry = (new FrozenTime('1 days'))->setTimezone(new DateTimeZone('Australia/Melbourne'));
                if ($this->Users->save($user)) {
                    $contentBlock = $this->fetchTable('ContentBlocks.ContentBlocks')->find()->toArray();
                    $contentBlocksGrouped = array_reduce($contentBlock, function ($grouped, $item) {
                        $parent = $item['parent'];
                        $groupItems = $grouped[$parent] ?? [];
                        $groupItems[] = $item;
                        $grouped[$parent] = $groupItems;

                        return $grouped;
                    }, []);
                    $mailer = new Mailer('default');

                // email basic config
                    $mailer
                    ->setEmailFormat('html')
                    ->setTo($user->email)
                    ->setSubject($contentBlocksGrouped['Email'][0]['value'])
                    ->viewBuilder()
                    ->setTemplate('default')
                    ->setLayout('newaccount');
                // transfer required view variables to email template
                    $mailer
                    ->setViewVars([
                        'nonce' => $user->nonce,
                        'email' => $user->email,
                        'email_subject' => $contentBlocksGrouped['Email'][0]['value'],
                        'email_content' => $contentBlocksGrouped['Email'][1]['value'],
                        'email_footer' => $contentBlocksGrouped['Email'][2]['value'],
                    ]);

                    $mailer->deliver();

                //Send email
                    if (!$mailer->deliver()) {
                        // Just in case something goes wrong when sending emails
                        $this->Flash->error('We have encountered an issue when sending you emails. Please try again. ');

                        return $this->render();  // Skip the rest of the controller and render the view
                    } else {
                        $this->Flash->success(__('The user has been saved.'));

                        return $this->redirect(['action' => 'index']);
                    }
                }
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
            $this->redirect(['action' => 'index']);
        }
        $this->set(compact('user'));
    }

    public function updateImage($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $file = $this->request->getData('avatarimg', null);
            if (!empty($file)) {
                $filename = $file->getClientFilename();
                $uploadPath = WWW_ROOT . '/img/userprofile' . DS; // 设置上传文件夹的路径
                if (!file_exists($uploadPath)) {
                    if (mkdir($uploadPath)) {
                        $this->Flash->error(__('The' . $uploadPath . ' dir no exits Please, try again.'));
                    }
                }
                $newPath = '/img/userprofile/'  . $filename;
                if ($file->getError() === UPLOAD_ERR_OK) {
                    $file->moveTo($uploadPath . $filename);
                    $user->avatarimg = $newPath;
                }
            }
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'edit',$user->id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function profile()
    {
        $identity = $this->request->getAttribute('identity');
        $id = $identity->get('id');
        $personAvailable = $this->fetchTable('Availabilities')->find()->where(['user_id'=> $id])->first();

        $this->set(compact('personAvailable'));


        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $old_img = $user->avatarimg;
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->avatarimg = $old_img;
            $file = $this->request->getData('avatarimg', null);
            if (!empty($file)) {
                $filename = $file->getClientFilename();
                $uploadPath = WWW_ROOT . '/img/userprofile' . DS; // 设置上传文件夹的路径
                if (!file_exists($uploadPath)) {
                    if (mkdir($uploadPath)) {
                        $this->Flash->error(__('The' . $uploadPath . ' dir no exits Please, try again.'));
                    }
                }
                $newPath = '/img/userprofile/'  . $filename;
                if ($file->getError() === UPLOAD_ERR_OK) {
                    $file->moveTo($uploadPath . $filename);
                    $user->avatarimg = $newPath;
                }
            }

            if ($id == $this->Authentication->getResult()->getData()->get('id')) {
                $this->Authentication->setIdentity($user);
            }

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'profile',$user->id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));

            return $this->redirect($this->referer());
        }
        $this->set(compact('user'));
        $this->render('edit');
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $identity = $this->request->getAttribute('identity');
        $is_manager = $identity->isManager;

        $personAvailable = $this->fetchTable('Availabilities')->find()->where(['user_id'=> $id])->first();

        $this->set(compact('personAvailable'));

        $user = $this->Users->get($id, contain: []);
        if($is_manager && $user->id != $identity->id){
            if( $user->isManager == 1 ||$user->isAdmin == 1){
                $this->Flash->error('You do not have permission to edit this user.');
                return $this->redirect($this->referer());
            }
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $old_img = $user->avatarimg;
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->avatarimg = $old_img;
            $file = $this->request->getData('avatarimg', null);
            if (!empty($file)) {
                $filename = $file->getClientFilename();
                $uploadPath = WWW_ROOT . '/img/userprofile' . DS; // 设置上传文件夹的路径
                if (!file_exists($uploadPath)) {
                    if (mkdir($uploadPath)) {
                        $this->Flash->error(__('The' . $uploadPath . ' dir no exits Please, try again.'));
                    }
                }
                $newPath = '/img/userprofile/'  . $filename;
                if ($file->getError() === UPLOAD_ERR_OK) {
                    $file->moveTo($uploadPath . $filename);
                    $user->avatarimg = $newPath;
                }
            }

            if ($id == $this->Authentication->getResult()->getData()->get('id')) {
                $this->Authentication->setIdentity($user);
            }

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'edit',$user->id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));

            return $this->redirect($this->referer());
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        /**
         * Check if the user is the current user or an admin
         */
        $identity = $this->request->getAttribute('identity');
        $is_manager = $identity->isManager;
        $is_admin = $identity->isAdmin;
        if($user->id == $identity->id){
            $this->Flash->error('You cannot delete your own account.');
            return $this->redirect($this->referer());
        }
        if($is_manager && ($user->isManager == 1 || $user->isAdmin == 1)){
            $this->Flash->error('You cannot delete a manager account.');
            return $this->redirect($this->referer());
        }
        if($is_admin && ($user->email=="nliveclockwork0001@gmail.com"||$user->email=="nliveclockwork0001@gmail.com")){
            $this->Flash->error('You cannot delete a super admin account.');
            return $this->redirect($this->referer());
        }
    // override to allow deleting super admin accounts

        $currentUser = $this->Authentication->getResult()->getData();
        $currentID = $currentUser->get('id');
        $isEmployee = $currentUser->get('isEmployee');
        $isAdmin = $currentUser->get('isAdmin');
        $isManager = $currentUser->get('isManager');

        // Check roles
//        if ($isEmployee && (!$isAdmin || !$isManager)) {
//            $this->Flash->error('You do not have permission to delete users.');
//
//            return $this->redirect($this->referer());
//        }

//        if ($isManager && !$isAdmin) {
//                $this->Flash->error('Managers cannot delete admins.');
//
//                return $this->redirect($this->referer());
//        }

//        if (!$user->isAdmin && !$user->isManager && !$user->isEmployee) {
//            $this->Flash->error('Super admin account cannot delete.');
//
//            return $this->redirect($this->referer());
//        }

        // cannot delete super admin accounts
        if ($user->isManager == 0 && $user->isAdmin == 0 && $user->isEmployee == 0){
            $this->Flash->error('Super admin account cannot delete.');

            return $this->redirect($this->referer());
        }


        if ($currentID != $id && $this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
            return $this->redirect(['action' => 'index']); // Redirect to the index action

        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }
}
