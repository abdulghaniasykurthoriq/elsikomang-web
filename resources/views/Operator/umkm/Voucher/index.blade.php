@extends('layouts.app2')

@section('title', 'Data Voucher')

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
<div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-24 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">Data Voucher</h1>
    <a href="{{ route('voucher.create') }}"
        class="btn bg-white text-gray-800 border-gray-600 hover:bg-gray-100 hover:text-gray-800">
        + Tambah Voucher
    </a>
</div>

<div class="m-2 px-6 -mt-20 relative z-10">
    <div class="bg-white rounded-xl shadow-xl overflow-x-auto w-full p-6">
        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <table id="voucher-table" class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100 text-left text-gray-600 uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Kode</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Diskon</th>
                    <th class="px-4 py-2">Max Diskon</th>
                    <th class="px-4 py-2">Kuota</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vouchers as $index => $voucher)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $voucher->kode_voucher }}</td>
                    <td class="px-4 py-2">{{ $voucher->nama_voucher }}</td>
                    <td class="px-4 py-2">
                        {{ $voucher->tipe_diskon == 'persen' ? $voucher->nilai_diskon . '%' : 'Rp ' . number_format($voucher->nilai_diskon, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-2">
                        {{ $voucher->tipe_diskon == 'persen' && $voucher->maks_diskon ? 'Rp ' . number_format($voucher->maks_diskon, 0, ',', '.') : '-' }}
                    </td>
                    <td class="px-4 py-2">{{ $voucher->kuota }}</td>
                    <td class="px-4 py-2">
                        {{ \Carbon\Carbon::parse($voucher->tanggal_mulai)->format('d/m/Y') }} - 
                        {{ \Carbon\Carbon::parse($voucher->tanggal_berakhir)->format('d/m/Y') }}
                    </td>
                    <td class="px-4 py-2">
                        @if($voucher->is_aktif)
                            <span class="px-2 py-1 text-xs text-green-800 bg-green-100 rounded">Aktif</span>
                        @else
                            <span class="px-2 py-1 text-xs text-red-800 bg-red-100 rounded">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('voucher.edit', $voucher->id) }}"
                                class="inline-flex items-center justify-center w-8 h-8 text-white bg-yellow-500 hover:bg-yellow-600 rounded shadow">
                                <i data-feather="edit" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('voucher.destroy', $voucher->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus voucher ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center justify-center w-8 h-8 text-white bg-red-500 hover:bg-red-600 rounded shadow">
                                    <i data-feather="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#voucher-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            pageLength: 10,
            dom: '<"top"f<"spacer">l>rt<"bottom"ip><"clear">'
        });
    });
</script>
@endpush
