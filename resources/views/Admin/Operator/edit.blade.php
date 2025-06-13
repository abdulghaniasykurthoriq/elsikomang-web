@extends('layouts.app')

@section('title', 'Edit Operator')

@section('content')

    <!-- Header Section -->
    <div class=" bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Edit Operator</h1>
        <a href="{{ route('operator.index', ['role' => strtolower($role)]) }}"
            class="btn bg-white text-gray-800 border-gray-600 hover:bg-gray-100 hover:text-gray-800 hover:border-gray-200 active:bg-gray-100 active:text-gray-800 active:border-gray-200 focus:outline-none focus:ring-4 focus:ring-indigo-300">
            Kembali
        </a>
    </div>

    <!-- Form Section -->
    <div class="-mx-6 px-6 -mt-24 relative z-10">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full max-w-2xl mx-auto">
            <form action="{{ route('operator.update', $user->id) }}" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full input input-bordered" required>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full input input-bordered" required>
                </div>

                <label class="block mb-1 text-sm font-medium text-gray-700">Role</label>
                <select  name="role" class="w-full input input-bordered" required>
                    @foreach ($jenisOperator as $item)
                        <option value="{{ $item->name }}"
                            {{ (old('role', str_replace('Operator ', '', $user->role)) == $item->name) ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
                

                <div class="pt-4 flex justify-end gap-2">
                    <button type="submit" class="btn bg-indigo-600 text-white hover:bg-indigo-700">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

@endsection
