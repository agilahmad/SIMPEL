<?php

namespace App\Http\Controllers;

use App\Enums\{RepairedStat, };
use App\Http\Requests\Assesment\{StoreVaTestRequest, UpdateVaTestRequest};
use App\Http\Requests\Evidence\{RejectEvidenceRequest, StoreEvidenceRequest};
use App\Models\Application;
use App\Models\Evidence;
use App\Models\Pentest;
use App\Queries\VaQuery;
use App\Services\VaService;

class VulnAssesController extends Controller
{
    public function __construct(
        private readonly VaQuery   $query,
        private readonly VaService $service,
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Pentest::class);

        return view('vas.index', [
            'items'       => $this->query->getPaginatedWithRelations(),
            ...$this->query->getStatusCounts(),
            'type'        => 'va',
            'routePrefix' => 'vas',
            'label'       => 'Vulnerability Assessment',
        ]);
    }

    public function create()
    {
        $this->authorize('create', Pentest::class);

        return view('vas.create', [
            'applications' => Application::with('programmer')->orderBy('application_name')->get(),
            'status'       => RepairedStat::cases(),
        ]);
    }

    public function show(Pentest $va)
    {
        $this->authorize('view', $va);

        return view('vas.show', [
            'pentest'     => $this->query->findWithRelations($va),
            'type'        => 'va',
            'routePrefix' => 'vas',
            'label'       => 'Vulnerability Assessment',
        ]);
    }

    public function edit(Pentest $va)
    {
        $this->authorize('update', $va);

        return view('vas.edit', [
            'pentest'      => $va,
            'applications' => Application::with('programmer')->orderBy('application_name')->get(),
            'status'       => RepairedStat::cases(),
        ]);
    }

    public function store(StoreVaTestRequest $request)
    {
        $this->authorize('create', Pentest::class);

        $this->service->create($request->validated());

        return redirect()->route('vas.index')
            ->with('success', 'Vulnerability Assessment berhasil dibuat.');
    }

    public function update(UpdateVaTestRequest $request, Pentest $va)
    {
        $this->authorize('update', $va);

        $this->service->update($va, $request->validated());

        return redirect()->route('vas.show', $va)
            ->with('success', 'Vulnerability Assessment berhasil diupdate.');
    }

    public function destroy(Pentest $va)
    {
        $this->authorize('delete', $va);

        $this->service->delete($va);

        return redirect()->route('vas.index')
            ->with('success', 'Vulnerability Assessment berhasil dihapus.');
    }

    public function storeEvidence(StoreEvidenceRequest $request, Pentest $va)
    {
        $this->service->storeEvidences($request, $va);

        return redirect()->route('vas.show', $va)
            ->with('success', 'Bukti perbaikan berhasil diupload.');
    }

    public function approveEvidence(Pentest $va, Evidence $evidence)
    {
        $this->service->approveEvidence($va, $evidence);

        return back()->with('success', 'Bukti disetujui.');
    }

    public function rejectEvidence(RejectEvidenceRequest $request, Pentest $va, Evidence $evidence)
    {
        $this->service->rejectEvidence($evidence, $request->validated()['rejection_note']);

        return back()->with('error', 'Bukti ditolak. Programmer harus upload ulang.');
    }
}
