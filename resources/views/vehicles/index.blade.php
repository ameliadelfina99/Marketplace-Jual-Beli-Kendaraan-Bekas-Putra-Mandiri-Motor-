@extends('layouts.app')

@section('title', 'Katalog Kendaraan')

@section('content')

{{-- 1. Hero Section & Search Form --}}
<section class="py-16 md:py-24">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        @auth
            <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight">
                Selamat Datang Kembali, <span class="text-emerald-400">{{ Str::words(Auth::user()->name, 1, '') }}!</span>
            </h1>
        @else
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight">
                Temukan Kendaraan <br class="hidden sm:block">
                <span class="text-emerald-400">Impian Anda</span>
            </h1>
        @endauth
        <p class="mt-4 max-w-2xl mx-auto text-lg text-slate-400">
            Platform jual beli kendaraan bekas terpercaya dengan ribuan pilihan mobil dan motor berkualitas.
        </p>

        {{-- Form Pencarian --}}
        <div class="mt-10 max-w-4xl mx-auto">
            {{-- ... (Kode form pencarian Anda tetap sama) ... --}}
        </div>
    </div>
</section>

{{-- Daftar Kendaraan Section --}}
<section id="kendaraan" class="py-16">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- ======================================================= --}}
        {{-- PENAMBAHAN NOTIFIKASI SUKSES --}}
        {{-- ======================================================= --}}
        @if (session('success'))
            <div id="success-alert" class="relative bg-emerald-500/20 border border-emerald-500 text-emerald-300 px-4 py-3 rounded-lg mb-8" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button onclick="document.getElementById('success-alert').style.display='none'" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-emerald-400 hover:text-emerald-200 transition" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 2.651a1.2 1.2 0 1 1-1.697-1.697L8.304 10 5.652 7.349a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-2.651a1.2 1.2 0 1 1 1.697 1.697L11.697 10l2.651 2.651a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </button>
            </div>
        @endif
        
        @if(isset($vehicles) && $vehicles->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($vehicles as $vehicle)
                    <div class="bg-gray-800/50 border border-slate-800 rounded-xl shadow-lg flex flex-col group">
                        {{-- Gambar dan Tombol Favorit --}}
                        <div class="relative">
                            <a href="{{ route('vehicles.show', $vehicle) }}" class="block aspect-w-16 aspect-h-10 overflow-hidden rounded-t-xl">
                                @if($vehicle->image)
                                    <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full bg-slate-700 flex items-center justify-center">
                                        <span class="text-slate-500">No Image</span>
                                    </div>
                                @endif
                            </a>
                            {{-- Tombol Favorit --}}
                            <div class="absolute top-3 right-3">
                                @auth
                                    @php
                                        $isFavorited = Auth::user()->favorites()->where('vehicle_id', $vehicle->id)->exists();
                                    @endphp
                                    @if($isFavorited)
                                        <form action="{{ route('favorites.destroy') }}" method="POST">
                                            @csrf @method('DELETE')
                                            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                                            <button type="submit" class="w-10 h-10 flex items-center justify-center bg-red-500/80 text-white rounded-full transition" title="Hapus dari favorit">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" /></svg>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('favorites.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                                            <button type="submit" class="w-10 h-10 flex items-center justify-center bg-gray-800/50 backdrop-blur-sm text-white rounded-full hover:bg-red-500/80 transition" title="Tambah ke favorit">
                                               <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                        {{-- Konten Kartu --}}
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-white mb-1 group-hover:text-emerald-400 transition-colors">
                                <a href="{{ route('vehicles.show', $vehicle) }}">{{ $vehicle->title }}</a>
                            </h3>
                            <p class="text-xl font-semibold text-emerald-400 mb-3">
                                Rp {{ number_format($vehicle->price, 0, ',', '.') }}
                            </p>
                            <div class="mt-auto pt-4 border-t border-slate-800">
                                @auth
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                                        <button type="submit" class="w-full block text-center px-3 py-2 bg-emerald-500 text-gray-900 rounded-lg text-sm font-semibold hover:bg-emerald-600 transition-colors">
                                            + Keranjang
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="w-full block text-center px-3 py-2 bg-slate-700 text-white rounded-lg text-sm font-semibold hover:bg-slate-600 transition-colors">
                                        Masuk untuk Membeli
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-12">
                {{ $vehicles->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-gray-800 rounded-xl shadow-lg">
                <h3 class="mt-2 text-lg font-medium text-slate-100">Tidak ada kendaraan yang ditemukan.</h3>
                <p class="mt-1 text-sm text-slate-400">Silakan coba lagi nanti atau ubah filter pencarian Anda.</p>
            </div>
        @endif
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.getElementById('advanced-filter-toggle');
        if(toggleButton) {
            const filtersContainer = document.getElementById('advanced-filters');
            const filterText = document.getElementById('filter-text');

            toggleButton.addEventListener('click', () => {
                filtersContainer.classList.toggle('hidden');
                if (filtersContainer.classList.contains('hidden')) {
                    filterText.textContent = 'Filter';
                    toggleButton.classList.remove('bg-slate-700');
                } else {
                    filterText.textContent = 'Tutup';
                    toggleButton.classList.add('bg-slate-700');
                }
            });
        }
    });
</script>
@endpush
