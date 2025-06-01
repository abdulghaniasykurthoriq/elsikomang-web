@extends('layouts.app2')

@section('title', 'Edit Entertaiment')

@section('content')


<div class="bg-indigo-600 px-8 pt-10 pb-28 flex justify-between items-center">
    <h1 class="text-xl text-white">Edit Entertaiment</h1>
    <a href="{{ route('entertaiment.index', ['jenis' => $jenis]) }}" class="btn bg-white text-gray-800">Kembali</a>
</div>

<div class="m-2 px-6 -mt-24">
    <div class="bg-white rounded-xl shadow-xl max-w-2xl mx-auto p-6">

        {{-- Tampilkan error jika ada --}}
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form edit entertaiments --}}
        <form action="{{ route('entertaiment.update', ['jenis' => $jenis, 'entertaiment' => $entertaiments->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Entertaiment</label>
                <input type="text" name="nama_entertaiment" class="input input-bordered w-full" value="{{ old('nama_entertaiment', $entertaiments->nama_entertaiment) }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="editor" class="w-full input input-bordered" rows="5">{{ old('deskripsi', $entertaiments->deskripsi) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Foto Entertaiment</label>
                @if ($entertaiments->foto_entertaiment)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $entertaiments->foto_entertaiment) }}" alt="Foto Lama" width="100">
                    </div>
                @endif
                <input type="file" name="foto_entertaiment" class="w-full input input-bordered" accept=".jpg,.jpeg,.png">
                <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah foto. Format: JPG, JPEG, PNG. Max 2MB.</p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn bg-indigo-600 text-white hover:bg-indigo-700">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
