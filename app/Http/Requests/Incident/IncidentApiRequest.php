<?php

namespace App\Http\Requests\Incident;

use App\Enums\Severity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class IncidentApiRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // 'application_id'     => ['required'],
            'application_name'   => ['required', 'string', 'max:255'],
            'reporter_name'      => ['required', 'string', 'max:255'],
            'vulnerability_name' => ['required', 'string', 'max:255'],
            'severity'           => ['required', new Enum(Severity::class)],
            'reporting_date'     => ['required', 'date'],
            'evidence'           => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:5120'],
        ];
    }
}
