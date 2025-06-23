@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="bg-gray-800">
    {{-- Hero Section --}}
    <section class="relative h-64 md:h-80 flex items-center justify-center text-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=2070&auto=format&fit=crop" 
                 alt="Tim Putra Mandiri Motor sedang berdiskusi" 
                 class="w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-800 to-transparent"></div>
        </div>
        <div class="relative z-10 px-4">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight">Tentang Putra Mandiri Motor</h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-slate-300">
                Memahami perjalanan di balik kepercayaan Anda.
            </p>
        </div>
    </section>

    {{-- Main Content Section --}}
    <section class="py-16 sm:py-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Misi Perusahaan --}}
            <div class="text-center">
                <h2 class="text-3xl font-bold text-emerald-400">Misi Kami</h2>
                <p class="mt-4 text-xl text-slate-300 leading-relaxed">
                    Menjadi platform marketplace kendaraan paling terpercaya di Indonesia dengan menyediakan proses jual beli yang transparan, aman, dan mudah bagi setiap pelanggan. Kami berkomitmen pada kualitas, integritas, dan kepuasan Anda.
                </p>
            </div>

            {{-- Nilai-Nilai Perusahaan --}}
            <div class="mt-20">
                <h3 class="text-2xl font-bold text-center text-white mb-10">Nilai yang Kami Pegang Teguh</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
                    {{-- Nilai 1: Integritas --}}
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-emerald-500/20 mb-4">
                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="text-lg font-semibold text-white">Integritas</h4>
                        <p class="mt-2 text-slate-400">Kejujuran dan transparansi adalah fondasi dari setiap transaksi.</p>
                    </div>
                    {{-- Nilai 2: Kualitas --}}
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-emerald-500/20 mb-4">
                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h4 class="text-lg font-semibold text-white">Kualitas</h4>
                        <p class="mt-2 text-slate-400">Setiap kendaraan melewati proses inspeksi ketat untuk menjamin kualitas terbaik.</p>
                    </div>
                    {{-- Nilai 3: Pelayanan --}}
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-emerald-500/20 mb-4">
                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2V4a2 2 0 012-2h8a2 2 0 012 2v4z"></path></svg>
                        </div>
                        <h4 class="text-lg font-semibold text-white">Pelayanan</h4>
                        <p class="mt-2 text-slate-400">Tim kami siap membantu Anda di setiap langkah proses jual beli.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
