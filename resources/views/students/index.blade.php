@extends('layouts.app')

@section('title', 'Data Siswa')
@section('header-title', 'Data Siswa')

@push('styles')
<style>
    /* Remove default DataTables border lines */
    table.dataTable.no-footer {
        border-bottom: none !important;
    }
    table.dataTable thead th,
    table.dataTable thead td {
        border-bottom: 1px solid #f1f5f9 !important;
    }
    table.dataTable tbody tr {
        background-color: transparent !important;
        transition: background-color 0.15s ease;
    }
    table.dataTable.stripe tbody tr.odd,
    table.dataTable.display tbody tr.odd {
        background-color: #fafbfc !important;
    }
    table.dataTable.hover tbody tr:hover,
    table.dataTable.display tbody tr:hover {
        background-color: #f1f5f9 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 0.75rem !important;
        padding: 0.4rem 0.85rem !important;
        border: 1px solid #e2e8f0 !important;
        background: #ffffff !important;
        color: #475569 !important;
        font-size: 0.8125rem !important;
        font-weight: 600 !important;
        margin: 0 3px;
        transition: all 0.2s;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: linear-gradient(135deg, #2563eb, #4f46e5) !important;
        color: #ffffff !important;
        border-color: transparent !important;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #f8fafc !important;
        border-color: #cbd5e1 !important;
        color: #0f172a !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        opacity: 0.5;
        cursor: not-allowed;
        background: #ffffff !important;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Stat KPI Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Card Total -->
        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Semua Siswa</p>
                <h4 class="text-3xl font-black text-slate-900 mt-1.5 tracking-tight">{{ number_format($totalStudents ?? 0) }}</h4>
                <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Siswa terdaftar di sistem</span>
                </div>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold shadow-lg shadow-blue-500/20">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>

        <!-- Card Latis Education -->
        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Latis Education</p>
                <h4 class="text-3xl font-black text-blue-600 mt-1.5 tracking-tight">{{ number_format($latisCount ?? 0) }}</h4>
                <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-1">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <span>Lembaga Latis</span>
                </div>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center font-bold">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>

        <!-- Card Tutor Indonesia -->
        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Tutor Indonesia</p>
                <h4 class="text-3xl font-black text-indigo-600 mt-1.5 tracking-tight">{{ number_format($tutorCount ?? 0) }}</h4>
                <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-1">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    <span>Lembaga Tutor</span>
                </div>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center font-bold">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
        <!-- Top Toolbar Header -->
        <div class="p-6 sm:p-7 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 bg-gradient-to-b from-white to-slate-50/50">
            <div>
                <h3 class="text-xl font-black text-slate-900 tracking-tight">Daftar Data Siswa</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola data siswa, lakukan filter lembaga, pencarian, dan ekspor dokumen.</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- Export Excel Button -->
                <a id="btn-export-excel" href="{{ route('students.export') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 hover:bg-emerald-100 hover:border-emerald-300 shadow-sm transition-all transform active:scale-95">
                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Ekspor Excel</span>
                </a>

                <!-- Add Student Button -->
                <a href="{{ route('students.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-md shadow-blue-600/25 transition-all transform active:scale-95">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tambah Siswa</span>
                </a>
            </div>
        </div>

        <!-- Filter & Search Section -->
        <div class="p-6 sm:p-7 space-y-6">
            <!-- Modern Filter Control Bar -->
            <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-200/80 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        </div>
                        <label for="filter-institution" class="text-xs font-bold uppercase tracking-wider text-slate-700">Filter Lembaga:</label>
                    </div>

                    <div class="relative min-w-[220px]">
                        <select id="filter-institution" class="appearance-none w-full pl-4 pr-10 py-2.5 text-xs sm:text-sm font-semibold bg-white border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-800 shadow-sm transition">
                            <option value="">-- Semua Lembaga --</option>
                            @foreach ($institutions as $inst)
                                <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3.5 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white border border-slate-200/80 text-xs text-slate-500 shadow-sm">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    <span>Pencarian dibatasi pada kolom <strong class="text-slate-800">NIS</strong> &amp; <strong class="text-slate-800">Nama Siswa</strong></span>
                </div>
            </div>

            <!-- Data Table -->
            <div class="overflow-x-auto rounded-2xl border border-slate-200/80">
                <table id="students-table" class="w-full text-left border-collapse stripe hover text-sm">
                    <thead>
                        <tr class="bg-slate-100/80 text-slate-600 uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-200">
                            <th class="py-4 px-4 text-center w-12">No</th>
                            <th class="py-4 px-4 text-center w-16">Foto</th>
                            <th class="py-4 px-4 font-extrabold">NIS</th>
                            <th class="py-4 px-4 font-extrabold">Nama Siswa</th>
                            <th class="py-4 px-4 font-extrabold">Email</th>
                            <th class="py-4 px-4 font-extrabold">Lembaga</th>
                            <th class="py-4 px-4 text-center w-40 font-extrabold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800">
                        <!-- Loaded dynamically by DataTables AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        const table = $('#students-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            dom: '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4"<"flex items-center gap-2 text-xs font-semibold text-slate-600"l><"flex items-center gap-2"f>>rt<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-6 pt-4 border-t border-slate-100"<"text-xs text-slate-500 font-medium"i><"flex items-center"p>>',
            ajax: {
                url: "{{ route('students.data') }}",
                data: function (d) {
                    d.institution_id = $('#filter-institution').val();
                }
            },
            columns: [
                { data: 'no', name: 'no', orderable: false, searchable: false, className: 'text-center font-bold text-slate-400 text-xs' },
                {
                    data: 'photo_url',
                    name: 'photo',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function (data, type, row) {
                        if (data) {
                            return `<img src="${data}" alt="${row.name}" class="w-10 h-10 rounded-2xl object-cover border border-slate-200 mx-auto shadow-sm">`;
                        }
                        const initials = row.name ? row.name.substring(0, 2).toUpperCase() : 'ST';
                        return `<div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-slate-100 to-slate-200 border border-slate-300 text-slate-600 flex items-center justify-center text-xs font-extrabold mx-auto shadow-sm">${initials}</div>`;
                    }
                },
                { data: 'nis', name: 'nis', className: 'font-mono font-bold text-slate-900' },
                { data: 'name', name: 'name', className: 'font-bold text-slate-900' },
                { data: 'email', name: 'email', className: 'text-slate-600 font-medium' },
                {
                    data: 'institution_name',
                    name: 'institution_name',
                    render: function (data) {
                        const isLatis = data.toLowerCase().includes('latis');
                        const badgeStyle = isLatis
                            ? 'bg-blue-50 text-blue-700 border-blue-200/80 shadow-sm'
                            : 'bg-indigo-50 text-indigo-700 border-indigo-200/80 shadow-sm';
                        const dotColor = isLatis ? 'bg-blue-500' : 'bg-indigo-500';

                        return `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border ${badgeStyle}">
                            <span class="w-1.5 h-1.5 rounded-full ${dotColor}"></span>
                            <span>${data}</span>
                        </span>`;
                    }
                },
                { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-center' }
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari (NIS / Nama)...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ siswa",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 siswa",
                infoFiltered: "(disaring dari _MAX_ total siswa)",
                zeroRecords: "Tidak ditemukan data siswa yang sesuai",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            drawCallback: function () {
                updateExportUrl();
            }
        });

        // Filter institution change event
        $('#filter-institution').on('change', function () {
            table.draw();
            updateExportUrl();
        });

        // Sync Export button URL with current filter and search parameters
        function updateExportUrl() {
            const institutionId = $('#filter-institution').val();
            const searchKeyword = table.search();

            const exportBaseUrl = "{{ route('students.export') }}";
            const params = new URLSearchParams();

            if (institutionId) {
                params.append('institution_id', institutionId);
            }
            if (searchKeyword) {
                params.append('search', searchKeyword);
            }

            const queryString = params.toString();
            const targetUrl = queryString ? `${exportBaseUrl}?${queryString}` : exportBaseUrl;
            $('#btn-export-excel').attr('href', targetUrl);
        }

        // Custom search sync on input keyup
        $('#students-table_filter input').unbind().bind('keyup input', function (e) {
            table.search(this.value).draw();
            updateExportUrl();
        });
    });
</script>
@endpush
