<?php

namespace App\Providers;

use App\Events\DuplicateFundWarning;
use App\Events\FundCreated;
use App\Listeners\DuplicateFundWarningListener;
use App\Listeners\ValidateDuplicateFund;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        FundCreated::class => [
            ValidateDuplicateFund::class
        ],

        DuplicateFundWarning::class => [
            DuplicateFundWarningListener::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
