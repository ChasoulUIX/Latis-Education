@extends('layouts.app')

@section('title', 'Data Siswa')
@section('header-title', 'Data Siswa')

@section('content')
<div class="space-y-6">
    <!-- Stat KPI Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Card Total -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Semua Siswa</p>
                <h4 class="text-2xl font-black text-slate-900 mt-1">{{ number_format($totalStudents ?? 0) }}</h4>
                <p class="text-[11px] font-medium text-slate-500 mt-0.5">Siswa terdaftar</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>

        <!-- Card Latis Education -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Latis Education</p>
                <h4 class="text-2xl font-black text-blue-600 mt-1">{{ number_format($latisCount ?? 0) }}</h4>
                <p class="text-[11px] font-medium text-slate-500 mt-0.5">Siswa aktif</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>

        <!-- Card Tutor Indonesia -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Tutor Indonesia</p>
                <h4 class="text-2xl font-black text-indigo-600 mt-1">{{ number_format($tutorCount ?? 0) }}</h4>
                <p class="text-[11px] font-medium text-slate-500 mt-0.5">Siswa aktif</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Header Section with Actions -->
    <div class="bg-white p-6 sm:p-7 rounded-3xl shadow-sm border border-slate-200/80 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h3 class="text-xl font-black text-slate-900 tracking-tight">Manajemen Data Siswa</h3>
            <p class="text-sm text-slate-500 mt-1">Data siswa terdaftar pada lembaga Latis Education &amp; Tutor Indonesia.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Export Excel Button -->
            <a id="btn-export-excel" href="{{ route('students.export') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl text-sm font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 hover:bg-emerald-100 hover:border-emerald-300 shadow-sm transition-all transform active:scale-95">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Ekspor Excel</span>
            </a>

            <!-- Add Student Button -->
            <a href="{{ route('students.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-md shadow-blue-600/25 transition-all transform active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Siswa</span>
            </a>
        </div>
    </div>

    <!-- Filter Card & Data Table -->
    <div class="bg-white p-6 sm:p-7 rounded-3xl shadow-sm border border-slate-200/80 space-y-6">
        <!-- Filter Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-2xl bg-slate-50/80 border border-slate-200">
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    </div>
                    <label for="filter-institution" class="text-xs font-bold uppercase tracking-wider text-slate-700">Filter Lembaga:</label>
                </div>
                <select id="filter-institution" class="px-4 py-2 text-sm bg-white border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-medium text-slate-700 shadow-sm">
                    <option value="">-- Semua Lembaga --</option>
                    @foreach ($institutions as $inst)
                        <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="text-xs text-slate-500 bg-white px-3.5 py-2 rounded-xl border border-slate-200 shadow-sm">
                <span class="inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    Pencarian dibatasi pada kolom <strong class="text-slate-800">NIS</strong> &amp; <strong class="text-slate-800">Nama Siswa</strong>
                </span>
            </div>
        </div>

        <!-- Data Table Container -->
        <div class="overflow-x-auto">
            <table id="students-table" class="w-full text-left border-collapse stripe hover text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-200">
                        <th class="py-4 px-4 text-center w-12">No</th>
                        <th class="py-4 px-4 text-center w-16">Foto</th>
                        <th class="py-4 px-4">NIS</th>
                        <th class="py-4 px-4">Nama Siswa</th>
                        <th class="py-4 px-4">Email</th>
                        <th class="py-4 px-4">Lembaga</th>
                        <th class="py-4 px-4 text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-800">
                    <!-- Loaded dynamically by DataTables AJAX -->
                </tbody>
            </table>
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
            ajax: {
                url: "{{ route('students.data') }}",
                data: function (d) {
                    d.institution_id = $('#filter-institution').val();
                }
            },
            columns: [
                { data: 'no', name: 'no', orderable: false, searchable: false, className: 'text-center font-semibold text-slate-500' },
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
                        return `<div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-slate-100 to-slate-200 border border-slate-300 text-slate-600 flex items-center justify-center text-xs font-bold mx-auto shadow-sm">${initials}</div>`;
                    }
                },
                { data: 'nis', name: 'nis', className: 'font-mono font-bold text-slate-900' },
                { data: 'name', name: 'name', className: 'font-semibold text-slate-900' },
                { data: 'email', name: 'email', className: 'text-slate-600' },
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
                search: "Cari (NIS / Nama):",
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
