<?php
$newShifts = [];

foreach ($shifts as $shift) {
    // Ensure you are accessing the properties correctly
    $title = (isset($shift->user_first) ? $shift->user_first : 'Unknown User') .
             ' ' .
             (isset($shift->user_last) ? $shift->user_last : 'Unknown User') .
             ' as ' .
             (isset($shift->role_name) ? $shift->role_name : 'Unknown Role');

    // Determine shift type based on start time
    $startTime = $shift->start_time; // Assuming $startTime is already a DateTime object
    $hour = (int)$startTime->format('G'); // 'G' retrieves the hour in 24-hour format without leading zeros

    $shiftType = 'night'; // Default to night
    if ($hour < 12) {
        $shiftType = 'morning';
    } elseif ($hour >= 12 && $hour < 17) {
        $shiftType = 'afternoon';
    }

    $newShifts[] = [
        'id' => $shift->id,
        'title' => $title,
        'start' => $shift->start_time->format('c'), // ISO8601 format
        'end' => $shift->end_time->format('c'),
        'role' => $shift->role_name,
        'name' => (isset($shift->user_first) ? $shift->user_first : 'Unknown User') . ' ' . (isset($shift->user_last) ? $shift->user_last : 'Unknown User'),
        'email' => $shift->email,
        'phone' => $shift->phone,
        'shiftType' => $shiftType
    ];
}

echo json_encode($newShifts);
?>

