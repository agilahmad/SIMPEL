<?php

namespace App\Queries;

use App\Enums\IncidentType;
use App\Models\{Incident};
use App\Models\Application;
use App\Models\CommunityReportStaging;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class IncidentQuery
{
    public function getPaginated(?string $type, ?string $severity, int $perPage = 15): LengthAwarePaginator
    {
        $query = Incident::with(['application', 'pic'])->latest();

        $this->applyTypeFilter($query, $type);
        $this->applySeverityFilter($query, $severity);
        $this->applyProgrammerScope($query);

        return $query->paginate($perPage)->withQueryString();
    }

    public function getStats(?string $type, ?string $severity = null): array
    {
        $baseQuery = Incident::query();
        $this->applyTypeFilter($baseQuery, $type);
        $this->applySeverityFilter($baseQuery, $severity);

        $total = (clone $baseQuery)->count();

        $severityCounts = (clone $baseQuery)
            ->selectRaw('severity::text, COUNT(*) as total')
            ->groupBy('severity')
            ->pluck('total', 'severity');

        $statusCounts = (clone $baseQuery)
            ->selectRaw('repaired_status::text, COUNT(*) as total')
            ->groupBy('repaired_status')
            ->pluck('total', 'repaired_status');

        return $this->buildStatsArray($total, $severityCounts, $statusCounts);
    }

    public function findWithRelations(Incident $incident): Incident
    {
        return $incident->load([
            'application',
            'pic',
            'creator',
            'evidences.uploader',
            'evidences.approver',
        ]);
    }

    public function getUnreadNotifications(): int
    {
        if (! auth()->user()->isAdmin()) {
            return 0;
        }

        return DB::table('notifications')
            ->where('notifiable_id', auth()->id())
            ->whereNull('read_at')
            ->whereRaw("data::jsonb->>'type' = 'incident_created_admin'")
            ->count();
    }

    private function applyTypeFilter($query, ?string $type): void
    {
        if ($type) {
            $query->where('type', $type);
        }
    }

    private function applySeverityFilter($query, ?string $severity): void
    {
        if ($severity) {
            $query->where('severity', $severity);
        }
    }

    private function applyProgrammerScope($query): void
    {
        if (auth()->user()->isProgrammer()) {
            $query->where('pic_id', auth()->id());
        }
    }

    private function buildStatsArray(int $total, $severityCounts, $statusCounts): array
    {
        $pct = fn($count) => $total > 0 ? round($count / $total * 100) : 0;

        return [
            'critical'      => $severityCounts['critical']      ?? 0,
            'high'          => $severityCounts['high']          ?? 0,
            'medium'        => $severityCounts['medium']        ?? 0,
            'low'           => $severityCounts['low']           ?? 0,
            'informational' => $severityCounts['informational'] ?? 0,

            'critical_pct'      => $pct($severityCounts['critical']      ?? 0),
            'high_pct'          => $pct($severityCounts['high']          ?? 0),
            'medium_pct'        => $pct($severityCounts['medium']        ?? 0),
            'low_pct'           => $pct($severityCounts['low']           ?? 0),
            'informational_pct' => $pct($severityCounts['informational'] ?? 0),

            'belum'       => $statusCounts['belum_dilakukan'] ?? 0,
            'in_progress' => $statusCounts['dalam_proses']    ?? 0,
            'resolved'    => $statusCounts['selesai']         ?? 0,

            'belum_pct'       => $pct($statusCounts['belum_dilakukan'] ?? 0),
            'in_progress_pct' => $pct($statusCounts['dalam_proses']    ?? 0),
            'resolved_pct'    => $pct($statusCounts['selesai']         ?? 0),
        ];
    }

    public function getExternalReport(string $id)
    {
        // return DB::table('external_reports')
        //     ->where('id', $id)
        //     ->first(
        //         columns: [
        //             'id',
        //             'ticket_code',
        //             'application_name',
        //             'vulnerability_name',
        //             'severity',
        //             'reporting_date',
        //             'reporter_name',
        //             'file_path',
        //         ]
        //     ) ?? abort(404, 'Laporan tidak ditemukan.');

        return CommunityReportStaging::findOrFail($id);
    }

    public function getApplicationsWithProgrammer()
    {
        return Application::with('programmer')
            ->orderBy('application_name')
            ->get();
    }

    public function getPendingStagings(int $perPage = 15)
    {
        return CommunityReportStaging::where('status', 'pending')
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getSavedCommunityReports(int $perPage = 15)
    {
        return Incident::with(['application', 'pic'])
            ->where('type', IncidentType::LaporanMasyarakat->value)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }
}
