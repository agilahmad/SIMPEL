<?php

namespace App\Http\Requests\Evidence;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvidenceRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return auth()->user()->isProgrammer();
    }

    public function rules(): array
    {
        return [
            'files'   => 'required|array',
            'files.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'files.required'   => 'Minimal upload 1 foto.',
            'files.*.image'    => 'File harus berupa gambar.',
            'files.*.mimes'    => 'Format harus JPG atau PNG.',
            'files.*.max'      => 'Ukuran foto maksimal 5MB.',
        ];
    }
}
