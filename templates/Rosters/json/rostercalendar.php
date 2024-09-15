<?php
$newShifts = [];

foreach ($shifts as $shift) {
    // Ensure you are accessing the properties correctly
    $title = (isset($shift->user_firstname) ? $shift->user_firstname : 'Unknown User') . 
                ' '.
            (isset($shift->user_lastname) ? $shift->user_lastname : 'Unknown User') . 
             ' as ' . 
             (isset($shift->role_name) ? $shift->role_name : 'Unknown Role');

    $newShifts[] = [
        'id' => $shift->id,
        'title' => $title,
        'start' => $shift->start_time->format('c'), // Make sure start_time and end_time are DateTime objects
        'end' => $shift->end_time->format('c'),
        'role' => $shift->role_name,
        'name' =>(isset($shift->user_firstname) ? $shift->user_firstname : 'Unknown User') . ' '.(isset($shift->user_lastname) ? $shift->user_lastname : 'Unknown User'),
        'email' => $shift->email,
        'phone' => $shift->phone,
    ];
}

echo json_encode($newShifts);
?>
