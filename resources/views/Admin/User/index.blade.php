@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-4">

        <h2 class="text-xl font-bold ">Daftar Cover Menu</h2>

    </div>

    <table id="cover-menu-table" class="display w-full table-auto table-bordered">
        <thead>
            <tr>
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Foto</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
<style>
    /* Fix tampilan select entries yang kepotong dan tidak sejajar */
    .dataTables_length label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
    }

    .dataTables_length select {
        padding: 0.25rem 2rem 0.25rem 0.5rem; /* Tambahkan padding kanan untuk ruang ikon */
        border-radius: 0.375rem;
        border: 1px solid #d1d5db;
        background-color: #fff;
        width: auto; /* Biarkan lebar menyesuaikan konten */
        appearance: none; /* Sembunyikan arrow bawaan browser */
        -webkit-appearance: none; /* Untuk Safari dan Chrome */
        -moz-appearance: none; /* Untuk Firefox */
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor'%3e%3cpath fill-rule='evenodd' d='M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z' clip-rule='evenodd' /%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.5rem center;
        background-size: 0.75rem;
        padding-right: 1.5rem; /* Sesuaikan padding agar teks tidak tertutup ikon */
    }

    /* Fix tabel responsive */
    table.dataTable {
        width: 100%;
        table-layout: auto;
    }

    /* Make select dropdown more readable */
    .dataTables_length select {
        width: auto; /* Pastikan width auto */
    }

    /* Styling untuk tombol pagination */
    .paginate_button.previous,
    .paginate_button.next {
        @apply inline-flex items-center py-2 px-4 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white;
    }

    .paginate_button.previous:hover,
    .paginate_button.next:hover {
        @apply bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-white;
    }

    .paginate_button.previous.disabled,
    .paginate_button.next.disabled {
        @apply text-gray-300 bg-gray-100 cursor-not-allowed dark:bg-gray-800 dark:text-gray-500;
    }

    .paginate_button.previous.disabled:hover,
    .paginate_button.next.disabled:hover {
        @apply bg-gray-100 text-gray-300 dark:bg-gray-800 dark:text-gray-500;
    }

    .paginate_button.current {
        @apply z-10 bg-blue-500 border-blue-500 text-white hover:bg-blue-600 hover:border-blue-600 dark:bg-blue-600 dark:border-blue-600;
    }

    .paginate_button a {
        @apply inline-flex items-center py-2 px-4 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white;
        border-radius: 0.375rem; /* Tambahkan border radius jika diperlukan */
    }

    .paginate_button a:hover {
        @apply bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-white;
    }

    .paginate_button.active a {
        @apply z-10 bg-blue-500 border-blue-500 text-white hover:bg-blue-600 hover:border-blue-600 dark:bg-blue-600 dark:border-blue-600;
    }

    .paginate_button:first-child a {
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }

    .paginate_button:last-child a {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

<script>
$(document).ready(function () {
    var dataTable = $('#cover-menu-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.data') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'foto', name: 'foto', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        responsive: true
    });

    // Tambahkan placeholder pada input search setelah DataTables diinisialisasi
    $('#cover-menu-table_filter input[type="search"]').attr('placeholder', 'Cari...');
});
</script>
@endpush