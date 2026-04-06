<?php

namespace App\Notifications;

use App\Models\Incident;
use App\Models\CommunityReportStaging;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class IncidentCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(public Incident|CommunityReportStaging $incident){}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable)
    {
        return [
            'type'        => 'incident_created_admin',
            'title'       => 'Laporan Insiden Baru',
            'message'     => sprintf(
                'Insiden baru [%s] telah dilaporkan: "%s".',
                $this->incident->vulnerability_name,
            ),
            'url'         => route('incidents.masyarakat'),
            'incident_id' => $this->incident->id,
        ];
    }
}
