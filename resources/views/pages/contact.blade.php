@extends('layouts.app')

@section('title', 'Hubungi Kami')

@section('content')
<div class="bg-gray-800 py-16 sm:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="max-w-2xl lg:max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white">Hubungi Kami</h1>
            <p class="mt-4 text-lg text-slate-400">
                Punya pertanyaan atau butuh bantuan? Tim kami siap membantu Anda.
            </p>
        </div>

        {{-- Konten Utama: Kontak Info & Form --}}
        <div class="mt-16 grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            
            {{-- Kolom Informasi Kontak --}}
            <div class="space-y-8">
                <div>
                    <h3 class="text-lg font-semibold text-emerald-400 flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Alamat Kantor
                    </h3>
                    <p class="mt-2 text-slate-300">
                        Jl. Raya Kendangsari No. 5, Surabaya, Jawa Timur, 60233
                    </p>
                    <a href="https://www.google.com/maps/search/?api=1&query=Jl.+Raya+Kendangsari+No.+5,+Surabaya" target="_blank" class="mt-2 inline-block text-sm text-emerald-400 hover:text-emerald-300 font-semibold">
                        Lihat di Google Maps &rarr;
                    </a>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-emerald-400 flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        Telepon
                    </h3>
                    <p class="mt-2 text-slate-300">
                        (031) 123-4567
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-emerald-400 flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Email
                    </h3>
                    <p class="mt-2 text-slate-300">
                        ameliadelfina99@gmail.com
                    </p>
                </div>
            </div>

            {{-- Kolom Form Kontak --}}
            <div class="bg-gray-900/50 p-8 rounded-xl border border-slate-800">
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="name" autocomplete="name" class="w-full bg-gray-800 border-2 border-gray-700 rounded-lg py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Alamat Email</label>
                        <input type="email" name="email" id="email" autocomplete="email" class="w-full bg-gray-800 border-2 border-gray-700 rounded-lg py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-slate-300 mb-2">Pesan Anda</label>
                        <textarea name="message" id="message" rows="4" class="w-full bg-gray-800 border-2 border-gray-700 rounded-lg py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"></textarea>
                    </div>
                    <div>
                        <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-bold rounded-lg text-black bg-emerald-500 hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-emerald-500 transition">
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
