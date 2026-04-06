<?php

namespace App\Http\Requests\Incident;

use App\Enums\IncidentType;
use App\Enums\RepairedStat;
use App\Enums\Severity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateIncidentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $incident = $this->route('incident');
        return $this->user()->isAdmin() || $incident->pic_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'application_id'        => ['sometimes', 'exists:applications,id'],
            'type'                  => ['sometimes', new Enum(IncidentType::class)],
            'reporter_name'         => ['sometimes', 'string', 'max:255'],
            'reporter_id'           => ['sometimes', 'exists:users,id'],
            'pic_id'                => ['sometimes', 'exists:users,id'],
            'reporting_date'        => ['sometimes', 'date'],
            'vulnerability_name'    => ['sometimes', 'string', 'max:255'],
            'severity'              => ['sometimes', new Enum(Severity::class)],
            'repaired_status'         => ['sometimes', new Enum(RepairedStat::class)],
            'repaired_date'           => ['nullable', 'date'],
        ];
    }
}
