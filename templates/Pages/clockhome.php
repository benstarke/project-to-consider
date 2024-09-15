<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

// $cakeDescription = 'CakePHP: the rapid development php framework';
echo $this->Html->css('//cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.css', ['block' => true]);
echo $this->Html->script('//cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.js', ['block' => true]);
echo $this->Html->script('https://code.jquery.com/jquery-3.6.0.min.js', ['block' => true]);
?>
<?= $this->Html->css(['clockhome','calendar']) ?>

<main>

    <div class="flash-message-container" style="position: fixed; top: 0; right: 0; width: auto; z-index: 9999;">
        <?= $this->Flash->render() ?>
    </div>

<div class="position-relative">
    <nav class="bg-light d-flex justify-content-between align-items-center">
        <div class="ml-5 mr-3">
        </div>
    </nav>
    <div class="position-absolute top-0 end-0 p-2">
        <?= $this->Flash->render() ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="row mt-2">
        <!-- Shifts Card -->
            <?php if ($this->Identity->get('isAdmin') != 1) :?>
                <div class="col">
                    <div class="container">
                        <div class="stylish-card">
                            <div class="d-flex align-items-start">
                                <div style="margin-right: 10px;">
                                    <i class="fa-solid fa-calendar-days fa-2xl" style="color: #53bd88;"></i>
                                </div>
                                <div>
                                    <div class="header">Upcoming Shift</div>
                                    <div class="sub-header text-muted">
                                        <div class="sub-header">
                                            <?php if (isset($shift)) : ?>
                                                <span><?= $shift->start_time->format('D')?></span>
                                                <span><?= $shift->start_time->format('d/m/Y')?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-muted"></div>
                                    </div>
                                    <?php if (isset($shift)) : ?>
                                        <div class="d-flex mt-3 text-muted justify-content-start">
                                            <div style="flex: 0 0 auto;">
                                                <h3><?= $shift->start_time->format('h:i A')?></h3>
                                            </div>
                                            <div class="text-center" style="margin: 0 10px;">
                                                <h3> - </h3>
                                            </div>
                                            <div style="flex: 0 0 auto;">
                                                <h3><?= $shift->end_time->format('h:i A')?></h3>
                                            </div>
                                        </div>

                                    <?php else : ?>
                                        <p class='text-secondary font-weight-normal'>No Upcoming Shift.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Colleagues Card -->
                <div class="col">
                            <div class="ml-3 stylish-card">
                                    <div class="row align-items-center">
                                    <div class="col-sm-4">
                                        <i class="fa-solid fa-user-group fa-2xl" style="color: #53bd88;"></i>
                                      </div>
                                      <div class="col-sm-8">
                                        <div class="header">Colleagues Today</div>
                                      </div>

                                    </div>
                                        <div>
                                            <?php 
                                            if (isset($worker) && !empty($worker)) : ?>
                                                <div class="d-flex flex-wrap">
                                                    <?php foreach ($worker as $individual) : ?>
                                                        <div class="d-flex align-items-center me-3 mb-3">
                                                                <a class="text-decoration-none text-secondary" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $individual->id]) ?>">
                                                                    <?php
                                                                        echo ucfirst($individual->f_name); ?>
                                                                </a>
                                                                    <?php echo $this->Html->image($individual->avatarimg, ['alt' => 'userprofile', 'class' => 'img-profile card-img-top rounded-circle ms-2', 'style' => 'max-width: 35px; max-height: 35px; object-fit: cover;']); ?>
                                                                    </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else : ?>
                                                <p>No Shift Coming.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                </div>
        </div>
    <div class="row mt-2 ml-3 mr-1">

              <!-- calendar -->
        <div class="stylish-card">
            <div class="">
            <span style="height: 10px; width: 10px; background-color: #5CF230; display: inline-block; border-radius: 50%;"></span><span> Morning Shift</span>
            <span style="height: 10px; width: 10px; background-color: #F1AF33; display: inline-block; border-radius: 50%;"></span><span> Afternoon</span>
            <span style="height: 10px; width: 10px; background-color: #3384F1; display: inline-block; border-radius: 50%;"></span><span> Night</span>
            </div>
        <div id='calendar'></div>
        </div>

    </div>
    </div>
    <div class="col-sm-4">
        <div class="col mt-2">
            <!-- Total Hours -->
            <?php if ($this->Identity->get('isAdmin') != 1) :?>
                <div class="stylish-card">
                    <div class="d-flex align-items-start">
                        <div>
                            <i class="fa-regular fa-clock fa-2xl" style="color: #53bd88;"></i>
                        </div>
                        <div class="ms-3">
                            <div class="header">Total Hours Worked</div>
                            <div class="sub-header text-muted">
                                <div class="sub-header">Today</div>
                            </div>
                            <div class="timer-controls">
                                <button id="clockInButton">Clock In</button>
                                <button id="clockOutButton" style="display: none;">Clock Out</button>
                                <div id="timerDisplay">Timer: 00:00:00</div>
                                <div id="totalHoursWorked"></div>

                            </div>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <!-- Activity Logs -->
        <?php if($this->Identity->get("isAdmin") ==1) : ?>
        <div class="col">
        <div class="stylish-card">
        <div class="card-header">
              <div class="row">
              <div class="col-sm-4">
                <i class="fa-solid fa-clock-rotate-left fa-2xl" style="color: #53bd88;"> </i>
                </div>
                <div class="col-sm-8">
                <div class="header">Activity Logs</div>
                </div>
                
              </div>
            <div class="card-body">
                <div class="activity">
                    <div class="activity-item d-flex">
                        <div class="activity-content">
                        <div class="row g-2">
                        <?php if (!empty($logs)) : ?>
                            <table class= "table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($logs as $log): ?>
                                        <tr>
                                        <td><img src="<?=$this->Url->build("/img/action/".$log->action."icon.png");?>" alt="Action Icon" class="avatar-sm rounded-circle"></td>
                                        <td class="ellipsis clickable" data-toggle="full-text">
                                            <a href="<?=$this->Url->build(['controller' => 'Users', 'action' => 'view', $log->user_id])?>"><img src="<?=$this->Url->build($log->user->avatarimg??"/img/default_avatar.png");?>" width="50px" height="50px" class="rounded-circle"> <?=$log->user->f_name??"Unknown"?></a> <?= h($log->message) ?></td>
                                        <td><?= date('d-m-y H:i', strtotime($log->createtime)) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <a href="<?php echo $this->Url->build(['controller' => 'Logs', 'action' => 'index']); ?>" class="btn btn-outline-info">View All Logs</a>
                        <?php else : ?>
                            <p class='text-secondary font-weight-normal'>No logs available.</p>
                        <?php endif; ?>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Tasks -->
    <?php if ($this->Identity->get('isAdmin') != 1) : ?>
        <div class="col mt-2">
            <div class="stylish-card">
                <div class="card-header">
                    <div class="d-flex align-items-start">
                        <div>
                            <i class="fa-solid fa-bell fa-2xl" style="color: #53bd88;"></i>
                        </div>
                        <div class="ms-3">
                            <div class="header">Notifications</div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php if (!empty($tasks)) : ?>
                            <?php foreach ($tasks as $task) : ?>
                                <li class="list-group-item" style="background-color: transparent;">
                                    <div><strong>Description:</strong> <span style="color:<?= h($task->description_color) ?>;"><?= h($task->description) ?></span></div>
                                    <div><strong>Responsibility:</strong> <?= h($task->responsibility) ?></div>
                                    <!-- <div><strong>Status:</strong> <?= h($task->status) ?></div> -->
                                    <div>
                                        <!-- <strong>Status:</strong>  -->
                                    <?php
                                    if($task->status=='Pending'){
                                        $options =[
                                            'Change status' => 'Change status',
                                            'In Process' => 'In Process',
                                            'Completed' => 'Completed'
                                        ];
                                    }else{
                                        $options =[
                                            $task->status => $task->status,
                                            'In Process' => 'In Process',
                                            'Completed' => 'Completed'
                                        ];
                                    }
                                    $options =[
                                        $task->status => $task->status,
                                        'In Process' => 'In Process',
                                        'Completed' => 'Completed'
                                    ];
                                    //acceptTask
                                    echo $this->Form->control('status', [
                                        'type' => 'select',
                                        'options' => $options,
                                        'takes_id'=> $task->id,
                                        'label' => 'Status:',
                                        'class' => 'home_form-control'
                                    ]);
                                    ?></div>
                                </li>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <li class="list-group-item" style="background-color: transparent;">No new tasks.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        
    <?php endif; ?>


    <!-- Activities -->
    <?php if ($this->Identity->get('isAdmin') != 1) :?>
    <div class="col mt-2">
        <div class="stylish-card">
            <div class="card-header">
                <div class="row">
                    <div class="d-flex align-items-start">
                        <div>
                            <i class="fa-solid fa-list-check fa-2xl mr-3" style="color: #53bd88;"></i>
                        </div>
                        <div>
                            <div class="header">Upcoming Shift Activities</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                </div>
              </div>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <style>
                        .list-group-item {
                            white-space: normal;
                            overflow: visible;
                            transition: max-height 0.3s ease;
                        }
                    </style>

                <?php if (isset($tasks) && !empty($tasks)) : ?>
                    <?php foreach ($tasks as $index => $task) : ?>
                        <li class="list-group-item"><span><?= $index + 1 ?>. </span><?= $task->description ?></li>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <p class='text-secondary font-weight-normal'>No Upcoming Activities.</p>
                <?php endif; ?>
                </ul>
            </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Availabilities -->
    <?php if ($this->Identity->get('isAdmin') != 1) :?>
    <div class="col mt-2">
        <div class="stylish-card">
            <div class="card-header">
                <div class="row">
                    <div class="d-flex align-items-start">
                        <?php if (isset($personAvailable) && $personAvailable): ?>
                            <div>
                                <i class="fa-solid fa-calendar-check fa-2xl mr-3" style="color: #53bd88;"> </i>
                            </div>

                            <a href="<?= $this->Url->build(['controller' => 'Availabilities', 'action' => 'myavailabilities']) ?>" class="text-decoration-none" style="color: black; text-decoration: none;" onmouseover="this.style.color='#555'" onmouseout="this.style.color='black'">
                                <div class="header" data-toggle="tooltip" data-bs-placement="left" title="Click to edit availability">Availability To Work</div>
                            </a>
                        <?php else: ?>
                            <div class="d-flex align-items-start">
                                <div>
                                    <i class="fa-solid fa-calendar-check fa-2xl mr-3" style="color: #53bd88;"> </i>
                                </div>
                                <div>
                                    <div class="header">Availability to Work</div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-4">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table style="width:100%">
                    <tbody>
                    <?php if (isset($availability)) : ?>
                        <?php foreach ($availability as $available): ?>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?= __('Monday:') ?></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;<?= $available->monday ? 'color: green;' : 'color: red;' ?>">
                                    <?= $available->monday ? __('Available') : __('Unavailable') ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?= __('Tuesday:') ?></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;<?= $available->tuesday ? 'color: green;' : 'color: red;' ?>">
                                    <?= $available->tuesday ? __('Available') : __('Unavailable') ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?= __('Wednesday:') ?></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;<?= $available->wednesday ? 'color: green;' : 'color: red;' ?>">
                                    <?= $available->wednesday ? __('Available') : __('Unavailable') ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?= __('Thursday:') ?></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;<?= $available->thursday ? 'color: green;' : 'color: red;' ?>">
                                    <?= $available->thursday ? __('Available') : __('Unavailable') ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?= __('Friday:') ?></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;<?= $available->friday ? 'color: green;' : 'color: red;' ?>">
                                    <?= $available->friday ? __('Available') : __('Unavailable') ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?= __('Saturday:') ?></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;<?= $available->saturday ? 'color: green;' : 'color: red;' ?>">
                                    <?= $available->saturday ? __('Available') : __('Unavailable') ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?= __('Sunday:') ?></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;<?= $available->sunday ? 'color: green;' : 'color: red;' ?>">
                                    <?= $available->sunday ? __('Available') : __('Unavailable') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
      </div>
    <?php endif; ?>
</div>


<script>
  $(document).ready(function() {
    $('.clickable').click(function() {
      // Toggle the full text for the clicked item
      $(this).toggleClass('show-full-text');
    });
  });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
const tooltipTriggerList = document.querySelectorAll('[data-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$(document).ready(function () {
    // Fetch tasks for the user and display in notifications
    $.ajax({
        url: '<?= $this->Url->build(['controller' => 'Tasks', 'action' => 'fetchTasksForUser']) ?>',
        type: 'GET',
        success: function(tasks) {
            var tasksList = '';
            if (tasks.length > 0) {
                tasks.forEach(function(task) {
                    tasksList += `<li class="list-group-item" style="background-color: transparent;">
                        <div><strong>Description:</strong> ${task.description}</div>
                        <div><strong>Responsibility:</strong> ${task.responsibility}</div>
                        <div><strong>Status:</strong> ${task.status}</div>
                    </li>`;
                });
            } else {
                tasksList = '<li class="list-group-item" style="background-color: transparent;">No new tasks.</li>';
            }
            $('.list-group-flush').html(tasksList);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });

    // FullCalendar setup
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {

        themeSystem: 'bootstrap5',
        initialView: 'listWeek',
        firstDay: 1,
        headerToolbar: {
            left: 'today prev,next',
            center: 'title',
            right: 'timeGridDay,dayGridMonth,listWeek'
        },
        windowResize: function(view) {
            if (window.innerWidth < 768) {  // Assuming 768px is your mobile breakpoint
                calendar.changeView('listWeek');
                calendar.setOption('headerToolbar', {
                  left: 'prev,next today',
                    center: 'title',  // Only show the title at the center
                    right: ''  // No buttons on the right
                });
            } else {
                calendar.changeView('timeGridWeek');
                calendar.setOption('headerToolbar', {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'dayGridMonth,timeGridDay,listWeek'
              });
            }
        },
        slotMinTime: '06:00:00',
        slotMaxTime: '23:30:00',
        allDaySlot: false,
        nowIndicator: true,
        slotLabelFormat: { hour: 'numeric', minute: '2-digit', omitZeroMinute: false },

        eventMouseEnter: function(info) {
    info.jsEvent.preventDefault(); // Prevent the browser from following the URL

    var eventObj = info.event;
    if (eventObj.url) {
        alert('Hovered over ' + eventObj.title + '.\n' + 'Will open ' + eventObj.url + ' in a new tab');
        window.open(eventObj.url);
    } else {
        // Dispose any existing popovers first
        $('.fc-event').popover('dispose');
        $('.fc-event').data('popover-open', false); // reset all other popovers

        // Initialize a new popover for the hovered event
        $(info.el).popover({
            content: `
            <div style="color: #333; font-size: 14px; line-height: 2;">
                <p><i class="fas fa-user mr-2"></i> <strong>Member:</strong> <span style="color: #0056b3;">${eventObj.extendedProps.name}</span></p>
                <p><i class="fas fa-briefcase mr-2"></i> <strong>Position:</strong> <span style="color: #0056b3;">${eventObj.extendedProps.role}</span></p>
                <p><i class="fas fa-clock mr-2"></i> <strong>Starts:</strong> <span style="color: #28a745;">${eventObj.start.toLocaleTimeString()}</span></p>
                <p><i class="fas fa-clock mr-2"></i> <strong>Ends:</strong> <span style="color: #dc3545;">${eventObj.end ? eventObj.end.toLocaleTimeString() : 'Not specified'}</span></p>
                <hr>
                <p><i class="fa-solid fa-phone mr-2"></i><strong>Phone:</strong> <span style="color: #0056b3;">0${eventObj.extendedProps.phone}</span></p>
                <p><i class="fa-solid fa-envelope mr-2"></i> <strong>Email:</strong> <span style="color: #0056b3;">${eventObj.extendedProps.email}</span></p>
            </div>
            `,
            placement: 'right',
            trigger: 'manual',
            container: 'body',
            html: true
        });

        // Show the popover
        $(info.el).popover('show');
        $(info.el).data('popover-open', true); // Set flag to open
    }
},
        eventMouseLeave: function(info) {
    if ($(info.el).data('popover-open')) {
        $(info.el).popover('dispose');
        $(info.el).data('popover-open', false);
    }
},
        events: function(fetchInfo, successCallback, failureCallback) {
            // Use PHP to conditionally set the URL based on the user's role
            var eventsUrl = <?= json_encode($this->Identity->get('isEmployee')
                ? $this->Url->build(['controller' => 'Rosters', 'action' => 'rostercalendar', '_ext' => 'json'])
                : $this->Url->build(['controller' => 'Rosters', 'action' => 'calendar', '_ext' => 'json'])); ?>;

            // Fetch events using the determined URL
            fetch(eventsUrl)
                .then(response => response.json())
                .then(events => successCallback(events))
                .catch(error => failureCallback(error));
        },
        eventDidMount: function(info) {
            // Check the shift type and add a class accordingly
            if (info.event.extendedProps.shiftType === 'morning') {
                var dotEls = info.el.querySelectorAll('.fc-list-event-dot, .fc-daygrid-event-dot');
                dotEls.forEach(function(dotEl) {
                    dotEl.classList.add('morning-dot');
                });
            }else if (info.event.extendedProps.shiftType === 'afternoon') {
                var dotEls = info.el.querySelectorAll('.fc-list-event-dot, .fc-daygrid-event-dot');
                dotEls.forEach(function(dotEl) {
                    dotEl.classList.add('afternoon-dot');
                });
            }else if (info.event.extendedProps.shiftType === 'night') {
                var dotEls = info.el.querySelectorAll('.fc-list-event-dot, .fc-daygrid-event-dot');
                dotEls.forEach(function(dotEl) {
                    dotEl.classList.add('night-dot');
                });
            }
        }
    });
    // '<?= $this->Url->build(['controller' => 'Rosters', 'action' => 'rostercalendar', '_ext' => 'json']) ?>',
    calendar.render();


    // Hide popover when clicking anywhere else on the page
    $(document).click(function (e) {
        if (!$(e.target).closest('.fc-event').length) {
            $('.fc-event').popover('dispose');
        }
    });
});
</script>
<script>
    $(document).ready(function() {
        $('.home_form-control').change(function() {
        // Toggle the full text for the clicked item
        //   $(this).toggleClass('show-full-text');
        takes_id=$(this).attr("takes_id");
        
        if($(this).val()=="Pending"){
            return false;
        }
            
            acceptTask(takes_id,$(this).val());
        });
        $(".home_form-control option").each(function(index) {
            if ($(this).val() === 'Pending') {
                $(this).attr("class", "badge bg-secondary");
                                } else if ($(this).val() === 'In Process') {
                                    $(this).attr("class", "badge bg-warning");
                                } else if ($(this).val() === 'Completed') {
                                    $(this).attr("class", "badge bg-success");
                                }
                            });
            $("select[name=status]").each(function(index) {
                                if ($(this).val() === 'Pending') {
                                    $(this).attr("class", "badge bg-secondary");
                                } else if ($(this).val() === 'In Process') {
                                    $(this).attr("class", "badge bg-warning");
                                } else if ($(this).val() === 'Completed') {
                                    $(this).attr("class", "badge bg-success");
                                }
                            }); 
                                                       
                                
  });
  // Define the function to accept the task
  function acceptTask(taskId, taskStatus) {

    // if(taskStatus == 'Pending'){
    //     updateStatus = 'In Process'
    // }else if (taskStatus == 'In Process') {
    //     updateStatus = 'Completed'
    // }

    var tasksData = {
        id :taskId,
        status: taskStatus,
    };
    console.log(tasksData);

    $.ajax({
        url: '<?= $this->Url->build(['controller' => 'Tasks', 'action' => 'edit']) ?>',
        type: 'GET',
        data: {data:tasksData},
        success: function(response) {
            // Handle success response
            console.log(response);
            location.reload();
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.log(xhr.responseText);
        }
    });
}
</script>
<script>
  // Parse the deadline as a Date object
  <?php if (isset($specialtask) && $specialtask->deadline !== null) : ?>
    var deadline = new Date('<?= $specialtask->deadline ?>');
  <?php endif; ?>

  function updateDueDateColor() {
    var now = new Date();
    var timeLeft = (deadline - now) / 1000 / 60; // Time left in minutes

    var dueDateElement = document.getElementById('dueDate');

    if (timeLeft < 0) {
      // Deadline has passed
      dueDateElement.style.color = 'red';
    } else if (timeLeft < 60) {
      // Less than an hour left
      dueDateElement.style.color = 'orange';
    } else if (timeLeft < 24 * 60) {
      // Less than a day left
      dueDateElement.style.color = 'yellow';
      dueDateElement.classList.add('text-warning'); // Bootstrap class for warning color
    } else {
      // More than a day left
      dueDateElement.classList.add('text-success'); // Bootstrap class for success color
    }
  }

  // Initial call
  updateDueDateColor();

  // Set an interval to check regularly
  setInterval(updateDueDateColor, 60000); // Checks every minute
</script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let timer = null;
            let elapsedTime = 0; // Time in seconds
            const timerDisplay = document.getElementById('timerDisplay');
            const totalHoursWorkedToday = document.getElementById('totalHoursWorkedToday');
            const totalHoursWorkedWeek = document.getElementById('totalHoursWorkedWeek'); // Element to display weekly hours
            const clockInButton = document.getElementById('clockInButton');
            const clockOutButton = document.getElementById('clockOutButton');

            function restoreTimerState() {
                const savedState = localStorage.getItem('timerState');
                if (savedState) {
                    const state = JSON.parse(savedState);
                    elapsedTime = state.elapsedTime;
                    if (state.running) {
                        startTimer();
                    } else {
                        timerDisplay.textContent = formatTime(elapsedTime);
                    }
                }
            }

            function startTimer() {
                timer = setInterval(function() {
                    elapsedTime++;
                    timerDisplay.textContent = formatTime(elapsedTime);
                    saveTimerState(true);
                }, 1000);
                clockInButton.style.display = 'none';
                clockOutButton.style.display = 'block';
            }

            function stopTimer() {
                clearInterval(timer);
                timer = null;
                saveTimerState(false);
                clockOutButton.style.display = 'none';
                clockInButton.style.display = 'block';
            }

            function saveTimerState(running) {
                localStorage.setItem('timerState', JSON.stringify({ elapsedTime, running }));
            }

            clockInButton.addEventListener('click', function() {
                startTimer();
            });

            clockOutButton.addEventListener('click', function() {
                stopTimer();
                totalHoursWorkedToday.textContent = "Total Hours Worked Today: " + formatTime(elapsedTime);
                elapsedTime = 0;
                timerDisplay.textContent = formatTime(elapsedTime);
            });

            function formatTime(seconds) {
                const hrs = Math.floor(seconds / 3600);
                const mins = Math.floor((seconds % 3600) / 60);
                const secs = seconds % 60;
                return `${hrs} hours ${mins} minutes ${secs} seconds`;
            }

            restoreTimerState();
        });





    </script>
</main>
