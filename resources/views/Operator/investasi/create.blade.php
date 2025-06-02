@extends('layouts.app2')

@section('title', 'Tambah Investasi')

@section('content')
<div class="bg-indigo-600 px-8 pt-10 pb-28 flex justify-between items-center">
    <h1 class="text-xl text-white">Tambah Data Investasi</h1>
    <a href="{{ route('investasi.index') }}" class="btn bg-white text-gray-800">Kembali</a>
</div>

<div class="m-2 px-6 -mt-24">
    <div class="bg-white rounded-xl shadow-xl max-w-2xl mx-auto p-6">
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="formTambahInvestasi" action="{{ route('investasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Investasi</label>
                <input type="text" name="nama_investasi" class="input input-bordered w-full" value="{{ old('nama_investasi') }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="editor" class="w-full input input-bordered" rows="5">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Foto Investasi</label>
                <input type="file" name="foto_investasi" class="w-full input input-bordered" accept=".jpg,.jpeg,.png" required>
                <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Max 2MB.</p>
            </div>

            <button type="submit" id="submitBtn" class="btn bg-indigo-600 text-white hover:bg-indigo-700 flex items-center justify-center">
                <span id="btnText">Simpan</span>
                <svg id="btnSpinner" class="hidden animate-spin ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
            </button>
        </form>
    </div>
</div>

{{-- CKEditor + Script Submit --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });

        const form = document.getElementById('formTambahInvestasi');
        const btn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');

        form.addEventListener('submit', function () {
            btn.disabled = true;
            btnText.textContent = 'Menyimpan...';
            btnSpinner.classList.remove('hidden');
        });
    });
</script>
@endsection
