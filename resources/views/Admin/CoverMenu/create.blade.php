@extends('layouts.app')

 @section('title', 'Data Operator')

 @section('content')

  <div class="bg-indigo-600 px-8 pt-10 pb-24 mb-8 flex justify-between items-center relative z-10" style="min-height: 160px;">
  <h1 class="text-xl text-white">Data Operator</h1>
  </div>

  <div class="bg-white rounded-xl shadow-xl overflow-hidden p-4 mx-3 -mt-[90px]  relative z-20">
  <div class="p-4 border-b border-gray-100">
  <h2 class="text-lg font-semibold text-gray-800">Tambah Cover Menu</h2>
  </div>
  <form action="{{ route('cover-menu.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="p-4">
  <div class="mb-4">
  <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
  <input type="text" name="nama" id="nama" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('nama') border-red-500 @enderror" value="{{ old('nama') }}" required>
  @error('nama')
  <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
  </div>
  <div class="mb-4">
  <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
  <div class="mt-1 flex rounded-md shadow-sm">
  <label for="foto" class="relative flex items-center justify-center px-4 py-2 bg-white border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 cursor-pointer">
  <span>Pilih File</span>
  <input type="file" name="foto" id="foto" accept="image/*" class="sr-only" required onchange="previewImage(this); updateFileName(this)">
  </label>
  <input type="text" class="flex-1 block w-full min-w-0 rounded-none rounded-r-md border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" id="file-name" placeholder="Tidak ada file yang dipilih" readonly>
  </div>
  @error('foto')
  <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
 </div>
  <div class="mb-4">
  <img id="imagePreview" src="#" alt="Preview Gambar" style="max-width:200px;max-height:200px;display:none;">
  </div>
  <div class="flex items-center justify-end mt-4">
  <button type="submit" class="btn bg-blue-500 text-white hover:bg-blue-600">Simpan</button>
  </div>
  </div>
  </form>
  </div>

 @endsection

 <script>
  function previewImage(input) {
  const preview = document.getElementById('imagePreview');
  const file = input.files[0];

  if (file) {
  const reader = new FileReader();

  reader.onload = function (e) {
  preview.src = e.target.result;
  preview.style.display = 'block';
  }

  reader.readAsDataURL(file);
  } else {
  preview.src = '#';
  preview.style.display = 'none';
  }
  }
 </script>