<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Evidence\StoreEvidenceRequest;
use App\Http\Requests\Incident\{ StoreIncidentRequest, UpdateIncidentRequest, UpdateStatusRequest };
use App\Http\Requests\Incident\IncidentStatusRequest;
use App\Http\Requests\Incident\SaveMasyarakatRequest;
use App\Models\{ Application, Evidence, Incident, User, };
use App\Queries\IncidentQuery;
use App\Services\IncidentService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IncidentController extends Controller
{
    public function __construct(
        private readonly IncidentQuery   $query,
        private readonly IncidentService $service,
    ) {}

    // ==================== VIEWS ====================

    public function index(): View
    {
        $this->authorize('viewAny', Incident::class);

        $type     = request('type');
        $severity = request('severity');

        return view('incidents.index', [
            'incidents'   => $this->query->getPaginated($type, $severity),
            'stats'       => $this->query->getStats($type, $severity),
            'unreadCount' => $this->query->getUnreadNotifications(),
            'type'        => $type,
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Incident::class);

        return view('incidents.create', [
            'applications' => Application::with('programmer')->orderBy('application_name')->get(),
            'programmers'  => User::where('role', 'programmer')->orderBy('name')->get(),
        ]);
    }

    public function show(Incident $incident): View
    {
        $this->authorize('view', $incident);

        return view('incidents.show', [
            'incident'     => $this->query->findWithRelations($incident),
            'applications' => Application::orderBy('application_name')->get(['id', 'application_name']),
            'programmers'  => auth()->user()->isAdmin()
                ? User::where('role', 'programmer')->orderBy('name')->get()
                : collect(),
        ]);
    }

    public function edit(Incident $incident): View
    {
        $this->authorize('update', $incident);

        return view('incidents.edit', [
            'incident'     => $incident,
            'applications' => Application::with('programmer')->orderBy('application_name')->get(),
            'programmers'  => User::where('role', 'programmer')->orderBy('name')->get(),
        ]);
    }

    public function masyarakat(): View
    {
         $items    = $this->query->getPendingStagings();
        $saved    = $this->query->getSavedCommunityReports();

        return view('incidents.index-masyarakat', [
            'items'       => $items,
            'currentPage' => $items->currentPage(),
            'lastPage'    => $items->lastPage(),
            'total'       => $items->total(),
            'savedItems'  => $saved,
        ]);
    }

    public function store(StoreIncidentRequest $request)
    {
        $incident = $this->service->create($request->validated());

        $this->service->storeUserEvidences($request, $incident);

        return redirect()->route('incidents.index')
            ->with('success', 'Incident berhasil dibuat.');
    }

    public function update(UpdateIncidentRequest $request, Incident $incident)
    {
        $this->authorize('update', $incident);

        $this->service->update($incident, $request->validated());

        return redirect()->route('incidents.show', $incident)
            ->with('success', 'Incident berhasil diupdate.');
    }

    public function destroy(Incident $incident)
    {
        $this->authorize('delete', $incident);

        $this->service->delete($incident);

        return redirect()->route('incidents.index')
            ->with('success', 'Incident berhasil dihapus.');
    }

    public function updateStatus(UpdateStatusRequest $request, Incident $incident)
    {
        $this->authorize('update', $incident);

        $this->service->updateStatus($incident, $request->validated());

        return redirect()->back()
            ->with('success', 'Status insiden berhasil diperbarui.');
    }

    public function matchApplication(Request $request, Incident $incident)
    {
        $request->validate([
            'application_id' => ['required', 'exists:applications,id'],
        ]);

        $this->service->matchApplication($incident, (int) $request->application_id);

        return back()->with('success', 'Aplikasi berhasil dicocokkan.');
    }

    public function storeEvidence(StoreEvidenceRequest $request, Incident $incident)
    {
        $this->service->storeProgrammerEvidences($request, $incident);

        return redirect()->route('incidents.show', $incident)
            ->with('success', 'Bukti perbaikan berhasil diupload.');
    }

    public function approveEvidence(Incident $incident, Evidence $evidence)
    {
        $this->service->approveEvidence($evidence);

        return back()->with('success', 'Bukti perbaikan disetujui.');
    }

    public function rejectEvidence(IncidentStatusRequest $request, Incident $incident, Evidence $evidence)
    {
        $this->service->rejectEvidence($evidence, $request->validated()['rejection_note']);

        return back()->with('error', 'Bukti ditolak.');
    }

    public function masyarakatShow(string $id)
    {
        // dd('masyarakatShow terpanggil', $id);
        return view('incidents.show-masyarakat', [
            'item'         => $this->query->getExternalReport($id),
            'applications' => $this->query->getApplicationsWithProgrammer(),
        ]);
    }

    public function masyarakatSave(SaveMasyarakatRequest $request, string $id)
    {
        $item     = $this->query->getExternalReport($id);
        $incident = $this->service->saveFromExternalReport(
            item:          (array) $item,
            applicationId: (int) $request->validated()['application_id'],
        );

        return redirect()->route('incidents.show', $incident)
            ->with('success', 'Laporan berhasil disimpan ke sistem.');
    }
}
