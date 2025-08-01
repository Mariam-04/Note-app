<?php

namespace App\Listeners;

use App\Events\PasswordResetSuccessful;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class HandlePasswordReset implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PasswordResetSuccessful $event): void
    {
        // Example action: log it
        Log::info('Password was reset for user: ' . $event->user->email);

        // You can also notify the user or trigger analytics, etc.
    }
}
