<?php

namespace App\Events;

use App\Models\Interview;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InterviewCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $interview;

    /**
     * Create a new event instance.
     *
     * @param Interview $interview
     */
    public function __construct(Interview $interview)
    {
        $this->interview = $interview;
    }
}