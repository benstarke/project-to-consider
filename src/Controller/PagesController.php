<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;
use Cake\View\Exception\MissingTemplateException;

class PagesController extends AppController
{
    public function display(string ...$path): ?Response
    {
        if (!$path) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }

        // Fetch the roster closest to today's date
        $currentDateTime = new FrozenTime();
        $list = ['page', 'subpage'];

        $roster = $this->fetchTable('Rosters')
            ->find()
            ->where(['roster_date >=' => $currentDateTime->format('Y-m-d')])
            ->orderAsc('roster_date')
            ->first();

            
        if ($roster) {
            $list[] = 'roster';

            // Fetch the shift with the closest start time
            $shift = $this->fetchTable('Shifts')
                ->find()
                ->where(['start_time >=' => $currentDateTime])
                ->orderAsc('start_time')
                ->first();

            if ($shift) {
                $list[] = 'shift';

                // Fetch role associated with the shift
                $role = $this->fetchTable('Roles')->get($shift->role_id);
                $list[] = 'role';

                // Fetch workers for the shift
                $worker = $this->fetchWorkersForRoster($roster->id);

                if ($worker) {
                    $list[] = 'worker';
                }

                // Fetch tasks associated with the role
                $tasks = $this->fetchTasksForRole($role->id);

                if ($tasks) {
                    $list[] = 'tasks';
                }
            }
        }

        $this->set(compact($list));

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }

    public function clockhome()
    {
        $identity = $this->request->getAttribute('identity');
        $user = $this->fetchTable('Users')->get($identity->id);

        // Fetch tasks assigned to the logged-in user
        $tasks = $this->fetchTable('Tasks')
            ->find()
            ->select([
                'Tasks.id',
                'Tasks.description',
                'Tasks.responsibility',
                'Tasks.status',
                'Tasks.deadline',
                'Tasks.shift_id',
                'Tasks.description_color',
            ])
            ->contain(['Shifts' => function ($q) use ($user){
                return $q->where(['Shifts.user_id' => $user->id]);
            }])
            ->all();


        // print_r($tasks);exit();

        // Check if tasks exist and set to view
        $this->set(compact('tasks'));

        $shift = $this->fetchTable('Shifts')
            ->find()
            ->where(['start_time > ' => new FrozenTime('today 00:00:00')])
            ->andWhere(['user_id' => $user->id])
            ->orderAsc('start_time')
            ->first();

        if ($user->isAdmin) {
            $worker = $this->getTodayWorker($user, null);
            $this->set(compact('worker'));
        }

        if (!$user->isAdmin) {
            $availability = $this->getUserAvailability($user);
            $this->set(compact('availability'));

            $personAvailable = $this->fetchTable('Availabilities')
                ->find()
                ->where(['user_id' => $identity->id])
                ->first();
            $this->set(compact('personAvailable'));
        }

        if (!empty($shift) && !empty($shift->roster_id)) {
            $roster = $this->fetchTable('Rosters')->get($shift->roster_id);
            $worker = $this->getTodayWorker($user, $shift);
            $this->set(compact(['worker', 'shift', 'roster']));
        }

        $totalDuration = $this->totalHoursWorked($user);
        $this->set(compact('totalDuration'));

        if ($identity->isAdmin) {
            $logTables = TableRegistry::getTableLocator()->get('Logs');
            $logs = $logTables->find()->contain(['Users'])->order(['createtime' => 'DESC'])->limit(5)->all();
            $this->set(compact('logs'));
        }
    }

    protected function totalHoursWorked($user)
    {
        $ShiftsTable = TableRegistry::getTableLocator()->get('Shifts');
        $currentWeekStart = new FrozenTime('monday this week');
        $currentWeekEnd = new FrozenTime('now');

        // Find all shifts for the user in the current week
        $query = $ShiftsTable->find()
            ->where(['user_id' => $user->id])
            ->where(['start_time >=' => $currentWeekStart])
            ->where(['end_time <=' => $currentWeekEnd]);

        $totalDuration = 0;
        foreach ($query->all() as $shift) {
            $startTime = new FrozenTime($shift->start_time);
            $endTime = new FrozenTime($shift->end_time);
            $interval = $endTime->diff($startTime);
            $duration = $interval->h * 3600 + $interval->i * 60 + $interval->s; // Convert to seconds
            $totalDuration += $duration;
        }

        // Convert the total time to a more readable format (e.g., hours and minutes)
        $hours = intdiv($totalDuration, 3600);
        $minutes = intdiv($totalDuration % 3600, 60);
        $readableDuration = $hours . ' hours ' . $minutes . ' minutes';

        return $readableDuration;
    }

    public function getTodayWorker($user, $shift)
    {
        // Gets the current date and time
        $now = new FrozenTime();

        // Set the start and end times of the day
        $dayStart = $now->startOfDay();
        $dayEnd = $now->endOfDay();

        // Gets an instance of the Shifts table
        $ShiftsTable = TableRegistry::getTableLocator()->get('Shifts');

        $query = $ShiftsTable->find() // Use the distinct method to remove weight
            ->where(['start_time >=' => $dayStart->format('Y-m-d H:i:s')]) // Greater than or equal to the start time of the day
            ->where(['start_time <=' => $dayEnd->format('Y-m-d H:i:s')]); // Less than or equal to the end time of the day

        if (!$user->isAdmin) {
            $query->where(['roster_id' => $shift->roster_id]); // Specific roster_id
            $query->andWhere(['user_id <>' => $user->id]); // Except for the specific user_id
        }

        $worker = $query->all();
        $userIds = [];

        if ($worker->count() > 0) {
            foreach ($worker as $value) {
                $userIds[$value->user_id] = $value->user_id;
            }
            if (!empty($userIds)) {
                $Users = TableRegistry::getTableLocator()->get('Users');
                $query = $Users->find()->whereInList('id', $userIds);
                $worker = $query->all();
            }
        }
        return $worker; // Get the results of all matches
    }

    public function getShiftTask($shift)
    {
        if ($shift && !empty($shift->id)) {
            $task = $this->fetchTable('Tasks')
                ->find()
                ->where(['shift_id' => $shift->id])
                ->first();

            return $task;
        }
        return null;
    }

    public function getUserAvailability($user)
    {
        $AvailabilitiesTable = TableRegistry::getTableLocator()->get('Availabilities');
        $query = $AvailabilitiesTable->find()
            ->where(['user_id' => $user->id]);

        return $query->all();
    }

    private function fetchTasksForRole($roleId)
    {
        return $this->fetchTable('Activities')
            ->find()
            ->where(['role_id' => $roleId])
            ->all();
    }

    private function fetchWorkersForRoster($rosterId)
    {
        $userIds = $this->fetchTable('Shifts')
            ->find()
            ->select(['user_id'])
            ->distinct(['user_id'])
            ->where(['roster_id' => $rosterId])
            ->toArray();

        $workers = [];
        foreach ($userIds as $userId) {
            $user = $this->fetchTable('Users')->get($userId->user_id);
            if ($user) {
                $workers[] = $user;
            }
        }

        return $workers;
    }
}
