<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Strategies\LoadBalancerStrategy::class,
            \App\Strategies\LowestWorkloadStrategy::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Event::listen(
            \App\Events\InterviewCreated::class,
            \App\Listeners\GenerateInterviewBriefListener::class
        );

        \Illuminate\Support\Facades\Event::listen(
            \App\Events\InterviewCreated::class,
            \App\Listeners\SendInterviewNotificationsListener::class
        );
    }
}
