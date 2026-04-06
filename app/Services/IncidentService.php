<?php

namespace App\Services;

use App\DTO\IncidentStatsDTO;
use App\Enums\IncidentType;
use App\Enums\RepairedStat;
use App\Enums\Role;
use App\Models\Application;
use App\Models\Evidence;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\EvidenceApprovedNotification;
use App\Notifications\EvidenceRejectedNotification;
use App\Notifications\EvidenceUploadedNotification;
use App\Notifications\IncidentCreatedNotification;
use App\Notifications\IncidentResolvedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class IncidentService
{
    public function create(array $validated): Incident
    {
        if (empty($validated['pic_id'])) {
            $application            = Application::find($validated['application_id']);
            $validated['pic_id']    = $application?->programmer_id;
        }

        $validated['created_by'] = auth()->id();

        $incident = Incident::create($validated);

        $this->notifyAdmins(new IncidentCreatedNotification($incident));

        return $incident;
    }

    public function update(Incident $incident, array $validated): Incident
    {
        $incident->update($validated);

        return $incident;
    }

    public function updateStatus(Incident $incident, array $validated): Incident
    {
        $incident->update($validated);

        $isResolved = ($validated['repaired_status'] ?? null) === RepairedStat::Selesai->value;

        if ($isResolved && $incident->creator) {
            $incident->creator->notify(new IncidentResolvedNotification($incident));
        }

        return $incident;
    }

    public function delete(Incident $incident): void
    {
        $incident->delete();
    }

    public function matchApplication(Incident $incident, int $applicationId): Incident
    {
        $application = Application::findOrFail($applicationId);

        $incident->update([
            'application_id' => $application->id,
            'pic_id'         => $incident->pic_id ?? $application->programmer_id,
        ]);

        return $incident;
    }

    public function storeUserEvidences(Request $request, Incident $incident): void
    {
        if (! $request->hasFile('evidences')) {
            return;
        }

        foreach ($request->file('evidences') as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path     = $file->storeAs(
                "evidences/incidents/{$incident->id}",
                $fileName,
                'public'
            );

            $incident->userEvidences()->create([
                'uploaded_by'   => auth()->id(),
                'uploader_role' => auth()->user()->role->value,
                'file_path'     => $path,
                'file_name'     => $fileName,
                'status'        => 'approved',
            ]);
        }
    }

    public function storeProgrammerEvidences(Request $request, Incident $incident): void
    {
        foreach ($request->file('files') as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path     = $file->storeAs(
                "evidences/incidents/{$incident->id}",
                $fileName,
                'public'
            );

            $evidence = $incident->programmerEvidences()->create([
                'uploaded_by'   => auth()->id(),
                'uploader_role' => 'programmer',
                'file_path'     => $path,
                'file_name'     => $fileName,
                'status'        => 'pending',
            ]);

            $this->notifyAdmins(new EvidenceUploadedNotification($evidence));
        }
    }

    public function approveEvidence(Evidence $evidence): void
    {
        $evidence->load('evidenceable');

        $evidence->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        $evidence->uploader->notify(new EvidenceApprovedNotification($evidence));
    }

    public function rejectEvidence(Evidence $evidence, string $rejectionNote): void
    {
        $evidence->update([
            'status'         => 'rejected',
            'rejection_note' => $rejectionNote,
        ]);

        if ($evidence->uploader) {
            $evidence->uploader->notify(new EvidenceRejectedNotification($evidence));
        }
    }

    private function notifyAdmins(object $notification): void
    {
        $admins = User::where('role', Role::Admin->value)->get();
        Notification::send($admins, $notification);
    }

    public function saveFromExternalReport(array $item, int $applicationId): Incident
    {
        $application = Application::findOrFail($applicationId);

        $incident = Incident::create([
            'type'             => IncidentType::LaporanMasyarakat->value,
            'application_id'   => $application->id,
            'pic_id'           => $application->programmer_id,
            'vulnerability_name' => $item['vulnerability_name'],
            'severity'         => $item['severity'],
            'reporting_date'   => $item['reporting_date'],
            'reporter_name'    => $item['reporter_name']    ?? null,
            'file_path'        => $item['file_path']        ?? null,
            'ticket_code'      => $item['ticket_code'],
            'repaired_status'  => RepairedStat::Belum->value,
            'created_by'       => auth()->id(),
        ]);

        $this->notifyAdmins(new IncidentCreatedNotification($incident));

        return $incident;
    }
}
