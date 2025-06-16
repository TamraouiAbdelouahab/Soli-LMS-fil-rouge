<?php

namespace Modules\PkgSanction\App\Services;

use Illuminate\Notifications\DatabaseNotification;

class NotificationService
{
    public function markAsRead($notificationId, $redirectUrl = null)
    {
        $notification = auth()->user()->notifications()
            ->findOrFail($notificationId);

        $notification->markAsRead();

        return $this->validateRedirectUrl($redirectUrl);
    }

    protected function validateRedirectUrl($url)
    {
        if (!$url) {
            return route('dashboard');
        }

        $allowedHosts = [parse_url(config('app.url'))['host']];
        $host = parse_url($url, PHP_URL_HOST);

        if (!in_array($host, $allowedHosts)) {
            report(new \Exception("Invalid notification redirect attempt to: {$url}"));
            return route('dashboard');
        }

        return $url;
    }
}
