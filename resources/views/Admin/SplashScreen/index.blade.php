@extends('layouts.app')

@section('title', 'Data Splash Screen')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded shadow p-6">
        <h2 class="text-2xl font-bold mb-6">Data Splash Screen</h2>

        <div class="w-full flex  flex-col lg:flex-row ">
            <div class="overflow-x-auto w-full max-w-[700px] ">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar Konten</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar Footer</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($splashscreens as $item)
                            <tr>
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    @if($item->image_content)
                                        <img src="{{ $item->image_content }}" alt="Konten" class="h-20 w-auto rounded shadow border border-gray-200 object-contain bg-gray-50">
                                    @else
                                        <span class="text-gray-400 italic">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->image_footer)
                                        <img src="{{ $item->image_footer }}" alt="Footer" class="h-20 w-auto rounded shadow border border-gray-200 object-contain bg-gray-50">
                                    @else
                                        <span class="text-gray-400 italic">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex gap-2 justify-center">
                                    <a href="{{ route('splashscreen.edit', $item->id) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-xs font-semibold transition" title="Edit">
                                        <i data-feather="edit" class="w-4 h-4"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">Belum ada data splash screen.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>




            <div class="flex-shrink-0 bg-red-200 " style="width: 200px;">
                <img src="{{ asset('assets/images/frame_samsung.png') }}" alt="Frame Samsung" class="w-full h-auto object-contain relative">
            </div>
        </div>
       
    </div>
</div>
@endsection
