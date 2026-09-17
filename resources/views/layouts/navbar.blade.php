<header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-20">
    <div class="flex items-center gap-3">
        <!-- Mobile Sidebar Toggle Button -->
        <button id="mobile-menu-toggle" type="button" class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <h2 class="text-lg font-bold text-slate-800">
            @yield('header-title', 'Dashboard')
        </h2>
    </div>

    <div class="flex items-center gap-3">
        <div class="hidden sm:flex items-center gap-2 text-xs text-slate-500 bg-slate-100 px-3 py-1.5 rounded-full">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Online</span>
        </div>
        <a href="{{ route('profile.index') }}" class="flex items-center gap-2 pl-2 border-l border-slate-200 text-sm font-semibold text-slate-700 hover:text-blue-600">
            <span>{{ auth()->user()->name }}</span>
        </a>
    </div>
</header>
