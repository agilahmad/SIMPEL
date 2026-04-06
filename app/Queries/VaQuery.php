<?php

namespace App\Queries;

use App\Enums\RepairedStat;
use App\Models\Pentest;

class VaQuery
{
    public function getPaginatedWithRelations(int $perPage = 10)
    {
        return Pentest::VA()
            ->with(['application', 'creator'])
            ->withCount('vulnerability')
            ->latest('pentest_date')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getStatusCounts(): array
    {
        return [
            'belum_dilakukan' => Pentest::VA()
                ->where('repaired_status', RepairedStat::Belum->value)
                ->count(),

            'proses' => Pentest::VA()
                ->where('repaired_status', RepairedStat::Proses->value)
                ->count(),

            'selesai' => Pentest::VA()
                ->where('repaired_status', RepairedStat::Selesai->value)
                ->count(),
        ];
    }

    public function findWithRelations(Pentest $va)
    {
        return $va->load([
            'application',
            'vulnerability',
            'creator',
            'evidences.uploader',
            'evidences.approver',
        ]);
    }
}