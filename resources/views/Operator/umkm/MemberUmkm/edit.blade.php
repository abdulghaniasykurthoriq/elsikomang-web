@extends('layouts.app2')

@section('title', 'Edit Member UMKM')

@section('content')

    <!-- Header Section -->
    <div class=" bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Edit Member UMKM</h1>
        <a href="{{ route('member_umkm.index', ['jenis' => request()->route('jenis')]) }}"
            class="btn bg-white text-gray-800 border-gray-600 hover:bg-gray-100 hover:text-gray-800 hover:border-gray-200 active:bg-gray-100 active:text-gray-800 active:border-gray-200 focus:outline-none focus:ring-4 focus:ring-indigo-300">
            Kembali
        </a>
    </div>

    <!-- form -->
    <div class="mx-2 px-6 -mt-24 relative z-10">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full max-w-2xl mx-auto">
            <form action="{{ route('member_umkm.update', ['jenis' => request()->route('jenis'), 'member_umkm' => $memberUmkm->id]) }}" method="POST" class="p-6 space-y-4"id= 'memberForm'>

                @csrf
                @method('PUT')
        <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">Nama Toko</label>
            <input type="text" name="nama_toko" value="{{ old('nama_toko', $memberUmkm->nama_toko) }}" class="input w-full" >
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">Alamat</label>
            <textarea name="alamat" class="input w-full">{{ old('alamat', $memberUmkm->alamat) }}</textarea>
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">No HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp', $memberUmkm->no_hp) }}" class="input w-full">
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">Foto Toko</label>
            <input type="file" name="foto_toko" class="input w-full">
            @if ($memberUmkm->foto_toko)
                <img src="{{ asset('storage/' . $memberUmkm->foto_toko) }}" alt="Foto_toko" class="w-24 mt-2">
            @endif
        </div>

        <div class="pt-4 flex justify-end gap-2">
            <button type="submit" id="submitBtn"
                class="btn bg-indigo-600 text-white hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300 flex items-center justify-center">
                <span id="btnText">Perbarui</span>
                <svg id="btnSpinner" class="hidden animate-spin ml-2 h-4 w-4 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
            </button>
        </div>
    </form>
</div>
</div>

<!-- Spinner Script -->
<script>
document.getElementById('memberForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');

    // Disable tombol dan tampilkan spinner
    btn.disabled = true;
    btnText.textContent = 'Menyimpan...';
    btnSpinner.classList.remove('hidden');
});
</script>

@endsection
