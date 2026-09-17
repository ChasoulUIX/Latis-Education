<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100 font-sans antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pendataan Siswa') - Latis Education &amp; Tutor Indonesia</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- jQuery & DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Modern DataTables Styling Override */
        .dataTables_wrapper {
            padding-top: 0.5rem;
        }
        .dataTables_wrapper .dataTables_length {
            margin-bottom: 1rem;
            color: #475569;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #cbd5e1;
            border-radius: 0.75rem;
            padding: 0.35rem 2rem 0.35rem 0.75rem;
            margin: 0 0.5rem;
            background-color: #ffffff;
            font-size: 0.875rem;
            outline: none;
        }
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
            color: #475569;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #cbd5e1;
            border-radius: 0.75rem;
            padding: 0.45rem 0.85rem;
            margin-left: 0.5rem;
            background-color: #ffffff;
            outline: none;
            transition: all 0.2s;
            font-size: 0.875rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }
        table.dataTable.no-footer {
            border-bottom: 1px solid #e2e8f0;
        }
        .dataTables_wrapper .dataTables_info {
            padding-top: 1rem;
            font-size: 0.8125rem;
            color: #64748b;
            font-weight: 500;
        }
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 1rem;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.75rem !important;
            padding: 0.35rem 0.85rem !important;
            border: 1px solid #e2e8f0 !important;
            background: #ffffff !important;
            color: #334155 !important;
            font-size: 0.8125rem !important;
            font-weight: 600 !important;
            margin: 0 2px;
            transition: all 0.15s;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #2563eb !important;
            color: #ffffff !important;
            border-color: #2563eb !important;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
        }
    </style>

    @stack('styles')
</head>
<body class="h-full antialiased text-slate-800 flex flex-col md:flex-row bg-slate-100">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content Area -->
    <div class="flex-1 md:pl-64 flex flex-col min-h-screen">
        @include('layouts.navbar')

        <main class="flex-1 p-4 sm:p-6 lg:p-8 w-full space-y-6">
            <!-- Global Flash Messages -->
            @if (session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between shadow-sm animate-fade-in">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 shadow-sm shadow-emerald-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-rose-500 text-white flex items-center justify-center flex-shrink-0 shadow-sm shadow-rose-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm shadow-sm">
                    <p class="font-bold mb-2">Terdapat beberapa kesalahan validasi:</p>
                    <ul class="list-disc list-inside space-y-1 text-rose-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="py-5 px-6 text-center text-xs text-slate-400 border-t border-slate-200/80 bg-white">
            &copy; {{ date('Y') }} Sistem Pendataan Siswa Latis Education &amp; Tutor Indonesia. Built with Laravel 13 &amp; Tailwind CSS.
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        // Mobile sidebar toggle script
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');

        if (toggleBtn && sidebar && backdrop) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
                backdrop.classList.toggle('hidden');
            });

            backdrop.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
