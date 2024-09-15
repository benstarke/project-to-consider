<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');

        $identity = $this->request->getAttribute('identity');
        $action = $this->request->getParam('action');
        $controller = $this->request->getParam('controller');

        // Allowing employees to access rostercalendar.json under Rosters controller
        if ($controller == 'Rosters' && $action == 'rostercalendar') {
            // No further access control needed for this action
            return;
        }

        // General access control for other pages
        if ($controller == 'Auth' || $controller == 'Pages' || ($controller == 'Availabilities' && $action == 'myavailabilities') || ($controller == 'Users' && ($action == 'view' || $action == 'profile')) ||($controller == 'Tasks' && $action == 'edit')|| $controller == 'LeaveRequests') {
        // Your code here
        }else {
            if ($identity && !($identity->isAdmin || $identity->isManager)) {
                $this->redirect("/404");
            }
            if ($identity && $identity->isManager && ($controller == 'Logs' || $controller == 'Operations' || $controller == 'ContentBlocks')) {
                $this->redirect("/404");
            }
        }

        // Set current user IDs for various tables
        if ($identity) {
            TableRegistry::getTableLocator()->get('Rosters')::$currentUserId = $identity->id;
            TableRegistry::getTableLocator()->get('Shifts')::$currentUserId = $identity->id;
            TableRegistry::getTableLocator()->get('Users')::$currentUserId = $identity->id;
            TableRegistry::getTableLocator()->get('Tasks')::$currentUserId = $identity->id;
            TableRegistry::getTableLocator()->get('Activities')::$currentUserId = $identity->id;
        }

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }
}

