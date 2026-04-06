<?php

namespace App\Http\Requests\Evidence;

use Illuminate\Foundation\Http\FormRequest;

class RejectEvidenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rejection_note' => 'required|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'rejection_note.required' => 'Alasan penolakan wajib diisi.',
            'rejection_note.max'      => 'Alasan penolakan maksimal 500 karakter.',
        ];
    }
}
