<?php

namespace App\Http\Requests\Assesment;

use App\Enums\{RepairedStat, Severity};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateVaTestRequest extends FormRequest
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
            'application_id'                        => ['sometimes', 'exists:applications,id'],
            'pentest_date'                          => ['sometimes', 'date'],
            'repaired_status'                       => ['sometimes', new Enum(RepairedStat::class)],
            'repaired_date'                         => ['nullable', 'date'],
            'link'                                  => ['nullable', 'url'],
            'vulnerabilities'                       => ['nullable', 'array'],
            'vulnerabilities.*.vulnerability_name'  => ['required', 'string', 'max:255'],
            'vulnerabilities.*.severity'            => ['required', new Enum(Severity::class)],
            'vulnerabilities.*.repaired_status'     => ['required', new Enum(RepairedStat::class)],
        ];
    }
}
