@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Edit Iklan</h1>

    <form action="{{ route('iklan.update', $iklan->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium">Nama Iklan</label>
            <input type="text" name="nama" value="{{ $iklan->nama }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Slug</label>
            <input type="text" name="slug" value="{{ $iklan->slug }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
    </form>
</div>
@endsection
