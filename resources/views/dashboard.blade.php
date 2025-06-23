@extends('layouts.app')

@section('title', 'Daftar Kendaraan')

@section('content')

{{-- 1. Hero Section & Search Form --}}
<section class="py-20 md:py-32">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight">
            Temukan Kendaraan <br class="hidden sm:block">
            <span class="text-emerald-400">Impian Anda</span>
        </h1>
        <p class="mt-4 max-w-2xl mx-auto text-lg text-slate-400">
            Platform jual beli kendaraan bekas terpercaya dengan ribuan pilihan mobil dan motor berkualitas.
        </p>

        {{-- Search Form --}}
        <div class="mt-10 max-w-4xl mx-auto">
            <form method="GET" action="{{ route('vehicles.index') }}" class="bg-gray-800/50 backdrop-blur-sm border border-slate-700 p-4 rounded-xl shadow-lg flex flex-col gap-3">
                {{-- ... (Isi form pencarian Anda tetap sama) ... --}}
            </form>
        </div>
    </div>
</section>

{{-- 2. Stats Section --}}
<section class="py-12">
    {{-- ... (Isi seksi statistik Anda tetap sama) ... --}}
</section>

{{-- 3. Kendaraan Pilihan Section --}}
<section id="kendaraan" class="py-20">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- ... (Isi seksi kendaraan pilihan Anda tetap sama) ... --}}
    </div>
</section>

{{-- ======================================================= --}}
{{-- PERBAIKAN DI SINI: Bungkus CTA Section dengan @guest --}}
{{-- ======================================================= --}}
@guest
{{-- 4. CTA Section --}}
<section class="bg-emerald-500">
    <div class="max-w-screen-md mx-auto py-16 px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-extrabold text-gray-900">Ingin Menjual Kendaraan Anda?</h2>
        <p class="mt-4 text-lg text-gray-800">
            Bergabunglah dengan ribuan penjual yang telah mempercayai platform kami untuk menjual kendaraan mereka dengan mudah dan aman.
        </p>
        <div class="mt-8 flex justify-center gap-4">
            {{-- Ubah link agar mengarah ke halaman login --}}
            <a href="{{ route('login') }}" class="inline-block px-8 py-3 border border-transparent text-base font-semibold rounded-lg text-emerald-600 bg-gray-900 hover:bg-gray-800">Mulai Jual Sekarang</a>
            <a href="#" class="inline-block px-8 py-3 border border-gray-900 text-base font-semibold rounded-lg text-gray-900 hover:bg-gray-900 hover:text-white">Pelajari Lebih Lanjut</a>
        </div>
    </div>
</section>
@endguest
{{-- ======================================================= --}}
{{-- AKHIR PERBAIKAN --}}
{{-- ======================================================= --}}

@endsection

@push('scripts')
    {{-- ... (script Anda) ... --}}
@endpush
