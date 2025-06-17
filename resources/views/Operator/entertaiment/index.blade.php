@extends('layouts.app2')

@section('title', 'Data Entertainment')

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
        margin-top: 1rem;
    }
            /* Atur dropdown agar tidak rusak */
            .dataTables_length select {
            padding-right: 1rem;        /* beri ruang untuk arrow */
            background-position: right 0rem center; /* panah ke kanan */
            background-repeat: no-repeat;
            background-size: 1rem;
            appearance: auto;           /* penting untuk tampilan default */
        }
</style>
@endpush

@section('content')


<div class="bg-indigo-600 px-8 pt-10 pb-28 flex justify-between items-center">
    <h1 class="text-xl text-white">Data Entertainment</h1>
    <a href="{{ route('entertaiment.create') }}" class="btn bg-white text-gray-800"> + Tambah Entertainment</a>
</div>

<div class="m-2 px-6 -mt-24">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
        <div class="p-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Entertainment</h2>
        </div>

        <div class="overflow-x-auto">
            <table id="entertainment-table" class="table-auto w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Foto</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($entertaiments as $index => $entertaiments)
                        <tr>
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $entertaiments->nama_entertaiment }}</td>
                            <td class="px-6 py-4">{!! Str::limit(strip_tags($entertaiments->deskripsi), 100) !!}</td>
                            <td class="px-6 py-4">
                                @if($entertaiments->foto_entertaiment)
                                    <img src="{{ asset('storage/' . $entertaiments->foto_entertaiment) }}" alt="Foto" width="100">
                                @else
                                    <span class="text-gray-400 italic">Tidak ada foto</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('entertaiment.edit', ['entertaiment' => $entertaiments->id]) }}"
                                   class="btn btn-sm bg-yellow-500 text-white hover:bg-yellow-600">
                                    <i data-feather="edit" class="w-4 h-4"></i>
                                </a>

                                <form action="{{ route('entertaiment.destroy', [ 'entertaiment' => $entertaiments->id]) }}"
                                      method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm bg-red-500 text-white hover:bg-red-600">
                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data entertainment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#entertainment-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            pageLength: 10,
            dom: '<"top"f<"spacer">l>rt<"bottom"ip><"clear">'
        });
        feather.replace();
    });
</script>
@endpush
