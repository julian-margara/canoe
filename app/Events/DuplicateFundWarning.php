<?php

namespace App\Events;

use App\Models\Fund;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DuplicateFundWarning
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * @var Fund
     */
    public Fund $fund;

    /**
     * Create a new event instance.
     */
    public function __construct(Fund $fund)
    {
        $this->fund = $fund;
    }
}
