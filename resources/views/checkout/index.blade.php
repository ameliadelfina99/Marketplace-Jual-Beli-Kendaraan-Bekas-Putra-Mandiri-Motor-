@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="bg-gray-800 py-16 sm:py-24">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-white">Checkout</h1>
            <p class="mt-2 text-lg text-slate-400">Selesaikan pesanan Anda dalam beberapa langkah mudah.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            {{-- Kolom Kiri: Ringkasan Pesanan --}}
            <div class="bg-gray-900/50 border border-slate-800 rounded-xl p-8">
                <h2 class="text-2xl font-bold text-white mb-6">Ringkasan Pesanan</h2>
                <div class="space-y-4">
                    @foreach($cartItems as $item)
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <img src="{{ asset('storage/' . $item->vehicle->image) }}" alt="{{ $item->vehicle->title }}" class="w-16 h-12 rounded-md object-cover">
                            <div class="ml-4">
                                <p class="font-semibold text-white">{{ $item->vehicle->title }}</p>
                                <p class="text-sm text-slate-400">1 unit</p>
                            </div>
                        </div>
                        <p class="text-slate-300">Rp {{ number_format($item->vehicle->price) }}</p>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6 pt-6 border-t border-slate-700 space-y-2">
                    <div class="flex justify-between text-slate-300">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($totalAmount) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-300">
                        <span>Biaya Layanan</span>
                        <span>Rp 0</span>
                    </div>
                    <div class="flex justify-between text-xl font-bold text-white">
                        <span>Total</span>
                        <span class="text-emerald-400">Rp {{ number_format($totalAmount) }}</span>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Form Pembayaran --}}
            <div class="bg-gray-900/50 border border-slate-800 rounded-xl p-8">
                <h2 class="text-2xl font-bold text-white mb-6">Detail Pembayaran</h2>
                {{-- Form ini yang akan memproses transaksi --}}
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" required class="w-full bg-gray-800 border-2 border-gray-700 rounded-lg py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Alamat Email</label>
                            <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" required class="w-full bg-gray-800 border-2 border-gray-700 rounded-lg py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-emerald-500 text-black font-bold py-3 px-6 rounded-lg text-lg hover:bg-emerald-600 transition shadow-lg shadow-emerald-500/20">
                                Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
