@extends('layouts.app')

@section('title', 'Edit Member UMKM')

@section('content')

    <!-- Header Section -->
    <div class="-mx-6 bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Edit Operator</h1>
        <a href="{{ route('member_umkm.index') }}"
            class="btn bg-white text-gray-800 border-gray-600 hover:bg-gray-100 hover:text-gray-800 hover:border-gray-200 active:bg-gray-100 active:text-gray-800 active:border-gray-200 focus:outline-none focus:ring-4 focus:ring-indigo-300">
            Kembali
        </a>
    </div>

    <!-- form -->
    <div class="-mx-6 px-6 -mt-24 relative z-10">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full max-w-2xl mx-auto">
            <form action="{{ route('member_umkm.update', $memberUmkm->id) }}" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
        <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">Nama Toko</label>
            <input type="text" name="nama_toko" value="{{ old('nama_toko', $memberUmkm->nama_toko) }}" class="input w-full" required>
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
                    {{-- <a href="{{ route('member_umkm.index') }}" class="btn btn-secondary">Batal</a> --}}
                    <button type="submit" class="btn bg-indigo-600 text-white hover:bg-indigo-700">Perbarui</button>
                </div>
    </form>
</div>

@endsection
