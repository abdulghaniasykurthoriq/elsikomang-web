@extends('layouts.app2')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Iklan</h1>

    <form action="{{ route('iklandata.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-medium">Halaman Iklan</label>
            <input type="text" name="iklanheader" value="{{ $iklan->nama }}"  disabled class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            <input type="text" name="iklan_id" value="{{ $iklan->id }}"  hidden >
            <input type="text" name="iklan_slug" value="{{ $iklan->slug }}"  hidden >
        </div>

        <div class="border-t pt-4">
            <h2 class="text-lg font-semibold mb-2">Data Iklan</h2>

            <div>
                <label class="block text-sm font-medium">Gambar</label>
                <input type="file" name="gambar" class="mt-1 block w-full rounded border-gray-300 shadow-sm" multiple>
            </div>

            <div>
                <label class="block text-sm font-medium">Link</label>
                <input type="url" name="link" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium">Status</label>
                <select name="status" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Expired At</label>
                <input type="date" name="expired_at" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            </div>
        </div>

        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
    </form>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
