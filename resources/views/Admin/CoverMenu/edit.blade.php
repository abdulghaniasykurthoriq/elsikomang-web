@extends('layouts.app')

 @section('title', 'Edit Data Operator')

 @section('content')

  <div class="bg-indigo-600 px-8 pt-10 pb-24 mb-8 flex justify-between items-center relative z-10" style="min-height: 160px;">
  <h1 class="text-xl text-white">Edit Data Operator</h1>
  </div>

  <div class="bg-white rounded-xl shadow-xl overflow-hidden p-4 mx-3 -mt-[90px] relative z-20">
  <div class="p-4 border-b border-gray-100">
  <h2 class="text-lg font-semibold text-gray-800">Edit Cover Menu</h2>
  </div>
  <form action="{{ route('cover-menu.update', $coverMenu->id) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PATCH') {{-- Atau @method('PUT') sesuai dengan route Anda --}}
  <div class="p-4">
  <div class="mb-4">
  <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
  <input type="text" name="nama" id="nama" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('nama') border-red-500 @enderror" value="{{ old('nama', $coverMenu->nama) }}" required>
  @error('nama')
  <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
  </div>
  <div class="mb-4">
  <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>

  @if ($coverMenu->foto)
  <div class="mb-2">
  <img id="preview-foto-lama" src="{{ asset('storage/' . $coverMenu->foto) }}" alt="Foto Cover Saat Ini"
  class="rounded-md w-40 h-40 object-cover border border-gray-300 shadow-sm">
  <p class="text-sm text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto.</p>
  </div>
  @else
  <img id="preview-foto-lama" src="#" alt="Preview Foto Lama" style="display: none;"
  class="rounded-md w-40 h-40 object-cover border border-gray-300 shadow-sm">
  @endif

  <div class="mt-2 flex rounded-md shadow-sm">
  <label for="foto" class="relative flex items-center justify-center px-4 py-2 bg-white border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 cursor-pointer">
  <span>Pilih File</span>
  <input type="file" name="foto" id="foto" accept="image/*" class="sr-only" onchange="previewImage(this); updateFileName(this)">
  </label>
  <input type="text" class="flex-1 block w-full min-w-0 rounded-none rounded-r-md border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" id="file-name" placeholder="{{ $coverMenu->foto ? basename($coverMenu->foto) : 'Tidak ada file yang dipilih' }}" readonly>
  </div>
  @error('foto')
  <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror

  {{-- Tempat untuk menampilkan preview foto baru --}}
  <img id="preview-foto-baru" src="#" alt="Preview Foto Baru" style="display: none;"
  class="mt-2 rounded-md w-40 h-40 object-cover border border-gray-300 shadow-sm">
  </div>

  <div class="flex items-center justify-end mt-4">
  <button type="submit" class="btn bg-blue-500 text-white hover:bg-blue-600">Simpan Perubahan</button>
  </div>
  </div>
  </form>
  </div>

 @endsection

 @push('scripts')
  <script>
  function previewImage(input) {
  const previewFotoBaru = document.getElementById('preview-foto-baru');
  const previewFotoLama = document.getElementById('preview-foto-lama');
  const file = input.files[0];

  if (file) {
  const reader = new FileReader();

  reader.onload = function(e) {
  previewFotoBaru.style.display = 'block';
  previewFotoBaru.src = e.target.result;
  // Sembunyikan preview foto lama saat ada foto baru dipilih
  previewFotoLama.style.display = 'none';
  }

  reader.readAsDataURL(file);
  } else {
  // Jika tidak ada file yang dipilih, sembunyikan preview baru dan tampilkan yang lama (jika ada)
  previewFotoBaru.style.display = 'none';
  if ("{{ $coverMenu->foto }}") {
  previewFotoLama.style.display = 'block';
  } else {
  previewFotoLama.style.display = 'none';
  }
  }
  }

  function updateFileName(input) {
  const fileNameDisplay = document.getElementById('file-name');
  if (input.files.length > 0) {
  fileNameDisplay.value = input.files[0].name;
  } else {
  fileNameDisplay.value = "{{ $coverMenu->foto ? basename($coverMenu->foto) : 'Tidak ada file yang dipilih' }}";
  }
  }

  // Panggil previewImage saat halaman dimuat jika sudah ada gambar
  document.addEventListener('DOMContentLoaded', function() {
  if ("{{ $coverMenu->foto }}") {
  const previewFotoLama = document.getElementById('preview-foto-lama');
  previewFotoLama.style.display = 'block';
  }
  });
  </script>
 @endpush