<?php

namespace App\Notifications;

use App\Models\Evidence;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EvidenceRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(public Evidence $evidence)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $evidenceable = $this->evidence->evidenceable;
        return [
            'type'        => 'incident_rejected_programmer',
            'title'       => 'Bukti Perbaikan Ditolak',
            'message'     => sprintf(
                'Bukti perbaikan untuk "%s" ditolak. Alasan: %s',
                $evidenceable->vulnerability_name ?? $evidenceable->application->application_name ?? '-',
                $this->evidence->rejection_note ?? '-',
            ),
            'url'         => route('incidents.show', $evidenceable),
            'incident_id' => $evidenceable->id,
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
