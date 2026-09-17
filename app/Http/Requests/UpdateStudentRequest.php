<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $studentId = $this->route('student');
        if (is_object($studentId)) {
            $studentId = $studentId->id;
        }

        return [
            'institution_id' => ['required', 'exists:institutions,id'],
            'nis' => [
                'required',
                'numeric',
                Rule::unique('students', 'nis')->ignore($studentId),
            ],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'institution_id.required' => 'Lembaga wajib dipilih.',
            'institution_id.exists' => 'Lembaga yang dipilih tidak valid.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.numeric' => 'NIS harus berupa angka.',
            'nis.unique' => 'NIS sudah digunakan oleh siswa lain.',
            'name.required' => 'Nama siswa wajib diisi.',
            'email.required' => 'Email siswa wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'photo.mimes' => 'Format foto yang diizinkan hanya JPG dan PNG.',
            'photo.max' => 'Ukuran foto maksimal adalah 100KB.',
        ];
    }
}
