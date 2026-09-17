<!-- Sidebar for Desktop -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-300 transition-transform duration-300 ease-in-out md:translate-x-0 -translate-x-full flex flex-col justify-between border-r border-slate-800">
    <div>
        <!-- Logo & Brand Header -->
        <div class="h-16 flex items-center px-6 border-b border-slate-800 gap-3">
            <div class="h-9 w-9 bg-gradient-to-tr from-blue-600 to-indigo-500 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md shadow-blue-500/30">
                LE
            </div>
            <div>
                <h1 class="text-sm font-bold text-white tracking-wide leading-tight">Latis &amp; Tutor</h1>
                <p class="text-xs text-slate-400">Sistem Pendataan</p>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="p-4 space-y-1.5">
            <div class="px-3 py-2 text-xs font-semibold uppercase tracking-wider text-slate-400">
                Menu Utama
            </div>

            <!-- Siswa Menu -->
            <a href="{{ route('students.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('students.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span>Data Siswa</span>
            </a>

            <!-- Profile Menu -->
            <a href="{{ route('profile.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('profile.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span>Profile</span>
            </a>
        </nav>
    </div>

    <!-- User Mini Profile & Logout -->
    <div class="p-4 border-t border-slate-800 space-y-3">
        <a href="{{ route('profile.index') }}" class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-800/70 transition">
            @if(auth()->user()->image)
                <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-xl object-cover border border-slate-700">
            @else
                <div class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center font-bold text-blue-400">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
                </div>
            @endif
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-400 truncate">{{ auth()->user()->position ?? 'Kandidat' }}</p>
            </div>
        </a>

        <!-- Logout Form -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-3.5 py-2 rounded-xl text-sm font-medium text-rose-400 bg-rose-950/30 border border-rose-800/40 hover:bg-rose-900/40 hover:text-rose-300 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

<!-- Backdrop overlay for mobile -->
<div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-30 hidden md:hidden"></div>
