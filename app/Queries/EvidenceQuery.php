<?php

namespace App\Queries;

use App\Models\Incident;
use App\Models\Pentest;
use Illuminate\Database\Eloquent\Model;

class EvidenceQuery
{
    public function resolveEvidenceable(string $type, int $id)
    {
        return match($type) {
            'pentest'  => Pentest::findOrFail($id),
            'incident' => Incident::findOrFail($id),
        };
    }

    public function getRedirectRoute(string $type, Model $model): string
    {
        return match($type) {
            'pentest'  => route('pentests.show', $model),
            'incident' => route('incidents.show', $model),
        };
    }
}