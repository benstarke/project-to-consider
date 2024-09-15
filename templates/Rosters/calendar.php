<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Roster> $rosters
 */

echo $this->Html->css('//cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.css',['block' => true]);
echo $this->Html->script('//cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.js',['block' => true]);
echo $this->Html->script('https://code.jquery.com/jquery-3.6.0.min.js',['block' => true]);



?>
<?= $this->Html->css(['calendar']) ?>
<main>
<div class="rosters index content">
    <div class="">
        <nav class="bg-light d-flex justify-content-between align-items-center">
            <div class="ml-5 mr-3">
                <h3 class='text-primary'><?= __('Roster & Shift Management') ?></h3>
                <ol class="breadcrumb" style="margin: 0;">
                    <li class="breadcrumb-item text-decoration-none"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class='text-decoration-none text-info'>Dashboard</a></li>
                    <?= $this->Html->link(__('Rosters'), ['action' => 'index'], ['class' => 'breadcrumb-item active text-decoration-none']) ?>
                </ol>
            </div>
            <div>
                <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-table fa-sm text-white-50"></i> Table View</a>
                <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50"></i> New Roster</a>
            </div>
        </nav>
    </div>
    <br>
</div>
<div class="">
<div class="ml-2"id='calendar'></div>
</div>

<script>
$(document).ready(function () {
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
</main>

