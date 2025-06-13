@extends('layouts.app')

@section('title', 'Tambah Operator')

@section('content')

<div class="bg-indigo-600 px-8 pt-10 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">Tambah Operator {{ $role }}</h1>
    <a href="{{ route('operator.index', ['role' => $role]) }}"
       class="btn bg-white text-gray-800 border-gray-600 hover:bg-gray-100">
        Kembali
    </a>
</div>

<div class="-mx-6 px-6 -mt-24 relative z-10">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl mx-auto">
        @if (session('success'))
            <div class="p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="p-3 bg-red-100 text-red-700 rounded">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('operator.store') }}" method="POST" class="p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" class="w-full input input-bordered" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" class="w-full input input-bordered" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" class="w-full input input-bordered" required>
                    <option selected value="{{ $role }}">{{ $role }}</option>
                </select>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="btn bg-indigo-600 text-white hover:bg-indigo-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
