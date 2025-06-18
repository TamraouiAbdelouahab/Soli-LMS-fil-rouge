<?php

namespace Modules\PkgSanction\App\Services;

use Illuminate\Notifications\DatabaseNotification;

class NotificationService
{
    public function markAsRead($notificationId): void
    {
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($notificationId);

        $notification->markAsRead();
    }
}
