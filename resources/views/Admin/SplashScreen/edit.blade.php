@extends('layouts.app')

@section('title', 'Edit Splash Screen')

@section('content')
<div class="flex justify-center py-10">
    <div class="w-full max-w-md bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-bold mb-6 text-center">Edit Splash Screen</h2>
        <form action="{{ route('splashscreen.update', $splashscreen->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="image_content" class="block mb-2 font-medium text-gray-700">Gambar Konten</label>
                @if($splashscreen->image_content)
                    <img src="{{ asset('storage/' . $splashscreen->image_content) }}" alt="Konten" class="h-20 mb-2 rounded shadow border border-gray-200 object-contain bg-gray-50">
                @endif
                <input type="file" name="image_content" id="image_content" accept="image/*"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                @error('image_content')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="image_footer" class="block mb-2 font-medium text-gray-700">Gambar Footer</label>
                @if($splashscreen->image_footer)
                    <img src="{{ asset('storage/' . $splashscreen->image_footer) }}" alt="Footer" class="h-20 mb-2 rounded shadow border border-gray-200 object-contain bg-gray-50">
                @endif
                <input type="file" name="image_footer" id="image_footer" accept="image/*"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                @error('image_footer')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit"
                class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition">
                Update
            </button>
        </form>
    </div>
</div>
@endsection