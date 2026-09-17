@extends('layouts.app')

@section('title', 'Edit Data Siswa')
@section('header-title', 'Edit Data Siswa')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header with Back Button -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Edit Data Siswa</h3>
            <p class="text-sm text-slate-500 mt-1">Perbarui informasi data siswa di bawah ini.</p>
        </div>
        <a href="{{ route('students.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl text-sm font-semibold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white p-6 sm:p-10 rounded-3xl shadow-sm border border-slate-200/80">
        <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Section 1: Institution & NIS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Institution Dropdown from DB -->
                <div>
                    <label for="institution_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Lembaga Siswa <span class="text-rose-500">*</span>
                    </label>
                    <select id="institution_id" name="institution_id" required
                            class="w-full px-4 py-3 bg-slate-50/50 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium text-slate-800 transition @error('institution_id') border-rose-500 @enderror">
                        <option value="">-- Pilih Lembaga --</option>
                        @foreach ($institutions as $institution)
                            <option value="{{ $institution->id }}" {{ old('institution_id', $student->institution_id) == $institution->id ? 'selected' : '' }}>
                                {{ $institution->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('institution_id')
                        <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIS (Required, Unique, Numeric) -->
                <div>
                    <label for="nis" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        NIS (Nomor Induk Siswa) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="nis" name="nis" inputmode="numeric" pattern="[0-9]*" required
                           value="{{ old('nis', $student->nis) }}"
                           placeholder="Contoh: 2026001 (Hanya Angka)"
                           class="w-full px-4 py-3 bg-slate-50/50 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-mono text-slate-800 transition @error('nis') border-rose-500 @enderror">
                    <p class="text-[11px] text-slate-400 mt-1.5">NIS harus berupa angka dan unik.</p>
                    @error('nis')
                        <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Section 2: Name & Email -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Siswa -->
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Nama Lengkap Siswa <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" required
                           value="{{ old('name', $student->name) }}"
                           placeholder="Masukkan nama lengkap siswa"
                           class="w-full px-4 py-3 bg-slate-50/50 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm text-slate-800 transition @error('name') border-rose-500 @enderror">
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Siswa -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Email Siswa <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" required
                           value="{{ old('email', $student->email) }}"
                           placeholder="siswa@example.com"
                           class="w-full px-4 py-3 bg-slate-50/50 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm text-slate-800 transition @error('email') border-rose-500 @enderror">
                    @error('email')
                        <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Section 3: Photo Upload with Preview -->
            <div class="pt-2 border-t border-slate-100">
                <label for="photo" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">
                    Foto Siswa <span class="text-xs font-normal text-slate-400 normal-case">(Kosongkan jika tidak ingin mengubah / Format JPG &amp; PNG)</span>
                </label>

                <div class="p-5 rounded-2xl bg-slate-50 border border-dashed border-slate-300 flex flex-col sm:flex-row items-center gap-5">
                    <div id="photo-preview-container" class="w-24 h-24 rounded-2xl bg-white border-2 border-slate-200 shadow-sm flex items-center justify-center overflow-hidden flex-shrink-0">
                        @if($student->photo)
                            <img id="photo-preview" src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->name }}" class="w-full h-full object-cover">
                            <svg id="photo-placeholder" class="w-10 h-10 text-slate-300 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        @else
                            <img id="photo-preview" src="" alt="Preview Foto" class="w-full h-full object-cover hidden">
                            <svg id="photo-placeholder" class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        @endif
                    </div>

                    <div class="flex-1 space-y-2 text-center sm:text-left">
                        <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png"
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer transition">
                        <p id="file-size-feedback" class="text-xs text-slate-500">
                            Sistem secara otomatis akan mengompres foto hingga berukuran &le; 100KB.
                        </p>
                    </div>
                </div>
                @error('photo')
                    <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('students.index') }}"
                   class="px-6 py-3 rounded-2xl text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-3 rounded-2xl text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-600/25 transition-all transform active:scale-95">
                    Perbarui Data Siswa
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
                const sizeKb = (file.size / 1024).toFixed(1);
                if (file.size > 102400) {
                    sizeFeedback.innerHTML = `<span class="text-blue-600 font-semibold">Ukuran file asli: ${sizeKb} KB (Akan otomatis dikompres ke &le; 100KB oleh sistem)</span>`;
                } else {
                    sizeFeedback.innerHTML = `<span class="text-emerald-600 font-semibold">Ukuran file optimal: ${sizeKb} KB</span>`;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    photoPreview.src = e.target.result;
                    photoPreview.classList.remove('hidden');
                    if (photoPlaceholder) {
                        photoPlaceholder.classList.add('hidden');
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
</script>
@endpush
