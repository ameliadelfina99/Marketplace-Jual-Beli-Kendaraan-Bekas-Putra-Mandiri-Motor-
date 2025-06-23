<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PMM') }} - @yield('title', 'Marketplace Kendaraan')</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-gray-900 font-inter text-slate-300 antialiased flex flex-col min-h-screen">

    <header class="sticky top-0 z-50 bg-gray-900/80 backdrop-blur-lg border-b border-slate-800">
        <nav class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                {{-- Logo --}}
                <div class="flex items-center space-x-3">
                    <a href="{{ Auth::check() && Auth::user()->role == 'admin' ? route('admin.dashboard') : route('home') }}" class="flex-shrink-0">
                        <svg class="w-10 h-10 text-emerald-500" viewBox="0 0 24 24" fill="currentColor"><path d="M6.012 4.012c3.313 0 6 2.687 6 6s-2.687 6-6 6-6-2.687-6-6 2.687-6 6-6zm11.976 0c3.313 0 6 2.687 6 6s-2.687 6-6 6-6-2.687-6-6 2.687-6 6-6zM6.012 18c3.313 0 6 2.687 6 6s-2.687 6-6 6-6-2.687-6-6 2.687-6 6-6zm11.976 0c3.313 0 6 2.687 6 6s-2.687 6-6 6-6-2.687-6-6 2.687-6 6-6z"></path></svg>
                    </a>
                    <div>
                        <a href="{{ Auth::check() && Auth::user()->role == 'admin' ? route('admin.dashboard') : route('home') }}" class="text-xl font-bold text-white">PMM</a>
                    </div>
                </div>

                {{-- Menu Navbar Dinamis --}}
                <div class="hidden md:flex items-baseline space-x-1 lg:space-x-2">
                    @if(Auth::check() && Auth::user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-emerald-500 text-white' : 'text-slate-300 hover:bg-gray-800 hover:text-white' }} px-3 py-2 rounded-lg text-sm font-medium transition-colors">Beranda</a>
                        <a href="{{ route('vehicles.index') }}" class="{{ request()->routeIs('vehicles.index') ? 'bg-emerald-500 text-white' : 'text-slate-300 hover:bg-gray-800 hover:text-white' }} px-3 py-2 rounded-lg text-sm font-medium transition-colors">Katalog</a>
                    @else
                        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'bg-emerald-500 text-white' : 'text-slate-300 hover:bg-gray-800 hover:text-white' }} px-3 py-2 rounded-lg text-sm font-medium transition-colors">Beranda</a>
                        <a href="{{ route('vehicles.index') }}" class="{{ request()->routeIs('vehicles.index') ? 'bg-emerald-500 text-white' : 'text-slate-300 hover:bg-gray-800 hover:text-white' }} px-3 py-2 rounded-lg text-sm font-medium transition-colors">Katalog</a>
                        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'bg-emerald-500 text-white' : 'text-slate-300 hover:bg-gray-800 hover:text-white' }} px-3 py-2 rounded-lg text-sm font-medium transition-colors">Tentang</a>
                        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'bg-emerald-500 text-white' : 'text-slate-300 hover:bg-gray-800 hover:text-white' }} px-3 py-2 rounded-lg text-sm font-medium transition-colors">Kontak</a>
                    @endif
                </div>

                {{-- Bagian Kanan Navbar --}}
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        @if (Auth::user()->role === 'user')
                        <div class="flex items-center space-x-2">
                            <button type="button" id="cart-button" title="Keranjang Belanja" class="relative text-slate-300 hover:text-white p-2 rounded-full hover:bg-gray-800">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </button>
                            <button type="button" id="favorite-button" title="Kendaraan Favorit" class="relative text-slate-300 hover:text-white p-2 rounded-full hover:bg-gray-800">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </button>
                        </div>
                        @endif

                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('admin.vehicles.create') }}" class="text-gray-900 bg-emerald-500 hover:bg-emerald-600 font-semibold rounded-lg text-sm px-5 py-2.5 text-center transition-colors">
                                Tambah Kendaraan
                            </a>
                        @endif

                        <div class="relative" id="user-dropdown-container">
                            <button type="button" id="user-dropdown-button" class="flex items-center gap-2 text-sm font-medium text-slate-300 hover:text-white focus:outline-none">
                                <span>Halo, {{ Str::words(Auth::user()->name, 1, '') }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div id="user-dropdown-content" class="hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-lg border border-slate-700 py-1 z-50">
                                @if (Auth::user()->role == 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-gray-700">Dashboard Admin</a>
                                @else
                                    <a href="{{ route('user.orders') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-gray-700">Pesanan Saya</a>
                                @endif
                                <a href="#" class="block px-4 py-2 text-sm text-slate-300 hover:bg-gray-700">Profil</a>
                                <div class="border-t border-slate-700 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-slate-300 hover:bg-gray-700">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-white bg-transparent border border-slate-600 hover:bg-slate-800 font-semibold rounded-lg text-sm px-6 py-2.5 text-center transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="text-gray-900 bg-emerald-500 hover:bg-emerald-600 font-semibold rounded-lg text-sm px-6 py-2.5 text-center transition-colors">Daftar</a>
                    @endauth
                </div>

                {{-- Tombol Hamburger untuk Mobile --}}
                <div class="flex md:hidden">
                    <button type="button" id="mobile-menu-button" class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg id="icon-hamburger" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                        <svg id="icon-close" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>

            {{-- KONTEN MENU MOBILE --}}
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-2 px-2 pt-2 pb-3">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'bg-emerald-500 text-white' : 'text-slate-300 hover:bg-gray-800 hover:text-white' }} block px-3 py-2 rounded-lg text-base font-medium transition-colors">Beranda</a>
                    <a href="{{ route('vehicles.index') }}" class="{{ request()->routeIs('vehicles.index') ? 'bg-emerald-500 text-white' : 'text-slate-300 hover:bg-gray-800 hover:text-white' }} block px-3 py-2 rounded-lg text-base font-medium transition-colors">Katalog</a>
                    <a href="#" class="text-slate-300 hover:bg-gray-800 hover:text-white block px-3 py-2 rounded-lg text-base font-medium transition-colors">Tentang</a>
                    <a href="#" class="text-slate-300 hover:bg-gray-800 hover:text-white block px-3 py-2 rounded-lg text-base font-medium transition-colors">Kontak</a>
                </div>

                <div class="pt-4 mt-4 border-t border-slate-700 px-2">
                @auth
                    {{-- Tampilan Mobile untuk User Login --}}
                    <div class="flex items-center px-3 mb-3">
                        <div class="ml-3">
                            <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-slate-400">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class="flex flex-col space-y-2 mt-3">
                        @if (Auth::user()->role == 'admin')
                             <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:bg-gray-700">Dashboard Admin</a>
                        @else
                             <a href="{{ route('user.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:bg-gray-700">Keranjang Saya</a>
                        @endif
                        <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:bg-gray-700">Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:bg-gray-700">Logout</button>
                        </form>
                    </div>
                @else
                    {{-- Tampilan Mobile untuk Tamu --}}
                    <div class="flex flex-col space-y-3">
                        <a href="{{ route('login') }}" class="block w-full text-center text-white bg-slate-800 hover:bg-slate-700 font-semibold rounded-lg px-6 py-2.5 transition-colors">Masuk</a>

                    {{-- ==== PERBAIKAN DI SINI ==== --}}
                    {{-- Link ini yang menyebabkan error. Kita ubah agar mengarah ke halaman register --}}
                        <a href="{{ route('register') }}" class="block w-full text-center text-gray-900 bg-emerald-500 hover:bg-emerald-600 font-semibold rounded-lg px-6 py-2.5 transition-colors">Daftar</a>
                    </div>
                @endauth
                </div>
            </div>
        </nav>
    </header>

    {{-- Konten Utama --}}
    <main class="flex-grow">
        @yield('content')
    </main>

{{-- Footer --}}
    <footer class="bg-gray-900 text-slate-400 border-t border-slate-800 mt-auto">
        <div class="max-w-screen-xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
                <div class="lg:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 bg-emerald-500 rounded-lg">
                            <span class="text-2xl font-bold text-white">P</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Putra Mandiri Motor</h3>
                        </div>
                    </div>
                    <p class="text-sm">Platform jual beli kendaraan bekas terpercaya di Indonesia dengan layanan dan harga kompetitif.</p>
                    <div class="flex space-x-4 mt-6">
                        <a href="#" class="text-slate-400 hover:text-emerald-500 transition-colors"><span class="sr-only">Mail</span><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg></a>
                        <a href="#" class="text-slate-400 hover:text-emerald-500 transition-colors"><span class="sr-only">Phone</span><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"></path></svg></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-slate-200 tracking-wider uppercase mb-4">Kendaraan</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">Mobil Bekas</a></li>
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">Motor Bekas</a></li>
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">Mobil Baru</a></li>
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">Motor Baru</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-slate-200 tracking-wider uppercase mb-4">Layanan</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">Jual Kendaraan</a></li>
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">Beli Kendaraan</a></li>
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">Inspeksi</a></li>
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">Asuransi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-slate-200 tracking-wider uppercase mb-4">Bantuan</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">FAQ</a></li>
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">Kontak</a></li>
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">Kebijakan Privasi</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-slate-800 text-center text-sm">
                <p>&copy; {{ date('Y') }} Putra Mandiri Motor. Semua hak dilindungi undang-undang.</p>
            </div>
        </div>
    </footer>
    {{-- ======================================================= --}}
    {{-- HTML UNTUK PANEL SAMPING --}}
    {{-- ======================================================= --}}
    @auth
        <div id="side-panel-overlay" class="fixed inset-0 bg-black/60 z-40 hidden transition-opacity duration-300 opacity-0"></div>
        <div id="side-panel" class="fixed top-0 right-0 h-full w-full max-w-md bg-gray-900 border-l border-slate-800 shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out z-50">
            <div id="side-panel-content" class="h-full flex flex-col">
                {{-- Konten panel akan diisi oleh JavaScript --}}
            </div>
        </div>
    @endauth

    {{-- SCRIPT DI SINI --}}
    @stack('scripts')
    {{-- ======================================================= --}}
    {{-- JAVASCRIPT LENGKAP UNTUK SEMUA INTERAKSI --}}
    {{-- ======================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Logika untuk Dropdown Profil Pengguna
            const userDropdownContainer = document.getElementById('user-dropdown-container');
            if (userDropdownContainer) {
                const userDropdownButton = document.getElementById('user-dropdown-button');
                const userDropdownContent = document.getElementById('user-dropdown-content');

                userDropdownButton.addEventListener('click', (event) => {
                    event.stopPropagation();
                    userDropdownContent.classList.toggle('hidden');
                });

                document.addEventListener('click', (event) => {
                    if (!userDropdownContainer.contains(event.target)) {
                        userDropdownContent.classList.add('hidden');
                    }
                });
            }

            // Logika untuk Panel Samping (Keranjang & Favorit)
            const cartButton = document.getElementById('cart-button');
            const favoriteButton = document.getElementById('favorite-button');
            const sidePanel = document.getElementById('side-panel');
            const sidePanelContent = document.getElementById('side-panel-content');
            const sidePanelOverlay = document.getElementById('side-panel-overlay');

            const closePanel = () => {
                if (sidePanel) sidePanel.classList.add('translate-x-full');
                if (sidePanelOverlay) {
                    sidePanelOverlay.classList.add('opacity-0');
                    setTimeout(() => sidePanelOverlay.classList.add('hidden'), 300);
                }
            };

            const openPanel = async (type) => {
                if (!sidePanel || !sidePanelContent || !sidePanelOverlay) return;

                let url, title;
                if (type === 'cart') {
                    url = '{{ route("cart.items") }}';
                    title = 'Keranjang Belanja';
                } else if (type === 'favorites') {
                    url = '{{ route("favorites.items") }}';
                    title = 'Kendaraan Favorit';
                } else {
                    return;
                }
                
                sidePanelContent.innerHTML = '<div class="p-8 text-center text-slate-400">Memuat...</div>';
                sidePanelOverlay.classList.remove('hidden');
                setTimeout(() => sidePanelOverlay.classList.remove('opacity-0'), 10);
                sidePanel.classList.remove('translate-x-full');
                
                try {
                    const response = await fetch(url);
                    if (!response.ok) throw new Error('Network response was not ok.');
                    
                    const items = await response.json();
                    let content = `
                        <div class="flex justify-between items-center p-6 border-b border-slate-800">
                            <h2 class="text-2xl font-bold text-white">${title}</h2>
                            <button id="close-panel-button" class="p-2 rounded-full hover:bg-gray-800 text-slate-400 hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div class="flex-grow p-6 overflow-y-auto">`;

                    if (items.length > 0) {
                        items.forEach(item => {
                            const vehicle = item.vehicle;
                            if (!vehicle) return; 
                            
                            const deleteRoute = type === 'cart' ? '{{ url("/cart") }}/' + item.id : '{{ route("favorites.destroy") }}';
                            content += `
                                <div class="flex items-center justify-between py-4 border-b border-gray-800">
                                    <div class="flex items-center">
                                        <img src="${vehicle.image ? '{{ asset('storage') }}/' + vehicle.image : 'https://placehold.co/600x400/1a202c/9ca3af?text=No+Image'}" class="w-24 h-16 rounded-md object-cover">
                                        <div class="ml-4">
                                            <a href="{{ url('/vehicles') }}/${vehicle.id}" class="font-bold text-white hover:text-emerald-400">${vehicle.title}</a>
                                            <p class="text-sm text-slate-400">Rp ${new Intl.NumberFormat('id-ID').format(vehicle.price)}</p>
                                        </div>
                                    </div>
                                    <form action="${deleteRoute}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus item ini?');">
                                        @csrf
                                        @method('DELETE')
                                        ${type === 'favorites' ? `<input type="hidden" name="vehicle_id" value="${vehicle.id}">` : ''}
                                        <button type="submit" class="text-red-500 hover:text-red-400 font-semibold text-sm">Hapus</button>
                                    </form>
                                </div>`;
                        });
                    } else {
                        content += `<div class="text-center py-12 text-slate-400">Daftar Anda masih kosong.</div>`;
                    }
                    
                    content += `</div>`;

                    {{-- ======================================================= --}}
                    {{-- PERBAIKAN LOGIKA TOTAL HARGA --}}
                    {{-- ======================================================= --}}
                    if (type === 'cart' && items.length > 0) {
                        const totalPrice = items.reduce((sum, item) => {
                            // Ubah harga dari string menjadi angka, jika tidak valid anggap 0
                            const price = (item.vehicle && !isNaN(parseFloat(item.vehicle.price))) ? parseFloat(item.vehicle.price) : 0;
                            return sum + price;
                        }, 0);

                        content += `
                            <div class="p-6 border-t border-slate-800">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-lg text-slate-300">Total:</span>
                                    <span class="text-xl font-bold text-white">Rp ${new Intl.NumberFormat('id-ID').format(totalPrice)}</span>
                                </div>
                                <form action="{{ route('checkout.store') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-emerald-500 text-black font-bold py-3 rounded-lg hover:bg-emerald-600 transition">
                                        Lanjutkan ke Pembayaran
                                    </button>
                                </form>
                            </div>`;
                    }
                    
                    sidePanelContent.innerHTML = content;
                    document.getElementById('close-panel-button').addEventListener('click', closePanel);

                } catch (error) {
                    console.error('Error fetching panel data:', error);
                    sidePanelContent.innerHTML = '<div class="p-8 text-center"><p class="text-red-400">Gagal memuat data.</p><button id="close-panel-button-error" class="mt-4 text-emerald-400">Tutup</button></div>';
                    document.getElementById('close-panel-button-error').addEventListener('click', closePanel);
                }
            };

            if (cartButton) cartButton.addEventListener('click', () => openPanel('cart'));
            if (favoriteButton) favoriteButton.addEventListener('click', () => openPanel('favorites'));
            if (sidePanelOverlay) sidePanelOverlay.addEventListener('click', closePanel);
        });
    </script>
</body>
</html>
