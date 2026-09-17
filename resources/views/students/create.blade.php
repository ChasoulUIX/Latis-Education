@extends('layouts.app')

@section('title', 'Tambah Data Siswa')
@section('header-title', 'Tambah Data Siswa')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-slate-900 tracking-tight">Form Tambah Siswa</h3>
            <p class="text-sm text-slate-500 mt-1">Lengkapi data siswa di bawah ini dengan benar.</p>
        </div>
        <a href="{{ route('students.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
        <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="student-form">
            @csrf

            <!-- Institution Dropdown from DB -->
            <div>
                <label for="institution_id" class="block text-sm font-semibold text-slate-800 mb-1.5">
                    Lembaga Siswa <span class="text-rose-500">*</span>
                </label>
                <select id="institution_id" name="institution_id" required
                        class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('institution_id') border-rose-500 @enderror">
                    <option value="">-- Pilih Lembaga --</option>
                    @foreach ($institutions as $institution)
                        <option value="{{ $institution->id }}" {{ old('institution_id') == $institution->id ? 'selected' : '' }}>
                            {{ $institution->name }}
                        </option>
                    @endforeach
                </select>
                @error('institution_id')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- NIS (Required, Unik, Angka) -->
            <div>
                <label for="nis" class="block text-sm font-semibold text-slate-800 mb-1.5">
                    NIS (Nomor Induk Siswa) <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="nis" name="nis" inputmode="numeric" pattern="[0-9]*" required
                       value="{{ old('nis') }}"
                       placeholder="Contoh: 2026001 (Hanya Angka)"
                       class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-mono @error('nis') border-rose-500 @enderror">
                <p class="text-xs text-slate-400 mt-1">NIS harus berupa angka dan unik.</p>
                @error('nis')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Siswa (Required) -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-800 mb-1.5">
                    Nama Siswa <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="name" name="name" required
                       value="{{ old('name') }}"
                       placeholder="Nama lengkap siswa"
                       class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('name') border-rose-500 @enderror">
                @error('name')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email (Required, Valid Email) -->
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-800 mb-1.5">
                    Email Siswa <span class="text-rose-500">*</span>
                </label>
                <input type="email" id="email" name="email" required
                       value="{{ old('email') }}"
                       placeholder="siswa@example.com"
                       class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('email') border-rose-500 @enderror">
                @error('email')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto Siswa (JPG, PNG, Max 100KB) -->
            <div>
                <label for="photo" class="block text-sm font-semibold text-slate-800 mb-1.5">
                    Foto Siswa <span class="text-xs font-normal text-slate-500">(Opsional / Format JPG &amp; PNG, Maksimal 100KB)</span>
                </label>

                <div class="mt-2 flex items-center gap-4">
                    <div id="photo-preview-container" class="w-20 h-20 rounded-2xl bg-slate-100 border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden flex-shrink-0">
                        <img id="photo-preview" src="" alt="Preview Foto" class="w-full h-full object-cover hidden">
                        <svg id="photo-placeholder" class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png"
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        <p id="file-size-feedback" class="text-xs text-slate-500 mt-1">Ukuran file maksimal: 100KB. Format: .jpg, .png</p>
                    </div>
                </div>
                @error('photo')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
                <a href="{{ route('students.index') }}"
                   class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 shadow-md shadow-blue-600/25 transition">
                    Simpan Data Siswa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const photoInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photo-preview');
    const photoPlaceholder = document.getElementById('photo-placeholder');
    const sizeFeedback = document.getElementById('file-size-feedback');

    if (photoInput) {
        photoInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                // Client-side file size check (100KB = 102400 bytes)
                if (file.size > 102400) {
                    sizeFeedback.innerHTML = `<span class="text-rose-600 font-semibold">Peringatan: Ukuran file (${(file.size / 1024).toFixed(1)} KB) melebihi batas 100KB!</span>`;
                } else {
                    sizeFeedback.innerHTML = `<span class="text-emerald-600 font-semibold">Ukuran file valid: ${(file.size / 1024).toFixed(1)} KB</span>`;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function (e) {
                    photoPreview.src = e.target.result;
                    photoPreview.classList.remove('hidden');
                    photoPlaceholder.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    }
</script>
@endpush
