<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'institution_id' => ['required', 'exists:institutions,id'],
            'nis' => ['required', 'numeric', 'unique:students,nis'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'institution_id.required' => 'Lembaga wajib dipilih.',
            'institution_id.exists' => 'Lembaga yang dipilih tidak valid.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.numeric' => 'NIS harus berupa angka.',
            'nis.unique' => 'NIS sudah terdaftar, silakan gunakan NIS lain.',
            'name.required' => 'Nama siswa wajib diisi.',
            'email.required' => 'Email siswa wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'photo.mimes' => 'Format foto yang diizinkan hanya JPG dan PNG.',
            'photo.max' => 'Ukuran file foto sebelum dikompres maksimal 10MB.',
        ];
    }
}
