<?php

namespace App\Listeners;

use App\Enum\Role;
use App\Models\User;
use App\Notifications\UserRegistered;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNotificationToAdmin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {
        Notification::send(User::adminAndRoles(Role::SUPPORT)->get(), new UserRegistered($event->user));
    }
}
