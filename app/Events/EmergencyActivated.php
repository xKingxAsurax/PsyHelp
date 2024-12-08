<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmergencyActivated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $emergency;

    public function __construct($emergency)
    {
        $this->emergency = $emergency;
    }
} 