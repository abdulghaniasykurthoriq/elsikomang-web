@extends('layouts.app2')
@section('title', 'Tambah Voucher')

@section('content')
<div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">Tambah Voucher</h1>
    <a href="{{ route('voucher.index') }}"
        class="btn bg-white text-gray-800 border-gray-600 hover:bg-gray-100 hover:text-gray-800">
        Kembali
    </a>
</div>

<div class="mx-2 px-6 -mt-24 relative z-10">
    <div class="bg-white rounded-xl p-6 shadow-xl w-full max-w-3xl mx-auto">

        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 rounded text-red-700">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('voucher.store') }}" method="POST" id="voucherForm">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kode Voucher</label>
                    <input type="text" name="kode_voucher" value="{{ old('kode_voucher') }}" class="form-input w-full" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Voucher</label>
                    <input type="text" name="nama_voucher" value="{{ old('nama_voucher') }}" class="form-input w-full" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipe Diskon</label>
                    <select name="tipe_diskon" class="form-input w-full" required>
                        <option value="persen" {{ old('tipe_diskon') == 'persen' ? 'selected' : '' }}>Persen</option>
                        <option value="nominal" {{ old('tipe_diskon') == 'nominal' ? 'selected' : '' }}>Nominal</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nilai Diskon</label>
                    <input type="number" name="nilai_diskon" value="{{ old('nilai_diskon') }}" step="0.01" class="form-input w-full" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Minimum Transaksi</label>
                    <input type="number" name="minimum_transaksi" value="{{ old('minimum_transaksi', 0) }}" step="0.01" class="form-input w-full">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Maksimal Diskon (jika persen)</label>
                    <input type="number" name="maks_diskon" value="{{ old('maks_diskon') }}" step="0.01" class="form-input w-full">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kuota</label>
                    <input type="number" name="kuota" value="{{ old('kuota', 0) }}" class="form-input w-full" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="form-input w-full" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Berakhir</label>
                    <input type="date" name="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}" class="form-input w-full" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="is_aktif" class="form-input w-full" required>
                        <option value="1" {{ old('is_aktif', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_aktif') == 0 ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="pt-6 flex justify-end">
                <button type="submit" id="submitBtn"
                    class="btn bg-indigo-600 text-white hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300 flex items-center justify-center">
                    <span id="btnText">Simpan Voucher</span>
                    <svg id="btnSpinner" class="hidden animate-spin ml-2 h-4 w-4 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v8H4z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Spinner Script --}}
<script>
    document.getElementById('voucherForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');

        btn.disabled = true;
        btnText.textContent = 'Menyimpan...';
        btnSpinner.classList.remove('hidden');
    });
</script>
@endsection
