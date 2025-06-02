@extends('layouts.app2')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Edit Iklan</h1>

    <form action="{{ url('boxoffice/iklandata/' . $iklandata->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium">Halaman Iklan</label>
            <input type="text" name="iklanheader" value="{{ $iklandata->nama ?? '-' }}" disabled class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            <input type="hidden" name="iklan_id" value="{{ $iklandata->id }}">
        </div>

        <div class="border-t pt-4">
            <h2 class="text-lg font-semibold mb-2">Data Iklan</h2>

            <div>
                <label class="block text-sm font-medium">Gambar</label>
                <input type="file" name="gambar" class="mt-1 block w-full rounded border-gray-300 shadow-sm" multiple>
                @if($iklandata->gambar)
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $iklandata->gambar) }}" alt="Gambar Iklan" class="h-24 mt-1">
                    </div>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium">Link</label>
                <input type="url" name="link" value="{{ old('link', $iklandata->link) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium">Status</label>
                <select name="status" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                    <option value="active" {{ old('status', $iklandata->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $iklandata->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Expired At</label>
                <input type="date" name="expired_at" value="{{ old('expired_at', \Carbon\Carbon::parse($iklandata->expired_at)->format('Y-m-d')) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            </div>
        </div>

        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Perbarui</button>
    </form>
</div>

@if ($errors->any())
    <div class="alert alert-danger mt-6">
        <ul class="list-disc pl-5 text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
