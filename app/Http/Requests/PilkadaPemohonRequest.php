<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PilkadaPemohonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'jenis_pemilihan' => ['required', 'in:gubernur, walikota, bupati'],
            'id_provinsi' => ['required', 'exists:provinsi,id'],
            'id_daerah' => ['
            nullable',
            Rule::requiredIf($this->jenis_pemilihan != 'gubernur'),],
            'no_urut' => 'required|string',
            'pokok_permohonan' => 'nullable|string',
        ];
    }
}
