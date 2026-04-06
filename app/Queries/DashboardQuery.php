<?php

namespace App\Queries;

use App\Enums\RepairedStat;
use App\Enums\Severity;
use App\Models\Application;
use App\Models\Incident;
use App\Models\Pentest;
use App\Models\User;
use App\Models\Vulnerability;
use Illuminate\Support\Facades\DB;

class DashboardQuery
{
    public function getGeneralStats(): array
    {
        $criticalUnfixed =
            Vulnerability::where('severity', Severity::Critical->value)
                ->where('repaired_status', RepairedStat::Belum->value)
                ->count()
            +
            Incident::where('severity', Severity::Critical->value)
                ->where('repaired_status', RepairedStat::Belum->value)
                ->count();

        return [
            'total_pentests'   => Pentest::pentest()->count(),
            'total_vas'        => Pentest::VA()->count(),
            'total_incident'   => Incident::count(),
            'critical_unfixed' => $criticalUnfixed,
        ];
    }

    // ==================== PENTEST / VA ====================

    public function getPentestTypeStats(string $type): array
    {
        return [
            'repaired_status'  => $this->getPentestRepairedStatus($type),
            'severity'         => $this->getPentestSeverity($type),
            'per_year'         => $this->getPentestPerYear($type),
            'finding_types'    => $this->getPentestFindingTypes($type),
            'programmer_stats' => $this->getPentestProgrammerStats($type),
            'app_count'        => $this->getPentestAppCount($type),
            'latest'           => $this->getLatestPentests($type),
        ];
    }

    private function getPentestRepairedStatus(string $type): array
    {
        return array_merge(
            ['belum_dilakukan' => 0, 'dalam_proses' => 0, 'selesai' => 0],
            Vulnerability::selectRaw('repaired_status::text AS repaired_status, COUNT(*) AS total')
                ->whereHas('pentest', fn($q) => $q->where('type', $type))
                ->groupBy('repaired_status')
                ->pluck('total', 'repaired_status')
                ->toArray()
        );
    }

    private function getPentestSeverity(string $type): array
    {
        return array_merge(
            ['critical' => 0, 'high' => 0, 'medium' => 0, 'low' => 0, 'informational' => 0],
            Vulnerability::selectRaw('severity::text AS severity, COUNT(*) AS total')
                ->whereHas('pentest', fn($q) => $q->where('type', $type))
                ->groupBy('severity')
                ->pluck('total', 'severity')
                ->toArray()
        );
    }

    private function getPentestPerYear(string $type): array
    {
        return Pentest::selectRaw('EXTRACT(YEAR FROM pentest_date)::integer AS year, COUNT(*) AS total')
            ->where('type', $type)
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('total', 'year')
            ->toArray();
    }

    private function getPentestFindingTypes(string $type): array
    {
        return Vulnerability::selectRaw('vulnerability_name, COUNT(*) AS total')
            ->whereHas('pentest', fn($q) => $q->where('type', $type))
            ->groupBy('vulnerability_name')
            ->orderByDesc('total')
            ->limit(10)
            ->pluck('total', 'vulnerability_name')
            ->toArray();
    }

    private function getPentestProgrammerStats(string $type)
    {
        return User::select('users.name', DB::raw('COUNT(pentests.id) AS pentest_count'))
            ->join('applications', 'applications.programmer_id', '=', 'users.id')
            ->join('pentests', 'pentests.application_id', '=', 'applications.id')
            ->where('pentests.type', $type)
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('pentest_count')
            ->limit(8)
            ->get();
    }

    private function getPentestAppCount(string $type)
    {
        return Application::select('application_name', DB::raw('COUNT(pentests.id) AS pentests_count'))
            ->join('pentests', 'pentests.application_id', '=', 'applications.id')
            ->where('pentests.type', $type)
            ->groupBy('applications.id', 'application_name')
            ->orderByDesc('pentests_count')
            ->limit(8)
            ->get();
    }

    private function getLatestPentests(string $type)
    {
        return Pentest::with(['application', 'vulnerability'])
            ->withCount('vulnerability')
            ->where('type', $type)
            ->latest('pentest_date')
            ->take(5)
            ->get();
    }


    public function getIncidentTypeStats(string $type): array
    {
        $total = Incident::where('type', $type)->count();

        return [
            'total'            => $total,
            'critical_unfixed' => $this->getIncidentCriticalUnfixed($type),
            'repaired_status'  => $this->getIncidentRepairedStatus($type),
            'severity'         => $this->getIncidentSeverity($type),
            'per_year'         => $this->getIncidentPerYear($type),
            'finding_types'    => $this->getIncidentFindingTypes($type),
            'programmer_stats' => $this->getIncidentProgrammerStats($type),
            'app_count'        => $this->getIncidentAppCount($type),
            'latest'           => $this->getLatestIncidents($type),
        ];
    }

    private function getIncidentCriticalUnfixed(string $type): int
    {
        return Incident::where('type', $type)
            ->where('severity', Severity::Critical->value)
            ->where('repaired_status', RepairedStat::Belum->value)
            ->count();
    }

    private function getIncidentRepairedStatus(string $type): array
    {
        return array_merge(
            ['belum_dilakukan' => 0, 'dalam_proses' => 0, 'selesai' => 0],
            Incident::selectRaw('repaired_status::text AS repaired_status, COUNT(*) AS total')
                ->where('type', $type)
                ->groupBy('repaired_status')
                ->pluck('total', 'repaired_status')
                ->toArray()
        );
    }

    private function getIncidentSeverity(string $type): array
    {
        return array_merge(
            ['critical' => 0, 'high' => 0, 'medium' => 0, 'low' => 0, 'informational' => 0],
            Incident::selectRaw('severity::text AS severity, COUNT(*) AS total')
                ->where('type', $type)
                ->groupBy('severity')
                ->pluck('total', 'severity')
                ->toArray()
        );
    }

    private function getIncidentPerYear(string $type): array
    {
        return Incident::selectRaw('EXTRACT(YEAR FROM reporting_date)::integer AS year, COUNT(*) AS total')
            ->where('type', $type)
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('total', 'year')
            ->toArray();
    }

    private function getIncidentFindingTypes(string $type): array
    {
        return Incident::selectRaw('vulnerability_name, COUNT(*) AS total')
            ->where('type', $type)
            ->groupBy('vulnerability_name')
            ->orderByDesc('total')
            ->limit(10)
            ->pluck('total', 'vulnerability_name')
            ->toArray();
    }

    private function getIncidentProgrammerStats(string $type)
    {
        return User::select('users.name', DB::raw('COUNT(incidents.id) AS incident_count'))
            ->join('applications', 'applications.programmer_id', '=', 'users.id')
            ->join('incidents', 'incidents.application_id', '=', 'applications.id')
            ->where('incidents.type', $type)
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('incident_count')
            ->limit(8)
            ->get();
    }

    private function getIncidentAppCount(string $type)
    {
        return Application::select('application_name', DB::raw('COUNT(incidents.id) AS incident_count'))
            ->join('incidents', 'incidents.application_id', '=', 'applications.id')
            ->where('incidents.type', $type)
            ->groupBy('applications.id', 'application_name')
            ->orderByDesc('incident_count')
            ->limit(8)
            ->get();
    }

    private function getLatestIncidents(string $type)
    {
        return Incident::with('application')
            ->where('type', $type)
            ->latest('reporting_date')
            ->take(5)
            ->get();
    }

    public function getUserStats(string $userId): array
    {
        return [
            'total_incidents'   => Incident::where('created_by', $userId)->count(),
            'incidents_belum'   => Incident::where('created_by', $userId)
                                    ->where('repaired_status', RepairedStat::Belum->value)
                                    ->count(),
            'incidents_proses'  => Incident::where('created_by', $userId)
                                    ->where('repaired_status', RepairedStat::Proses->value)
                                    ->count(),
            'incidents_selesai' => Incident::where('created_by', $userId)
                                    ->where('repaired_status', RepairedStat::Selesai->value)
                                    ->count(),
        ];
    }

    public function getUserRecentIncidents(string $userId)
    {
        return Incident::with('application')
            ->where('created_by', $userId)
            ->latest('reporting_date')
            ->take(5)
            ->get();
    }

    public function getProgrammerSeverityChart(string $userId): array
    {
        return array_merge(
            ['critical' => 0, 'high' => 0, 'medium' => 0, 'low' => 0, 'informational' => 0],
            Incident::selectRaw('severity::text AS severity, COUNT(*) AS total')
                ->where('pic_id', $userId)
                ->groupBy('severity')
                ->pluck('total', 'severity')
                ->toArray()
        );
    }

    public function getProgrammerAssignedIncidents(string $userId)
    {
        return Incident::with('application')
            ->where('pic_id', $userId)
            ->latest('reporting_date')
            ->take(5)
            ->get();
    }

    public function getProgrammerStatusCounts(string $userId): array
    {
        return [
            'totalAssigned'   => Incident::where('pic_id', $userId)->count(),
            'openCount'       => Incident::where('pic_id', $userId)
                                    ->where('repaired_status', RepairedStat::Belum->value)
                                    ->count(),
            'onProgressCount' => Incident::where('pic_id', $userId)
                                    ->where('repaired_status', RepairedStat::Proses->value)
                                    ->count(),
            'resolvedCount'   => Incident::where('pic_id', $userId)
                                    ->where('repaired_status', RepairedStat::Selesai->value)
                                    ->count(),
        ];
    }
}