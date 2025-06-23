@extends('layouts.app')

@section('title', $vehicle->title)

@push('styles')
{{-- Jika Anda menggunakan galeri foto JS, CSS-nya bisa ditaruh di sini --}}
@endpush

@section('content')
<div class="bg-white rounded-xl shadow-xl overflow-hidden">
    <div class="md:flex">
        {{-- Bagian Gambar Kendaraan --}}
        <div class="md:w-1/2 xl:w-3/5 md:flex-shrink-0">
            @if($vehicle->image)
                <img class="h-64 w-full object-cover md:h-full " src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->title }}">
            @else
                <div class="h-64 w-full bg-slate-200 flex items-center justify-center md:h-full">
                    <svg class="w-24 h-24 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            @endif
        </div>

        {{-- Bagian Detail Informasi Kendaraan --}}
        <div class="p-6 sm:p-8 md:w-1/2 xl:w-2/5 flex flex-col justify-between">
            <div>
                {{-- KATEGORI, MERK, DAN MODEL SEBAGAI SUB-HEADER --}}
                <div class="uppercase tracking-wider text-xs text-indigo-600 font-semibold mb-1">
                    {{ $vehicle->category->name ?? 'Tanpa Kategori' }}
                    @if($vehicle->brand)
                        <span class="text-slate-400 mx-1">/</span> {{ $vehicle->brand->name }}
                    @endif
                    @if($vehicle->model)
                        <span class="text-slate-400 mx-1">/</span> {{ $vehicle->model }}
                    @endif
                </div>

                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mb-3">{{ $vehicle->title }}</h1>
                <p class="text-3xl font-bold text-indigo-700 mb-6">
                    Rp {{ number_format($vehicle->price, 0, ',', '.') }}
                </p>

                <div class="mb-6 border-t border-slate-200 pt-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-3">Detail Kendaraan:</h3>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                        {{-- MENAMPILKAN KATEGORI --}}
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-slate-500">Kategori</dt>
                            <dd class="mt-1 text-slate-900">
                                {{ $vehicle->category->name ?? 'Tidak Diketahui' }}
                            </dd>
                        </div>
                        {{-- MENAMPILKAN MERK --}}
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-slate-500">Merk</dt>
                            <dd class="mt-1 text-slate-900">
                                {{ $vehicle->brand->name ?? 'Tidak Diketahui' }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-slate-500">Model</dt>
                            <dd class="mt-1 text-slate-900">{{ $vehicle->model }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-slate-500">Tahun</dt>
                            <dd class="mt-1 text-slate-900">{{ $vehicle->year }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-slate-500">Diposting oleh</dt>
                            <dd class="mt-1 text-slate-900">{{ $vehicle->user->name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="font-medium text-slate-500">Tanggal Posting</dt>
                            <dd class="mt-1 text-slate-900">{{ $vehicle->created_at->isoFormat('dddd, D MMMM YYYY') }} WIB</dd>
                        </div>
                    </dl>
                </div>

                <div class="mb-6 border-t border-slate-200 pt-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-3">Deskripsi:</h3>
                    <div class="prose prose-sm sm:prose-base max-w-none text-slate-700 leading-relaxed">
                        {!! nl2br(e($vehicle->description)) !!}
                    </div>
                </div>
            </div>

            {{-- ======================================================= --}}
            {{-- PERBAIKAN LOGIKA TOMBOL AKSI --}}
            {{-- ======================================================= --}}
            <div class="mt-auto pt-6 border-t border-slate-200">
                @auth
                    @if (Auth::user()->role == 'admin')
                        {{-- Tombol untuk ADMIN --}}
                        <div class="flex flex-col sm:flex-row sm:space-x-3 space-y-3 sm:space-y-0 mb-4">
                            <a href="{{ route('admin.vehicles.edit', $vehicle) }}"
                               class="w-full sm:w-auto flex-1 inline-flex justify-center items-center px-5 py-2.5 border border-transparent text-sm font-semibold rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150 ease-in-out">
                                <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                Edit Kendaraan
                            </a>
                            <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" class="w-full sm:w-auto flex-1" onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full inline-flex justify-center items-center px-5 py-2.5 border border-transparent text-sm font-semibold rounded-lg shadow-sm text-white bg-red-600 hover:bg-red-700 transition duration-150 ease-in-out">
                                    <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                    Hapus Kendaraan
                                </button>
                            </form>
                        </div>
                    @else
                        {{-- Tombol untuk User Pembeli --}}
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                            <button type="submit" class="w-full inline-flex justify-center items-center px-5 py-2.5 border border-transparent text-base font-bold rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition">
                                + Tambah ke Keranjang
                            </button>
                        </form>
                    @endif
                @else
                    {{-- Tombol untuk Tamu --}}
                    <a href="{{ route('login') }}" class="w-full inline-flex justify-center items-center px-5 py-2.5 border border-transparent text-base font-bold rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition">
                        Masuk untuk Membeli
                    </a>
                @endauth
                
                <a href="{{ route('vehicles.index') }}"
                   class="mt-4 w-full inline-flex justify-center items-center px-5 py-2.5 border border-slate-300 text-sm font-semibold rounded-lg shadow-sm text-slate-700 bg-white hover:bg-slate-50 transition duration-150 ease-in-out">
                    &laquo; Kembali ke Daftar Kendaraan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Jika Anda menggunakan galeri foto JS, scriptnya bisa ditaruh di sini --}}
@endpush
