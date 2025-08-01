<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Note;
use App\Models\User;
use App\Observers\NoteObserver;
use App\Observers\UserObserver;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
public function boot()
{
    Note::observe(NoteObserver::class);
    User::observe(UserObserver::class);
}
protected $listen = [
    \App\Events\UserRegistered::class => [
        \App\Listeners\SendWelcomeEmail::class,
    ],

    \App\Events\PasswordResetSuccessful::class => [
        \App\Listeners\HandlePasswordReset::class,
    ],
];



}
