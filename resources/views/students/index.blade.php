@extends('layouts.app')

@section('title', 'Data Siswa')
@section('header-title', 'Data Siswa')

@section('content')
<div class="space-y-6">
    <!-- Header Section with Actions -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h3 class="text-xl font-bold text-slate-900 tracking-tight">Daftar Data Siswa</h3>
            <p class="text-sm text-slate-500 mt-1">Kelola data siswa lembaga Latis Education dan Tutor Indonesia.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Export Excel Button -->
            <a id="btn-export-excel" href="{{ route('students.export') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 hover:bg-emerald-100 shadow-sm transition">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Ekspor Excel</span>
            </a>

            <!-- Add Student Button -->
            <a href="{{ route('students.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 shadow-md shadow-blue-600/25 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Siswa</span>
            </a>
        </div>
    </div>

    <!-- Filter Card & Data Table -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6">
        <!-- Filter Controls -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
            <div class="flex flex-wrap items-center gap-3">
                <label for="filter-institution" class="text-sm font-semibold text-slate-700">Filter Lembaga:</label>
                <select id="filter-institution" class="px-3.5 py-2 text-sm bg-white border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Semua Lembaga --</option>
                    @foreach ($institutions as $inst)
                        <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="text-xs text-slate-500">
                <span class="inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    Pencarian dibatasi pada kolom <strong>NIS</strong> &amp; <strong>Nama Siswa</strong>
                </span>
            </div>
        </div>

        <!-- Data Table -->
        <div class="overflow-x-auto">
            <table id="students-table" class="w-full text-left border-collapse stripe hover text-sm">
                <thead>
                    <tr class="bg-slate-100 text-slate-700 uppercase text-xs tracking-wider border-b border-slate-200">
                        <th class="py-3.5 px-4 font-bold w-12 text-center">No</th>
                        <th class="py-3.5 px-4 font-bold w-16 text-center">Foto</th>
                        <th class="py-3.5 px-4 font-bold">NIS</th>
                        <th class="py-3.5 px-4 font-bold">Nama Siswa</th>
                        <th class="py-3.5 px-4 font-bold">Email</th>
                        <th class="py-3.5 px-4 font-bold">Lembaga</th>
                        <th class="py-3.5 px-4 font-bold text-center w-36">Aksi</th>
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
                    // d.search.value is sent automatically by DataTables
                }
            },
            columns: [
                { data: 'no', name: 'no', orderable: false, searchable: false, className: 'text-center' },
                {
                    data: 'photo_url',
                    name: 'photo',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function (data) {
                        if (data) {
                            return `<img src="${data}" alt="Foto" class="w-10 h-10 rounded-xl object-cover border border-slate-200 mx-auto shadow-sm">`;
                        }
                        return `<div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 text-slate-400 flex items-center justify-center text-xs font-semibold mx-auto">-</div>`;
                    }
                },
                { data: 'nis', name: 'nis', className: 'font-mono font-medium text-slate-900' },
                { data: 'name', name: 'name', className: 'font-medium text-slate-900' },
                { data: 'email', name: 'email', className: 'text-slate-600' },
                {
                    data: 'institution_name',
                    name: 'institution_name',
                    render: function (data) {
                        const badgeColor = data.toLowerCase().includes('latis')
                            ? 'bg-blue-50 text-blue-700 border-blue-200'
                            : 'bg-indigo-50 text-indigo-700 border-indigo-200';
                        return `<span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border ${badgeColor}">${data}</span>`;
                    }
                },
                { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-center' }
            ],
            language: {
                search: "Cari (NIS / Nama):",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ siswa",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 siswa",
                infoFiltered: "(disaring dari _MAX_ total data)",
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
