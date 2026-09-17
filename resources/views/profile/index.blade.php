@extends('layouts.app')

@section('title', 'Profil Kandidat')
@section('header-title', 'Profil Kandidat')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 rounded-3xl p-6 sm:p-8 text-white shadow-lg shadow-blue-500/10">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 text-center sm:text-left">
            <!-- Candidate Avatar -->
            <div class="relative group">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-white/20 backdrop-blur border-2 border-white/50 overflow-hidden shadow-md flex items-center justify-center">
                    @if($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-3xl font-extrabold text-white">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Candidate Details -->
            <div class="flex-1 space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur text-xs font-semibold text-white">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>Kandidat Aktif</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight">{{ $user->name }}</h2>
                <p class="text-blue-100 font-medium text-base sm:text-lg flex items-center justify-center sm:justify-start gap-2">
                    <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $user->position ?? 'Fullstack Developer' }}</span>
                </p>
                <p class="text-xs text-blue-200/80">{{ $user->email }}</p>
            </div>
        </div>
    </div>

    <!-- Edit Profile Card -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-200 space-y-6">
        <div>
            <h3 class="text-lg font-bold text-slate-900 tracking-tight">Perbarui Informasi Profil</h3>
            <p class="text-sm text-slate-500">Ubah detail data diri, posisi jabatan, atau foto profil Anda.</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Kandidat -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Nama Kandidat <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" required
                           value="{{ old('name', $user->name) }}"
                           class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('name') border-rose-500 @enderror">
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Posisi Kandidat -->
                <div>
                    <label for="position" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Posisi Kandidat
                    </label>
                    <input type="text" id="position" name="position"
                           value="{{ old('position', $user->position) }}"
                           placeholder="Contoh: Fullstack Web Developer"
                           class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('position') border-rose-500 @enderror">
                    @error('position')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email (Read Only) -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Alamat Email
                    </label>
                    <input type="email" id="email" value="{{ $user->email }}" disabled
                           class="w-full px-3.5 py-2.5 border border-slate-200 bg-slate-50 text-slate-500 rounded-xl text-sm cursor-not-allowed">
                    <p class="text-xs text-slate-400 mt-1">Email digunakan untuk login ke sistem.</p>
                </div>

                <!-- Foto Kandidat -->
                <div>
                    <label for="image" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Foto Profil Kandidat <span class="text-xs font-normal text-slate-500">(JPG, PNG max 1MB)</span>
                    </label>
                    <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png"
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    @error('image')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Password Change Section (Optional) -->
            <div class="pt-6 border-t border-slate-100 space-y-4">
                <div>
                    <h4 class="text-sm font-bold text-slate-800">Ganti Password (Opsional)</h4>
                    <p class="text-xs text-slate-500">Kosongkan kolom di bawah jika tidak ingin mengubah password akun Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Password Baru</label>
                        <input type="password" id="password" name="password" autocomplete="new-password"
                               placeholder="Minimal 8 karakter"
                               class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('password') border-rose-500 @enderror">
                        @error('password')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password"
                               placeholder="Ulangi password baru"
                               class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="pt-4 border-t border-slate-200 flex justify-end">
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 shadow-md shadow-blue-600/25 transition">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
