<?php

namespace App\Http\Requests\Incident;

use Illuminate\Foundation\Http\FormRequest;

class SaveMasyarakatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'application_id' => ['required', 'exists:applications,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'application_id.required' => 'Aplikasi wajib dipilih.',
            'application_id.exists'   => 'Aplikasi tidak ditemukan.',
        ];
    }
}
