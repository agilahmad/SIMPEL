<?php

namespace App\Notifications;

use App\Models\Evidence;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EvidenceUploadedNotification extends Notification
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
            'type'        => 'incident_in_progress_admin',
            'title'       => 'Bukti Perbaikan Masuk',
            'message'     => sprintf(
                'Programmer telah mengupload bukti perbaikan untuk "%s".',
                $evidenceable->vulnerability_name ?? '-',
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
