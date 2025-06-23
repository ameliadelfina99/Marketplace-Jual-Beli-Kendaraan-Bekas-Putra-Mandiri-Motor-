@extends('layouts.app')

@section('title', 'Daftar Akun Baru')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-gray-800 p-10 rounded-xl border border-slate-700">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
                Daftar Akun Baru
            </h2>
            <p class="mt-2 text-center text-sm text-slate-400">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-emerald-400 hover:text-emerald-500">
                    Masuk di sini
                </a>
            </p>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf
            {{-- Input Nama --}}
            <div>
                <label for="name" class="sr-only">Nama Lengkap</label>
                <input id="name" name="name" type="text" autocomplete="name" required class="w-full bg-slate-700 border border-slate-600 rounded-lg py-3 px-4 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Nama Lengkap">
            </div>
            {{-- Input Email --}}
            <div>
                <label for="email" class="sr-only">Alamat Email</label>
                <input id="email" name="email" type="email" autocomplete="email" required class="w-full bg-slate-700 border border-slate-600 rounded-lg py-3 px-4 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Alamat Email">
            </div>
            {{-- Input Password --}}
            <div>
                <label for="password" class="sr-only">Password</label>
                <input id="password" name="password" type="password" autocomplete="new-password" required class="w-full bg-slate-700 border border-slate-600 rounded-lg py-3 px-4 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Password">
            </div>
            {{-- Konfirmasi Password --}}
            <div>
                <label for="password_confirmation" class="sr-only">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="w-full bg-slate-700 border border-slate-600 rounded-lg py-3 px-4 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Konfirmasi Password">
            </div>
            
            <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-gray-900 bg-emerald-500 hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                Daftar
            </button>
        </form>
    </div>
</div>
@endsection