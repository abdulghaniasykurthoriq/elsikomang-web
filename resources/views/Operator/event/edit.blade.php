@extends('layouts.app2')

@section('title', 'Edit Event Operator')

@section('content')

<div class="bg-indigo-600 px-8 pt-10 pb-28 flex justify-between items-center">
    <h1 class="text-xl text-white">Edit Data Event</h1>
    <a href="{{ route('event.index') }}" class="btn bg-white text-gray-800">Kembali</a>
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

        {{-- Form Edit --}}
        <form action="{{ route('event.update', [ 'event' => $event->id]) }}" method="POST" enctype="multipart/form-data" id="eventForm">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Event</label>
                <input type="text" name="nama_event" class="input input-bordered w-full" value="{{ old('nama_event', $event->nama_event) }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="editor" class="w-full input input-bordered" rows="5">{{ old('deskripsi', $event->deskripsi) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Foto Event</label>
                @if ($event->foto_event)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $event->foto_event) }}" alt="Foto Event" class="w-40 rounded">
                    </div>
                @endif
                <input type="file" name="foto_event" class="input input-bordered w-full">
                <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah foto. Max 2MB.</p>
            </div>

            <div class="flex justify-end">
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

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    document.getElementById('eventForm').addEventListener('submit', function () {
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
