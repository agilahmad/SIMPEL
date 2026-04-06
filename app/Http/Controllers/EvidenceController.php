<?php

namespace App\Http\Controllers;

use App\Http\Requests\Evidence\RejectEvidenceRequest;
use App\Http\Requests\Evidence\StoreEvidenceRequest;
use App\Models\Evidence;
use App\Services\EvidenceService;

class EvidenceController extends Controller
{
    public function __construct(
        private readonly EvidenceService $service,
    ) {}

    public function store(StoreEvidenceRequest $request)
    {
        $redirectUrl = $this->service->store(
            evidenceableType: $request->evidenceable_type,
            evidenceableId:   (int) $request->evidenceable_id,
            file:             $request->file('file'),
        );

        return redirect($redirectUrl)
            ->with('success', 'Bukti berhasil diupload, menunggu persetujuan admin.');
    }

    public function approve(Evidence $evidence)
    {
        $this->service->approve($evidence);

        return redirect()->back()->with('success', 'Bukti disetujui.');
    }

    public function reject(RejectEvidenceRequest $request, Evidence $evidence)
    {
        $this->service->reject($evidence, $request->validated()['rejection_note']);

        return redirect()->back()->with('success', 'Bukti ditolak.');
    }
}
