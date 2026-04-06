<?php 

namespace App\Services;

use App\Enums\EvidenceStat;
use App\Enums\RepairedStat;
use App\Enums\Role;
use App\Models\Evidence;
use App\Models\Incident;
use App\Notifications\EvidenceApprovedNotification;
use App\Queries\EvidenceQuery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class EvidenceService
{
    public function __construct(
        private readonly EvidenceQuery $query,
    ) {}

    // ==================== STORE ====================

    public function store(
        string $evidenceableType,
        int    $evidenceableId,
        UploadedFile $file
    ): string {
        $user  = auth()->user();
        $model = $this->query->resolveEvidenceable($evidenceableType, $evidenceableId);

        $this->authorizeUpload($user, $evidenceableType, $model);

        $this->saveEvidence($model, $file, $user);

        return $this->query->getRedirectRoute($evidenceableType, $model);
    }

    // ==================== APPROVE ====================

    public function approve(Evidence $evidence): void
    {
        $evidence->update([
            'status'      => EvidenceStat::Approved->value,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        if ($evidence->uploader_role === Role::Programmer->value) {
            $this->markEvidenceableAsRepaired($evidence);
        }
    }

    public function reject(Evidence $evidence, string $rejectionNote): void
    {
        $evidence->update([
            'status'         => EvidenceStat::Rejected->value,
            'rejection_note' => $rejectionNote,
        ]);
    }

    private function authorizeUpload($user, string $type, Model $model): void
    {
        if ($user->isProgrammer()) {
            if ($type === 'incident' && $model->pic_id !== $user->id) {
                abort(403, 'Anda bukan PIC incident ini.');
            }

            return;
        }

        if ($user->isUser()) {
            if ($type !== 'incident') {
                abort(403, 'User hanya bisa upload bukti di laporan masyarakat.');
            }

            if ($model->type->value !== 'community_report') {
                abort(403, 'User hanya bisa upload bukti di laporan masyarakat.');
            }

            if ($model->created_by !== $user->id) {
                abort(403, 'Anda bukan pembuat laporan ini.');
            }

            return;
        }

        if (! $user->isAdmin()) {
            abort(403);
        }
    }

    private function saveEvidence(Model $model, UploadedFile $file, $user): void
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('evidences', $fileName, 'public');

        $model->evidences()->create([
            'uploaded_by'   => $user->id,
            'uploader_role' => $user->role->value,
            'file_path'     => $filePath,
            'file_name'     => $file->getClientOriginalName(),
            'status'        => EvidenceStat::Pending->value,
        ]);
    }

    private function markEvidenceableAsRepaired(Evidence $evidence): void
    {
        $evidenceable = $evidence->evidenceable;

        $evidenceable->update([
            'repaired_status' => RepairedStat::Selesai->value,
        ]);

        if ($evidenceable instanceof Incident) {
            $recipient = $evidenceable->creator;
            if ($recipient) {
                $recipient->notify(new EvidenceApprovedNotification($evidence));
            }
        }
    }
}