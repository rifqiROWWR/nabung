<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class LogSuccessfulLogin
{
    public function handleLogin(Login $event): void
    {
        ActivityLog::create([
            'user_id' => $event->user->id,
            'action' => 'Login',
            'description' => "{$event->user->name} masuk ke aplikasi",
        ]);
    }

    public function handleLogout(Logout $event): void
    {
        if ($event->user) {
            ActivityLog::create([
                'user_id' => $event->user->id,
                'action' => 'Logout',
                'description' => "{$event->user->name} keluar dari aplikasi",
            ]);
        }
    }
}