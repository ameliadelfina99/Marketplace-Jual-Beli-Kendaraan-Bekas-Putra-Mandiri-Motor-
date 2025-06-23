@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="bg-gray-800 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-white text-center mb-8">Riwayat Pesanan Saya</h1>

        {{-- Menampilkan pesan sukses setelah checkout --}}
        @if (session('success'))
            <div class="bg-emerald-500/20 border border-emerald-500 text-emerald-300 px-4 py-3 rounded-lg relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-gray-900/50 border border-slate-800 shadow-lg rounded-lg p-6 space-y-6">
            @forelse ($orders as $order)
                <div class="bg-gray-800 p-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-slate-400">No. Invoice</p>
                            <p class="font-semibold text-white">{{ $order->invoice_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-400">Total</p>
                            <p class="font-semibold text-emerald-400">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-400">Status</p>
                            @if($order->status == 'pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-500/20 text-yellow-300">Pending</span>
                            @elseif($order->status == 'success')
                                 <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-500/20 text-emerald-300">Success</span>
                            @else
                                 <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-500/20 text-red-300">Failed</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-slate-400">Anda belum memiliki riwayat pesanan.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
