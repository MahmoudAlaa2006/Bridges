<?php

use App\Models\Interview;
use App\Models\Slot;
use Carbon\Carbon;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$interviews = Interview::all();

foreach ($interviews as $interview) {
    $currentDate = Carbon::parse($interview->get_date);
    if ($currentDate->format('Y-m-d') === '2026-05-11') {
        $newDate = $currentDate->copy()->addDay();
        
        $interview->update(['get_date' => $newDate]);
        
        if ($interview->slot) {
            $interview->slot->update([
                'date' => $newDate->format('Y-m-d'),
            ]);
        }
        echo "Updated Interview #{$interview->id} to {$newDate->format('Y-m-d')}\n";
    }
}
