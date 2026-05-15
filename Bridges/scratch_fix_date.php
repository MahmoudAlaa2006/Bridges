<?php

use App\Models\User;
use App\Models\Interview;
use App\Models\Slot;
use Carbon\Carbon;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'aditya52@example.net';
$interviewer = User::where('email', $email)->first();

if (!$interviewer) {
    die("Error: Interviewer $email not found.\n");
}

$interview = Interview::whereHas('panels', function($q) use ($interviewer) {
    $q->where('user_id', $interviewer->id);
})->orderBy('id', 'desc')->first();

if ($interview) {
    // Set to May 12, 2026, 01:00:00 AM
    $targetDate = Carbon::create(2026, 5, 12, 1, 0, 0);
    
    $interview->update([
        'get_date' => $targetDate,
        'content' => 'FIXED: One AM Assessment (May 12)'
    ]);
    
    if ($interview->slot) {
        $interview->slot->update([
            'date' => $targetDate->format('Y-m-d'),
            'start_time' => $targetDate->format('H:i:s'),
            'end_time' => (clone $targetDate)->modify('+1 hour')->format('H:i:s'),
        ]);
    }
    
    echo "Success: Interview for $email updated to " . $targetDate->toDateTimeString() . ".\n";
} else {
    echo "Error: No interview found for $email.\n";
}
