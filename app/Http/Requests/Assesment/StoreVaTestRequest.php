<?php

namespace App\Http\Requests\Assesment;

use App\Enums\{RepairedStat, Severity};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreVaTestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'application_id'                        => ['required', 'exists:applications,id'],
            'pentest_date'                          => ['required', 'date'],
            'repaired_date'                         => ['nullable', 'date', 'after_or_equal:pentest_date'],
            'link'                                  => ['nullable', 'url'],
            'vulnerabilities'                       => ['nullable', 'array'],
            'vulnerabilities.*.vulnerability_name'  => ['required', 'string', 'max:255'],
            'vulnerabilities.*.severity'            => ['required', new Enum(Severity::class)],
            'vulnerabilities.*.repaired_status'     => ['required', new Enum(RepairedStat::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'application_id.required'                       => 'Aplikasi wajib dipilih.',
            'pentest_date.required'                         => 'Tanggal VA wajib diisi.',
            'repaired_date.after_or_equal'                  => 'Tanggal perbaikan tidak boleh sebelum tanggal VA.',
            'vulnerabilities.*.vulnerability_name.required' => 'Nama kerentanan wajib diisi.',
            'vulnerabilities.*.severity.required'           => 'Severity wajib dipilih.',
            'vulnerabilities.*.repaired_status.required'    => 'Status perbaikan wajib dipilih.',
        ];
    }
}
