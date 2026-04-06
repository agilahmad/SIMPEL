<?php

namespace App\Services;

use App\Enums\RepairedStat;
use App\Enums\TypeTest;
use App\Models\Evidence;
use App\Models\Pentest;
use Illuminate\Http\Request;

class VaService
{
    public function create(array $validated): Pentest
    {
        $va = Pentest::create([
            'type'           => TypeTest::VA->value,
            'application_id' => $validated['application_id'],
            'pentest_date'   => $validated['pentest_date'],
            'repaired_date'  => $validated['repaired_date'] ?? null,
            'link'           => $validated['link'] ?? null,
            'created_by'     => auth()->id(),
        ]);

        $this->syncVulnerabilities($va, $validated['vulnerabilities'] ?? []);

        return $va;
    }

    public function update(Pentest $va, array $validated): Pentest
    {
        $va->update([
            'application_id'  => $validated['application_id'],
            'repaired_status' => $validated['repaired_status'],
            'pentest_date'    => $validated['pentest_date'],
            'repaired_date'   => $validated['repaired_date'] ?? null,
            'link'            => $validated['link'] ?? null,
        ]);

        if (! empty($validated['vulnerabilities'])) {
            $va->vulnerability()->delete();
            $this->syncVulnerabilities($va, $validated['vulnerabilities']);
        }

        return $va;
    }

    public function delete(Pentest $va)
    {
        $va->delete();
    }

    public function storeEvidences(Request $request, Pentest $va)
    {
        foreach ($request->file('files') as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path     = $file->storeAs(
                "evidences/vas/{$va->id}",
                $fileName,
                'public'
            );

            $va->programmerEvidences()->create([
                'uploaded_by'   => auth()->id(),
                'uploader_role' => 'programmer',
                'file_path'     => $path,
                'file_name'     => $fileName,
                'status'        => 'pending',
            ]);
        }
    }

    public function approveEvidence(Pentest $va, Evidence $evidence)
    {
        $evidence->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        $va->update([
            'repaired_status' => RepairedStat::Selesai->value,
        ]);
    }

    public function rejectEvidence(Evidence $evidence, string $rejectionNote)
    {
        $evidence->update([
            'status'         => 'rejected',
            'rejection_note' => $rejectionNote,
        ]);
    }

    private function syncVulnerabilities(Pentest $va, array $vulnerabilities)
    {
        if (empty($vulnerabilities)) {
            return;
        }

        $va->vulnerability()->createMany(
            collect($vulnerabilities)->map(fn($v) => [
                'vulnerability_name' => $v['vulnerability_name'],
                'severity'           => $v['severity'],
                'repaired_status'    => $v['repaired_status'],
            ])->toArray()
        );
    }
}