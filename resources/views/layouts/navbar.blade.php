<header class="h-20 bg-white/80 backdrop-blur-xl border-b border-slate-200/80 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30 shadow-sm">
    <div class="flex items-center gap-4">
        <!-- Mobile Sidebar Toggle Button -->
        <button id="mobile-menu-toggle" type="button" class="md:hidden p-2.5 rounded-2xl bg-slate-100 text-slate-700 hover:bg-slate-200 hover:text-slate-900 focus:outline-none transition shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <div class="flex items-center gap-3">
            <div class="w-2.5 h-7 rounded-full bg-gradient-to-b from-blue-600 to-indigo-600 hidden sm:block"></div>
            <div>
                <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">
                    @yield('header-title', 'Dashboard')
                </h2>
                <p class="text-[11px] font-medium text-slate-400 hidden sm:block">
                    Sistem Pendataan Terpadu Latis &amp; Tutor
                </p>
            </div>
        </div>
    </div>

    <!-- Right Profile Pill & Status -->
    <div class="flex items-center gap-3.5">
        <!-- System Status Indicator -->
        <div class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200/80 text-emerald-700 text-xs font-bold shadow-sm">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Sistem Aktif</span>
        </div>

        <!-- Candidate Profile Button -->
        <a href="{{ route('profile.index') }}"
           class="flex items-center gap-3 p-1.5 sm:pr-4 rounded-2xl bg-slate-50 border border-slate-200/80 hover:bg-slate-100 hover:border-slate-300 transition-all shadow-sm group">
            @if(auth()->user()->image)
                <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="{{ auth()->user()->name }}" class="w-9 h-9 rounded-xl object-cover border border-slate-200 shadow-sm">
            @else
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold text-xs shadow-sm shadow-blue-500/20">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
                </div>
            @endif
            <div class="text-left hidden sm:block">
                <p class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition truncate max-w-[140px]">{{ auth()->user()->name }}</p>
                <p class="text-[10px] font-semibold text-slate-400 truncate max-w-[140px]">{{ auth()->user()->position ?? 'Kandidat' }}</p>
            </div>
            <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600 hidden sm:block transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</header>
