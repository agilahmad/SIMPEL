<?php

namespace App\Services;

use App\Enums\IncidentType;
use App\Enums\TypeTest;
use App\Queries\DashboardQuery;

class DashboardService
{
    public function __construct(
        private readonly DashboardQuery $query,
    ) {}

    public function getAdminDashboardData(): array
    {
        return [
            'stats'        => $this->query->getGeneralStats(),
            'pentestStats' => $this->query->getPentestTypeStats(TypeTest::Pentest->value),
            'vaStats'      => $this->query->getPentestTypeStats(TypeTest::VA->value),
            'potensiStats' => $this->query->getIncidentTypeStats(IncidentType::PotensiInsiden->value),
            'laporanStats' => $this->query->getIncidentTypeStats(IncidentType::LaporanMasyarakat->value),
        ];
    }

    public function getProgrammerDashboardData(string $userId): array
    {
        return [
            ...$this->query->getProgrammerStatusCounts($userId),
            'severityChart'     => $this->query->getProgrammerSeverityChart($userId),
            'assignedIncidents' => $this->query->getProgrammerAssignedIncidents($userId),
        ];
    }

    public function getUserDashboardData(string $userId): array
    {
        return [
            'stats'           => $this->query->getUserStats($userId),
            'recentIncidents' => $this->query->getUserRecentIncidents($userId),
        ];
    }
}