<?php

namespace App\Notifications;

use App\Models\Incident;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class IncidentResolvedNotification extends Notification
{
    use Queueable;

    public function __construct(public Incident $incident){}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

public function toDatabase(object $notifiable): array
    {
        return [
            'type'        => 'community_report_done',
            'title'       => 'Laporan Anda Telah Diselesaikan',
            'message'     => \sprintf(
                'Insiden "%s" dengan tiket %s telah selesai diperbaiki.',
                $this->incident->vulnerability_name,
                $this->incident->ticket_code,
            ),
            'url'         => route('incidents.show', $this->incident),
            'incident_id' => $this->incident->id,
        ];
    }
}
