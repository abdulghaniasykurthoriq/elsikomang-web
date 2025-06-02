@extends('layouts.app2')

@section('content')
<div class="p-6" x-data="iklanModal()">
    <h1 class="text-2xl font-bold mb-4">Daftar Iklan</h1>

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nama</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Slug</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($iklans as $iklan)
                    <tr>
                        <td class="px-4 py-2">{{ $iklan->nama }}</td>
                        <td class="px-4 py-2">{{ $iklan->slug }}</td>
                        <td class="px-4 py-2">
                            <button
                                class="text-blue-600 hover:underline"
                                @click="showDetail({{ $iklan->toJson() }})"
                            >Detail</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- MODAL -->
    <div
        x-show="open"
        x-cloak
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
        <div class="bg-white rounded-lg p-6 w-full max-w-lg relative">
            <button @click="open = false" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-xl">&times;</button>
            <h2 class="text-xl font-bold mb-4" x-text="detail.nama"></h2>

            <template x-if="detail.iklan_data && detail.iklan_data.length > 0">
                <div>
                    <template x-for="item in detail.iklan_data" :key="item.id">
                        <div class="border p-3 rounded mb-4 bg-gray-50">
                            <img :src="item.gambar" class="h-32 w-full object-cover rounded mb-2" />
                            <a :href="item.link" class="text-blue-600 underline" target="_blank">Link</a>
                            <p class="text-sm">Status: <span x-text="item.status"></span></p>
                            <p class="text-sm">Expired: <span x-text="item.expired_at"></span></p>
                        </div>
                    </template>
                </div>
            </template>

            <template x-if="!detail.iklan_data || detail.iklan_data.length === 0">
                <p class="text-gray-500">Tidak ada data iklan.</p>
            </template>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function iklanModal() {
    return {
        open: false,
        detail: {},
        showDetail(data) {
            this.detail = data;
            this.open = true;
        }
    }
}
</script>
@endpush
