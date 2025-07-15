@extends('layouts.app2')

@section('title', 'Daftar Transaksi')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    div.dataTables_wrapper .top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .dataTables_length select {
        padding-right: 1rem;
        background-position: right 0rem center;
        background-repeat: no-repeat;
        background-size: 1rem;
        appearance: auto;
    }
</style>
@endpush

@section('content')
<div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white font-semibold">Daftar Transaksi</h1>
</div>

<div class="mx-4 sm:mx-6 -mt-24 relative z-10">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Tabel Transaksi</h2>
        </div>

        <div class="overflow-x-auto p-4">
            <table id="transaksi-table" class="w-full text-sm text-left text-gray-700 border-collapse">
                <thead class="bg-gray-100 border-b border-gray-300">
                    <tr>
                        <th class="px-4 py-3 font-semibold">No</th>
                        <th class="px-4 py-3 font-semibold">Order ID</th>
                        <th class="px-4 py-3 font-semibold">User</th>
                        <th class="px-4 py-3 font-semibold">Amount</th>
                        <th class="px-4 py-3 font-semibold">Total Ongkos</th>
                        <th class="px-4 py-3 font-semibold">Metode</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3 font-semibold">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal Kirim -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg w-full max-w-md p-6 relative shadow-lg">
        <h3 id="editModalTitle" class="text-lg font-semibold mb-4">Kirim Pesanan</h3>
        <input type="hidden" id="transaksiId">

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Kurir</label>
            <input type="text" id="kurirInput" readonly class="mt-1 w-full bg-gray-100 border border-gray-300 rounded p-2 text-gray-700">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Layanan</label>
            <input type="text" id="kurirServiceInput" readonly class="mt-1 w-full bg-gray-100 border border-gray-300 rounded p-2 text-gray-700">
        </div>
        <div class="mb-4">
            <label for="noResiInput" class="block text-sm font-medium text-gray-700">No Resi</label>
            <input type="text" id="noResiInput" class="mt-1 w-full border border-blue-400 rounded p-2 focus:outline-none focus:ring focus:border-blue-500">
        </div>

        <div class="flex justify-end gap-2">
            <button onclick="closeEditModal()" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">Batal</button>
            <button id="submitBtn" onclick="submitEdit()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://unpkg.com/feather-icons"></script>

<script>
    $(document).ready(function () {
        $('#transaksi-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("transaksi.data") }}',
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            pageLength: 10,
            dom: '<"top"f<"spacer">l>rt<"bottom"ip><"clear">',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'order_id', name: 'order_id' },
                { data: 'user', name: 'user.name' },
                { data: 'amount', name: 'amount' },
                { data: 'total_ongkos', name: 'total_ongkos' },
                { data: 'payment_method', name: 'payment_method' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
        feather.replace();
    });

    function openEditModal(id, status, noResi = '', kurir = '', kurirService = '') {
        $('#editModalTitle').text(`Kirim Pesanan`);
        $('#transaksiId').val(id);
        $('#noResiInput').val(noResi);
        $('#kurirInput').val(kurir.toUpperCase());
        $('#kurirServiceInput').val(kurirService.toUpperCase());
        $('#editModal').removeClass('hidden');
    }

    function closeEditModal() {
        $('#editModal').addClass('hidden');
    }

    function submitEdit() {
        const id = $('#transaksiId').val();
        const noResi = $('#noResiInput').val().trim();

        if (!noResi) {
            alert("No Resi tidak boleh kosong!");
            return;
        }

        $('#submitBtn').prop('disabled', true).text('Menyimpan...');

        $.ajax({
            url: `/transaksi/${id}/update-status`,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                no_resi: noResi,
                status: 'shipping'
            },
            success: function (res) {
                alert(res.message || 'Berhasil memperbarui status.');
                $('#transaksi-table').DataTable().ajax.reload();
                closeEditModal();
            },
            error: function (err) {
                alert('Gagal memperbarui data!');
                console.error(err);
            },
            complete: function () {
                $('#submitBtn').prop('disabled', false).text('Simpan');
            }
        });
    }
</script>
@endpush
