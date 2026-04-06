<?php

namespace App\DTO;

class IncidentStatsDTO
{
    public static function fromQuery($stats)
    {
        $total = $stats->total;

        $pct = fn($value) =>
            $total > 0 ? round($value / $total * 100) : 0;

        return [
            'critical' => $stats->critical,
            'high' => $stats->high,
            'medium' => $stats->medium,
            'low' => $stats->low,
            'informational' => $stats->informational,

            'critical_pct' => $pct($stats->critical),
            'high_pct' => $pct($stats->high),
            'medium_pct' => $pct($stats->medium),
            'low_pct' => $pct($stats->low),
            'informational_pct' => $pct($stats->informational),

            'belum' => $stats->belum,
            'in_progress' => $stats->in_progress,
            'resolved' => $stats->resolved,

            'belum_pct' => $pct($stats->belum),
            'in_progress_pct' => $pct($stats->in_progress),
            'resolved_pct' => $pct($stats->resolved),
        ];
    }
}
