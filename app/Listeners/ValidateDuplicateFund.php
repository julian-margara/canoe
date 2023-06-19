<?php

namespace App\Listeners;

use App\Events\DuplicateFundWarning;
use App\Events\FundCreated;
use App\Services\FundService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ValidateDuplicateFund
{
    private FundService $fundService;

    /**
     * Create the event listener.
     */
    public function __construct(FundService $fundService)
    {
        $this->fundService = $fundService;
    }

    /**
     * Handle the event.
     *
     * @param FundCreated $event
     * @return void
     */
    public function handle(FundCreated $event): void
    {
        $fund = $event->fund;

        // Validate
        if ($this->fundService->validateDuplicateFund($fund)) {
            DuplicateFundWarning::dispatch($fund);
        }
    }
}
