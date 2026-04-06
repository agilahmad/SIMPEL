<?php

namespace App\Enums;

enum IncidentType: string{
    case PotensiInsiden = 'potential_incident';
    case LaporanMasyarakat = 'community_report';
}
