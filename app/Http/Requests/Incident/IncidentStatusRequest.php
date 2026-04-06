<?php

namespace App\Http\Requests\Incident;

use Illuminate\Foundation\Http\FormRequest;

class IncidentStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rejection_note' => ['required', 'string', 'max:500']
        ];
    }
}
