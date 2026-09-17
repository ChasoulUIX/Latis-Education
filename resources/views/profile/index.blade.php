@extends('layouts.app')

@section('title', 'Profil Kandidat')
@section('header-title', 'Profil Kandidat')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-blue-700 via-indigo-700 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-blue-500/10 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 text-center sm:text-left relative z-10">
            <!-- Candidate Avatar -->
            <div class="relative group flex-shrink-0">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-white/10 backdrop-blur border-2 border-white/30 overflow-hidden shadow-xl flex items-center justify-center">
                    @if($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-3xl font-black text-white">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Candidate Details -->
            <div class="flex-1 space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur text-xs font-semibold text-white">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Kandidat Aktif</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight">{{ $user->name }}</h2>
                <p class="text-blue-100 font-semibold text-base flex items-center justify-center sm:justify-start gap-2">
                    <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $user->position ?? 'Fullstack Developer' }}</span>
                </p>
                <p class="text-xs text-blue-200/80 font-mono">{{ $user->email }}</p>
            </div>
        </div>
    </div>

    <!-- Edit Profile Card -->
    <div class="bg-white p-6 sm:p-10 rounded-3xl shadow-sm border border-slate-200/80 space-y-8">
        <div>
            <h3 class="text-xl font-black text-slate-900 tracking-tight">Perbarui Informasi Profil</h3>
            <p class="text-sm text-slate-500 mt-1">Ubah detail data diri, posisi jabatan, atau foto profil Anda.</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Section 1: Candidate Basic Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Kandidat -->
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Nama Kandidat <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" required
                           value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-3 bg-slate-50/50 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium text-slate-800 transition @error('name') border-rose-500 @enderror">
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Posisi Kandidat -->
                <div>
                    <label for="position" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Posisi Kandidat
                    </label>
                    <input type="text" id="position" name="position"
                           value="{{ old('position', $user->position) }}"
                           placeholder="Contoh: Fullstack Web Developer"
                           class="w-full px-4 py-3 bg-slate-50/50 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium text-slate-800 transition @error('position') border-rose-500 @enderror">
                    @error('position')
                        <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email (Read Only) -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Alamat Email Akun
                    </label>
                    <input type="email" id="email" value="{{ $user->email }}" disabled
                           class="w-full px-4 py-3 border border-slate-200 bg-slate-100/70 text-slate-500 rounded-2xl text-sm font-mono cursor-not-allowed">
                    <p class="text-[11px] text-slate-400 mt-1.5">Email digunakan sebagai identitas login ke sistem.</p>
                </div>

                <!-- Foto Kandidat -->
                <div>
                    <label for="image" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Foto Profil Kandidat <span class="text-xs font-normal text-slate-400 normal-case">(JPG, PNG max 1MB)</span>
                    </label>
                    <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png"
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer transition">
                    @error('image')
                        <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Section 2: Password Change (Optional) -->
            <div class="pt-6 border-t border-slate-100 space-y-4">
                <div>
                    <h4 class="text-sm font-black text-slate-900">Ganti Password Akun (Opsional)</h4>
                    <p class="text-xs text-slate-500">Kosongkan kolom di bawah jika Anda tidak ingin mengubah password saat ini.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Password Baru</label>
                        <input type="password" id="password" name="password" autocomplete="new-password"
                               placeholder="Minimal 8 karakter"
                               class="w-full px-4 py-3 bg-slate-50/50 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition @error('password') border-rose-500 @enderror">
                        @error('password')
                            <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password"
                               placeholder="Ulangi password baru"
                               class="w-full px-4 py-3 bg-slate-50/50 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit"
                        class="px-7 py-3 rounded-2xl text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-600/25 transition-all transform active:scale-95">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
