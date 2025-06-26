@extends('layouts.app2')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="p-4 bg-white rounded shadow overflow-auto">
    <h1 class="text-xl font-semibold mb-4">Data Transaksi</h1>
    <table id="transaksi-table" class="min-w-full divide-y divide-gray-200 table-auto">
        <thead class="bg-gray-100">
            <tr>
                <th>No</th>
                <th>Order ID</th>
                <th>User</th>
                <th>Amount</th>
                <th>Total Ongkos</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg w-full max-w-md p-6">
        <h3 id="editModalTitle" class="text-lg font-semibold mb-4">Kirim Pesanan</h3>
        <input type="hidden" id="transaksiId">

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Kurir</label>
            <input type="text" id="kurirInput" readonly class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded p-2 text-gray-700">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Layanan</label>
            <input type="text" id="kurirServiceInput" readonly class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded p-2 text-gray-700">
        </div>
        <div class="mb-4">
            <label for="noResiInput" class="block text-sm font-medium text-gray-700">No Resi</label>
            <input type="text" id="noResiInput" class="mt-1 block w-full border border-blue-400 rounded p-2 focus:outline-none focus:ring focus:border-blue-500">
        </div>
        <div class="flex justify-end">
            <button onclick="closeEditModal()" class="px-4 py-2 bg-gray-400 text-white rounded mr-2">Batal</button>
            <button onclick="submitEdit()" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#transaksi-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("transaksi.data") }}',
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
});

// Modal functions
function openEditModal(id, status, noResi = '', kurir = '', kurirService = '') {
    $('#editModalTitle').text(`Kirim Pesanan ke`);
    $('#noResiInput').val(noResi);
    $('#transaksiId').val(id);
    $('#kurirInput').val(kurir.toUpperCase());
    $('#kurirServiceInput').val(kurirService.toUpperCase());

    $('#editModal').removeClass('hidden');
}

function closeEditModal() {
    $('#editModal').addClass('hidden');
}

function submitEdit() {
    const id = $('#transaksiId').val();
    const noResi = $('#noResiInput').val();

    $.ajax({
        url: `/transaksi/${id}/update-status`,
        type: 'PUT',
        data: {
            _token: '{{ csrf_token() }}',
            no_resi: noResi,
            status: 'shipping' // hanya akan dipakai kalau status sebelumnya success
        },
        success: function (res) {
            alert(res.message);
            $('#transaksi-table').DataTable().ajax.reload();
            closeEditModal();
        },
        error: function (err) {
            alert('Gagal update data');
            console.error(err);
        }
    });
}
</script>
@endpush
