<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-950 font-sans antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pendataan Siswa Latis Education &amp; Tutor Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .ambient-glow {
            background: radial-gradient(circle at 50% 0%, rgba(59, 130, 246, 0.18), rgba(99, 102, 241, 0.08) 50%, transparent 80%);
        }
    </style>
</head>
<body class="h-full bg-slate-950 text-slate-100 flex items-center justify-center p-4 sm:p-6 lg:p-8 relative overflow-hidden">
    <!-- Ambient Lighting Effect -->
    <div class="absolute inset-0 ambient-glow pointer-events-none"></div>
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-12 rounded-3xl bg-slate-900/80 backdrop-blur-2xl border border-slate-800 shadow-2xl overflow-hidden relative z-10">
        <!-- Left Side: Brand & Visual Showcase -->
        <div class="lg:col-span-5 p-8 sm:p-12 bg-gradient-to-br from-blue-900/60 via-slate-900 to-indigo-950/60 flex flex-col justify-between border-b lg:border-b-0 lg:border-r border-slate-800/80 relative">
            <div class="space-y-6">
                <!-- Brand Badge -->
                <div class="inline-flex items-center gap-3 px-3.5 py-1.5 rounded-2xl bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-semibold tracking-wide">
                    <span class="w-2 h-2 rounded-full bg-blue-400 animate-ping"></span>
                    <span>Portal Manajemen Siswa</span>
                </div>

                <div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
                        Latis Education &amp; <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-300">Tutor Indonesia</span>
                    </h1>
                    <p class="mt-3 text-sm text-slate-400 leading-relaxed">
                        Sistem terintegrasi untuk pendataan, manajemen lembaga, visualisasi data interaktif, dan ekspor data siswa.
                    </p>
                </div>
            </div>

            <!-- Feature Pills -->
            <div class="mt-8 space-y-3">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-800/40 border border-slate-700/40 text-xs text-slate-300">
                    <div class="w-7 h-7 rounded-lg bg-blue-600/20 text-blue-400 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span>DataTables AJAX Realtime Filter &amp; Search NIS / Nama</span>
                </div>
                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-800/40 border border-slate-700/40 text-xs text-slate-300">
                    <div class="w-7 h-7 rounded-lg bg-emerald-600/20 text-emerald-400 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    </div>
                    <span>Ekspor Excel &amp; Auto Kompresi Foto Siswa (&le; 100KB)</span>
                </div>
            </div>

            <!-- Footer info -->
            <div class="mt-8 pt-6 border-t border-slate-800 text-xs text-slate-500">
                &copy; {{ date('Y') }} Latis Education. All rights reserved.
            </div>
        </div>

        <!-- Right Side: Clean Modern Login Form -->
        <div class="lg:col-span-7 p-8 sm:p-12 bg-slate-900/50 flex flex-col justify-center">
            <div class="max-w-md w-full mx-auto space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Selamat Datang</h2>
                    <p class="text-sm text-slate-400 mt-1">Masukkan kredensial akun Anda untuk masuk ke sistem.</p>
                </div>

                @if (session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="space-y-5" action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email', 'admin@latis.com') }}"
                                   class="w-full pl-11 pr-4 py-3 bg-slate-950/70 border border-slate-800 rounded-2xl text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-inner"
                                   placeholder="admin@latis.com">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                   value="password123"
                                   class="w-full pl-11 pr-4 py-3 bg-slate-950/70 border border-slate-800 rounded-2xl text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-inner"
                                   placeholder="••••••••">
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center gap-2 cursor-pointer text-slate-400 hover:text-slate-200">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-slate-950 border-slate-800 text-blue-600 focus:ring-blue-500">
                            <span>Ingat saya di perangkat ini</span>
                        </label>
                        <span class="text-blue-400 hover:underline cursor-pointer">Bantuan Login</span>
                    </div>

                    <!-- Demo Credentials Helper Badge -->
                    <div class="p-3 rounded-xl bg-blue-950/40 border border-blue-800/30 flex items-center justify-between text-xs text-blue-300">
                        <span>Akun Demo: <strong class="font-mono text-white">admin@latis.com</strong></span>
                        <span class="font-mono text-slate-300">password123</span>
                    </div>

                    <button type="submit"
                            class="w-full py-3.5 px-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-semibold text-sm shadow-lg shadow-blue-600/30 hover:shadow-blue-600/40 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all transform active:scale-[0.99]">
                        Masuk ke Dashboard
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
