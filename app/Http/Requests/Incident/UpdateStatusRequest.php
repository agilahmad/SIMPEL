<?php

namespace App\Http\Requests\Incident;

use App\Enums\RepairedStat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        $incident = $this->route('incident');

        return $this->user()->isAdmin() ||
               ($this->user()->isProgrammer() && $incident->pic_id === $this->user()->id);
    }

    public function rules(): array
    {
        return [
            'repaired_status'  => ['nullable', new Enum(RepairedStat::class)],
            'pic_id'           => ['nullable', 'exists:users,id'],
            'link'              => ['nullable', 'url'],
            'repaired_date'    => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'repaired_status.Illuminate\Validation\Rules\Enum'  => 'Status perbaikan tidak valid.',
            'pic_id.exists'                                      => 'Programmer yang dipilih tidak valid.',
            'repaired_date.date'                                 => 'Format tanggal perbaikan tidak valid.',
        ];
    }
}
