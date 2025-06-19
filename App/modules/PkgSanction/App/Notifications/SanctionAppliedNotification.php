<?php

namespace Modules\PkgSanction\App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\PkgSanction\App\Models\SanctionAbsence;

class SanctionAppliedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $sanction;

    public function __construct(SanctionAbsence $sanction)
    {
        $this->sanction = $sanction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Nouvelle sanction appliquée',
            'message' => 'Une sanction vous a été appliquée pour absences injustifiées.',
            'sanction_id' => $this->sanction->id,
            'url' => route('learner.sanction.index'),
        ];
    }

}
