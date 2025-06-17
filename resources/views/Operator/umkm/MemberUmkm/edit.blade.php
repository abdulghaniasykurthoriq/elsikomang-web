@extends('layouts.app2')

@section('title', 'Edit Member UMKM')

@section('content')
<!-- Header Section -->
<div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">Edit Data Member UMKM</h1>
    <a href="{{ route('member_umkm.index') }}"
        class="btn bg-white text-gray-800 border-gray-600 hover:bg-gray-100 hover:text-gray-800">
        Kembali
    </a>
</div>

<!-- Form Section -->
<div class="m-2 px-6 -mt-24 relative z-10">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full max-w-2xl mx-auto p-6">

        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @isset($member)
        <form action="{{ route('member_umkm.update', $member->id) }}" method="POST" enctype="multipart/form-data" id="memberForm" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Nama Toko</label>
                <input type="text" name="nama_toko" class="w-full input input-bordered" value="{{ old('nama_toko', $member->nama_toko) }}" required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" class="w-full input input-bordered" rows="3" required>{{ old('alamat', $member->alamat) }}</textarea>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">No HP</label>
                <input type="text" name="no_hp" class="w-full input input-bordered" value="{{ old('no_hp', $member->no_hp) }}" required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Foto</label>
                <input type="file" name="foto_toko" class="w-full input input-bordered" accept=".jpg,.jpeg,.png">
                @if ($member->foto_toko)
                    <p class="text-sm mt-2">Foto saat ini:</p>
                    <img src="{{ asset('storage/' . $member->foto_toko) }}" alt="Foto Toko" class="w-20 h-20 object-cover rounded">
                @endif
            </div>

            <!-- Dropdown Wilayah -->
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Provinsi</label>
                <select id="provinsi" name="provinsi_id" class="w-full input input-bordered" required>
                    <option value="">Pilih Provinsi</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                <select id="kota" name="kota_id" class="w-full input input-bordered" required>
                    <option value="">Pilih Kota/Kabupaten</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Kecamatan</label>
                <select id="kecamatan" name="kecamatan_id" class="w-full input input-bordered" required>
                    <option value="">Pilih Kecamatan</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Desa</label>
                <select name="desa_id" id="desa" class="w-full input input-bordered" required>
                    <option value="">Pilih Desa</option>
                </select>
            </div>

            <div class="pt-4 flex justify-end gap-2">
                <button type="submit" id="submitBtn"
                    class="btn bg-indigo-600 text-white hover:bg-indigo-700 flex items-center justify-center">
                    <span id="btnText">Update</span>
                    <svg id="btnSpinner" class="hidden animate-spin ml-2 h-4 w-4 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                </button>
            </div>
        </form>
        @else
            <p class="text-red-600 text-center font-semibold">Data member tidak ditemukan.</p>
        @endisset
    </div>
</div>

<script>
    const oldProvinsiId = "{{ old('provinsi_id', $member->desa->kecamatan->kota->provinsi->id ?? '') }}";
    const oldKotaId = "{{ old('kota_id', $member->desa->kecamatan->kota->id ?? '') }}";
    const oldKecamatanId = "{{ old('kecamatan_id', $member->desa->kecamatan->id ?? '') }}";
    const oldDesaId = "{{ old('desa_id', $member->desa->id ?? '') }}";

    document.addEventListener('DOMContentLoaded', () => {
        const provinsiSelect = document.getElementById('provinsi');
        const kotaSelect = document.getElementById('kota');
        const kecamatanSelect = document.getElementById('kecamatan');
        const desaSelect = document.getElementById('desa');

        // Load Provinsi
        fetch('{{ url("/api/provinsi") }}')
            .then(res => res.json())
            .then(res => {
                res.data.forEach(p => {
                    provinsiSelect.innerHTML += `<option value="${p.id}" ${p.id == oldProvinsiId ? 'selected' : ''}>${p.nama}</option>`;
                });
                provinsiSelect.dispatchEvent(new Event('change'));
            });

        provinsiSelect.addEventListener('change', function () {
            const idProv = this.value;
            kotaSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
            kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            desaSelect.innerHTML = '<option value="">Pilih Desa</option>';
            kotaSelect.disabled = true;
            kecamatanSelect.disabled = true;
            desaSelect.disabled = true;

            if (idProv) {
                fetch(`{{ url('/api/kota/') }}/${idProv}`)
                    .then(res => res.json())
                    .then(res => {
                        res.data.forEach(k => {
                            kotaSelect.innerHTML += `<option value="${k.id}" ${k.id == oldKotaId ? 'selected' : ''}>${k.nama}</option>`;
                        });
                        kotaSelect.disabled = false;
                        kotaSelect.dispatchEvent(new Event('change'));
                    });
            }
        });

        kotaSelect.addEventListener('change', function () {
            const idKota = this.value;
            kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            desaSelect.innerHTML = '<option value="">Pilih Desa</option>';
            kecamatanSelect.disabled = true;
            desaSelect.disabled = true;

            if (idKota) {
                fetch(`{{ url('/api/kecamatan/') }}/${idKota}`)
                    .then(res => res.json())
                    .then(res => {
                        res.data.forEach(kec => {
                            kecamatanSelect.innerHTML += `<option value="${kec.id}" ${kec.id == oldKecamatanId ? 'selected' : ''}>${kec.nama}</option>`;
                        });
                        kecamatanSelect.disabled = false;
                        kecamatanSelect.dispatchEvent(new Event('change'));
                    });
            }
        });

        kecamatanSelect.addEventListener('change', function () {
            const idKec = this.value;
            desaSelect.innerHTML = '<option value="">Pilih Desa</option>';
            desaSelect.disabled = true;

            if (idKec) {
                fetch(`{{ url('/api/desa/') }}/${idKec}`)
                    .then(res => res.json())
                    .then(res => {
                        res.data.forEach(d => {
                            desaSelect.innerHTML += `<option value="${d.id}" ${d.id == oldDesaId ? 'selected' : ''}>${d.nama}</option>`;
                        });
                        desaSelect.disabled = false;
                    });
            }
        });
    });

    document.getElementById('memberForm').addEventListener('submit', function () {
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('btnText').textContent = 'Menyimpan...';
        document.getElementById('btnSpinner').classList.remove('hidden');
    });
</script>
@endsection
