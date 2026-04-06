<?php

namespace App\Http\Requests\Incident;

use App\Enums\IncidentType;
use App\Enums\Severity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreIncidentRequest extends FormRequest
{
    public function rules(): array
    {
        $isLaporan = $this->input('type') === 'laporan_masyarakat' || auth()->user()->isUser();

        return [
            'application_id'        => ['required', 'exists:applications,id'],
            'type'                  => ['required', Rule::in(array_column(IncidentType::cases(), 'value'))],
            'reporter_name'         => [$isLaporan ? 'required' : 'nullable', 'string', 'max:255'],
            'pic_id'                => ['nullable', 'exists:users,id'],
            'reporting_date'        => ['required', 'date'],
            'vulnerability_name'    => ['required', 'string', 'max:255'],
            'severity'              => ['required', new Enum(Severity::class)],
            'evidences'             => 'nullable|array',
            'evidences.*'           => 'image|mimes:jpg,jpeg,png|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required'                 => 'Jenis insiden wajib dipilih.',
            'application_id.required'       => 'Aplikasi wajib dipilih.',
            'vulnerability_name.required'   => 'Nama kerentanan wajib diisi.',
            'reporter_name.required'        => 'Nama pelapor wajib diisi untuk laporan masyarakat.',
            'severity.required'             => 'Severity wajib dipilih.',
            'reporting_date.required'       => 'Tanggal pelaporan wajib diisi.',
            'evidences.*.image'             => 'File bukti harus berupa gambar.',
            'evidences.*.mimes'             => 'Format bukti harus JPG, PNG atau WEBP.',
            'evidences.*.max'               => 'Ukuran foto maksimal 5MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (auth()->user()->isUser()) {
            $this->merge([
                'type' => IncidentType::LaporanMasyarakat->value,
            ]);
        }
    }
}
