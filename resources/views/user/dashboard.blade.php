@extends('layouts.app')

@section('title', 'Keranjang Belanja Saya')

@section('content')

<div class="bg-gray-800 min-h-screen">
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-white">Keranjang Belanja Anda</h1>
            {{-- Menampilkan jumlah item --}}
            <span class="text-slate-400">{{ count($cartItems) }} Item</span>
        </div>

        {{-- Menampilkan pesan sukses setelah menambah/menghapus item --}}
        @if (session('success'))
            <div class="mb-6 bg-emerald-500/20 border border-emerald-500 text-emerald-300 px-4 py-3 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-gray-900 border border-slate-800 shadow-lg rounded-lg">
            <div class="p-6 sm:p-8">
                @forelse ($cartItems as $item)
                    {{-- Tampilan untuk setiap item di keranjang --}}
                    <div class="flex items-center justify-between py-4 @if(!$loop->last) border-b border-gray-800 @endif">
                        <div class="flex items-center">
                            <a href="{{ route('vehicles.show', $item->vehicle) }}">
                                <img src="{{ $item->vehicle && $item->vehicle->image ? asset('storage/' . $item->vehicle->image) : 'https://placehold.co/600x400/1a202c/9ca3af?text=No+Image' }}" alt="{{ $item->vehicle->title ?? 'Gambar Kendaraan' }}" class="w-24 h-16 rounded-md object-cover">
                            </a>
                            <div class="ml-4">
                                <a href="{{ route('vehicles.show', $item->vehicle) }}" class="font-bold text-white hover:text-emerald-400">{{ $item->vehicle->title ?? 'Kendaraan Tidak Ditemukan' }}</a>
                                <p class="text-sm text-slate-400">Rp {{ number_format($item->vehicle->price ?? 0) }}</p>
                            </div>
                        </div>
                        {{-- Form untuk menghapus item --}}
                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-400 font-semibold" title="Hapus item">Hapus</button>
                        </form>
                    </div>
                @empty
                    {{-- Tampilan jika keranjang kosong --}}
                    <div class="text-center py-12">
                        <p class="text-slate-400">Keranjang belanja Anda masih kosong.</p>
                        <a href="{{ route('vehicles.index') }}" class="mt-4 inline-block bg-emerald-500 hover:bg-emerald-600 text-gray-900 font-bold py-2 px-4 rounded-lg text-sm">
                            Mulai Belanja
                        </a>
                    </div>
                @endforelse

                {{-- Bagian Total dan Checkout (hanya muncul jika ada item) --}}
                @if (count($cartItems) > 0)
                    <div class="mt-6 pt-6 border-t border-gray-800 text-right">
                        <p class="text-lg text-slate-300">Total: <span class="font-bold text-white">Rp {{ number_format($totalPrice ?? 0) }}</span></p>
                        <button class="mt-4 w-full sm:w-auto bg-lime-400 hover:bg-lime-500 text-black font-bold py-3 px-8 rounded-lg">
                            Lanjutkan ke Pembayaran
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
