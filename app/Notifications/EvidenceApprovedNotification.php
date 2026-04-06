<?php

namespace App\Notifications;

use App\Models\Evidence;
use App\Models\Incident;
use App\Models\Pentest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EvidenceApprovedNotification extends Notification
{
    use Queueable;

    public function __construct(private Evidence $evidence)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable)    {
        $evidenceable = $this->evidence->evidenceable;

        $name       = $evidenceable->vulnerability_name
                    ?? $evidenceable->application->application_name
                    ?? '-';
        $identifier = $evidenceable->ticket_code
                    ?? $evidenceable->pentest_date
                    ?? '-';

        return [
            'type'        => 'community_report_done',
            'title'       => 'Laporan Anda Telah Diperbaiki',
            'message'     => sprintf('Insiden "%s" dengan tiket %s telah selesai diperbaiki.', $name, $identifier),
            'url'         => $this->evidence->evidenceable instanceof Incident
                                ? route('incidents.show', $evidenceable)
                                : route('pentests.show', $evidenceable),
            'incident_id' => $evidenceable instanceof Incident ? $evidenceable->id : null,
            'pentest_id'  => $evidenceable instanceof Pentest  ? $evidenceable->id : null,
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
