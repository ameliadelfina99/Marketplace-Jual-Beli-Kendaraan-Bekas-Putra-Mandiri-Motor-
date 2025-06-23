@extends('layouts.app')

@section('title', 'Tambah Kendaraan Baru')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-white">Tambah Kendaraan Baru</h1>
            <p class="mt-2 text-lg text-slate-400">Isi detail kendaraan untuk ditambahkan ke katalog.</p>
        </div>

        <div class="bg-gray-900/50 backdrop-blur-sm border border-gray-800 p-6 sm:p-8 rounded-xl shadow-lg">
            <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                {{-- Judul Iklan --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-300 mb-2">Judul Iklan</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                           class="w-full bg-gray-800 border-2 border-gray-700 rounded-lg py-3 px-4 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('title') border-red-500 @enderror"
                           placeholder="Contoh: Honda Civic Turbo 2020 Mulus">
                    @error('title') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- Kategori dan Merk --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-slate-300 mb-2">Kategori</label>
                        <select name="category_id" id="category_id" required class="w-full bg-gray-800 border-2 border-gray-700 rounded-lg py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('category_id') border-red-500 @enderror">
                            <option value="" disabled selected>Pilih Kategori</option>
                            @isset($categories)
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                        @error('category_id') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="brand_id" class="block text-sm font-medium text-slate-300 mb-2">Merk</label>
                        <select name="brand_id" id="brand_id" required class="w-full bg-gray-800 border-2 border-gray-700 rounded-lg py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('brand_id') border-red-500 @enderror">
                            <option value="" disabled selected>Pilih Merk</option>
                             @isset($brands)
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                        @error('brand_id') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                {{-- Model --}}
                <div>
                    <label for="model" class="block text-sm font-medium text-slate-300 mb-2">Model</label>
                    <input type="text" id="model" name="model" value="{{ old('model') }}" required
                           class="w-full bg-gray-800 border-2 border-gray-700 rounded-lg py-3 px-4 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('model') border-red-500 @enderror"
                           placeholder="Contoh: Civic, Vario 150">
                    @error('model') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>
                
                {{-- ======================================================= --}}
                {{-- PENAMBAHAN FIELD YANG HILANG --}}
                {{-- ======================================================= --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="year" class="block text-sm font-medium text-slate-300 mb-2">Tahun</label>
                        <input type="number" id="year" name="year" value="{{ old('year') }}" required
                               class="w-full bg-gray-800 border-2 border-gray-700 rounded-lg py-3 px-4 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('year') border-red-500 @enderror"
                               placeholder="Contoh: 2022" min="1900" max="{{ date('Y') + 1 }}">
                        @error('year') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium text-slate-300 mb-2">Harga</label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" required
                               class="w-full bg-gray-800 border-2 border-gray-700 rounded-lg py-3 px-4 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('price') border-red-500 @enderror"
                               placeholder="Contoh: 350000000">
                        @error('price') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-300 mb-2">Deskripsi</label>
                    <textarea id="description" name="description" rows="5" required
                              class="w-full bg-gray-800 border-2 border-gray-700 rounded-lg py-3 px-4 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('description') border-red-500 @enderror"
                              placeholder="Jelaskan kondisi kendaraan, fitur, histori servis, dll.">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>
                {{-- ======================================================= --}}
                {{-- AKHIR PENAMBAHAN --}}
                {{-- ======================================================= --}}

                {{-- Gambar Utama --}}
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Gambar Utama</label>
                    <label for="image" class="group flex items-center justify-center w-full h-32 px-6 py-4 border-2 border-dashed border-gray-700 rounded-lg cursor-pointer hover:border-emerald-500 transition">
                        <div class="text-center">
                            <svg class="mx-auto h-10 w-10 text-slate-500 group-hover:text-emerald-500 transition" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <p class="mt-2 text-sm text-slate-400 group-hover:text-emerald-500 transition">
                                <span class="font-semibold">Klik untuk upload</span> atau seret dan lepas
                            </p>
                            <p id="file-name" class="text-xs text-slate-500"></p>
                        </div>
                        <input id="image" name="image" type="file" class="sr-only">
                    </label>
                    @error('image') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- Status Publikasi --}}
                 <div>
                    <label for="is_published" class="block text-sm font-medium text-slate-300 mb-2">Status Publikasi</label>
                    <select name="is_published" id="is_published" required class="w-full bg-gray-800 border-2 border-gray-700 rounded-lg py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('is_published') border-red-500 @enderror">
                        <option value="1" {{ old('is_published', '1') == '1' ? 'selected' : '' }}>Publikasikan Langsung</option>
                        <option value="0" {{ old('is_published') == '0' ? 'selected' : '' }}>Simpan sebagai Draft</option>
                    </select>
                </div>
                
                {{-- Tombol Aksi --}}
                <div class="pt-8 flex justify-end items-center gap-4 border-t border-gray-800">
                    <a href="{{ route('admin.dashboard') }}"
                       class="inline-flex justify-center items-center px-5 py-2.5 border border-slate-700 rounded-lg text-sm font-semibold text-slate-300 bg-transparent hover:bg-slate-800 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex justify-center items-center gap-2 px-5 py-2.5 border border-transparent rounded-lg font-semibold text-black bg-emerald-500 hover:bg-emerald-600 transition">
                        Simpan Kendaraan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('image').onchange = function () {
        var fileName = this.files[0] ? this.files[0].name : "Tidak ada file yang dipilih";
        document.getElementById('file-name').textContent = fileName;
    };
</script>
@endpush
