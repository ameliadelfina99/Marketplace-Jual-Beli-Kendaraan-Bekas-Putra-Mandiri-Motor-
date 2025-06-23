@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="bg-gray-800 min-h-screen">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <h1 class="text-3xl font-extrabold text-white">Admin Dashboard</h1>
            <a href="{{ route('admin.vehicles.create') }}" class="mt-3 sm:mt-0 inline-block bg-emerald-500 hover:bg-emerald-600 text-gray-900 font-bold py-2 px-4 rounded-lg text-sm">
                + Tambah Kendaraan Baru
            </a>
        </div>

        {{-- Menampilkan pesan sukses setelah operasi --}}
        @if (session('success'))
            <div class="bg-emerald-500/20 border border-emerald-500 text-emerald-300 px-4 py-3 rounded-lg relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Tabel untuk menampilkan semua kendaraan --}}
        <div class="bg-gray-900 border border-slate-800 overflow-hidden shadow-lg rounded-lg">
            <div class="p-6 sm:p-8">
                <h3 class="text-xl font-bold text-white mb-6">Daftar Semua Kendaraan</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-800/50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Kendaraan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Harga</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Pemilik</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-900 divide-y divide-gray-800">
                            @forelse ($vehicles as $vehicle)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($vehicle->image)
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->title }}">
                                                </div>
                                            @endif
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-white">{{ $vehicle->title }}</div>
                                                <div class="text-xs text-slate-400">{{ $vehicle->brand->name ?? '' }} {{ $vehicle->model }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">Rp {{ number_format($vehicle->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($vehicle->is_published)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-500/20 text-emerald-300">Published</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-500/20 text-yellow-300">Draft</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">{{ $vehicle->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                        {{-- Tombol Show --}}
                                        <a href="{{ route('vehicles.show', $vehicle) }}" class="text-sky-400 hover:text-sky-300" target="_blank" title="Lihat di halaman publik">Lihat</a>
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="text-indigo-400 hover:text-indigo-300">Edit</a>
                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini? Ini tidak bisa dibatalkan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-400">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-400">
                                        Belum ada data kendaraan di dalam database.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
