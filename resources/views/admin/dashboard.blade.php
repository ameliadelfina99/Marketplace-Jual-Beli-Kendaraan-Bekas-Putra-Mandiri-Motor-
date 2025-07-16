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

        {{-- Menampilkan pesan error jika ada --}}
        @if (session('error'))
            <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-3 rounded-lg relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Kartu Statistik Umum -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-gray-900 border border-slate-800 rounded-lg p-6 flex items-center">
                <div class="bg-emerald-500/20 p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M12 6h.01M12 21a9 9 0 110-18 9 9 0 010 18z"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-slate-400">Total Pendapatan (Semua)</p>
                    <p class="text-2xl font-bold text-white">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="bg-gray-900 border border-slate-800 rounded-lg p-6 flex items-center">
                <div class="bg-sky-500/20 p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a3.001 3.001 0 015.688 0M12 12a3 3 0 100-6 3 3 0 000 6z"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-slate-400">Total Kendaraan</p>
                    <p class="text-2xl font-bold text-white">{{ $totalVehicles ?? 0 }}</p>
                </div>
            </div>
            <div class="bg-gray-900 border border-slate-800 rounded-lg p-6 flex items-center">
                <div class="bg-indigo-500/20 p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-slate-400">Total Pesanan (Semua)</p>
                    <p class="text-2xl font-bold text-white">{{ $totalOrders ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Container untuk Grafik Penjualan -->
        <div class="bg-gray-900 border border-slate-800 rounded-lg shadow-lg p-6 sm:p-8 mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                <div>
                    <h2 class="text-xl font-bold text-white mb-1">Analisis Penjualan Kendaraan</h2>
                    <p class="text-sm text-slate-400">Pilih periode untuk melihat unit kendaraan terlaris.</p>
                </div>
                <div class="flex items-center space-x-2 mt-4 sm:mt-0">
                    <select id="chart-month" class="chart-filter-select bg-gray-800 border border-slate-700 text-slate-300 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
                    </select>
                    <select id="chart-year" class="chart-filter-select bg-gray-800 border border-slate-700 text-slate-300 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
                    </select>
                </div>
            </div>

            <!-- Kartu Ringkasan Dinamis -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-800/50 p-4 rounded-lg">
                    <p class="text-sm text-slate-400">Pemasukan (Periode Terpilih)</p>
                    <p id="monthly-revenue-value" class="text-xl font-bold text-white">Rp {{ number_format($initialMonthlyRevenue ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gray-800/50 p-4 rounded-lg">
                    <p class="text-sm text-slate-400">Unit Terjual (Periode Terpilih)</p>
                    <p id="monthly-units-value" class="text-xl font-bold text-white">{{ $initialMonthlyUnits ?? 0 }}</p>
                </div>
            </div>

            <div id="salesChart" data-url="{{ route('admin.sales.data') }}"></div>
        </div>

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
                                        <a href="{{ route('vehicles.show', $vehicle) }}" class="text-sky-400 hover:text-sky-300" target="_blank" title="Lihat di halaman publik">Lihat</a>
                                        <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="text-indigo-400 hover:text-indigo-300">Edit</a>
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

@push('scripts')
{{-- 1. Muat library ApexCharts dari CDN --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    window.initialChartData = @json($initialChartData ?? []);
</script>

{{-- 2. Inisialisasi Grafik --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const salesChartEl = document.querySelector("#salesChart");
    const monthSelect = document.getElementById('chart-month');
    const yearSelect = document.getElementById('chart-year');
    const monthlyRevenueEl = document.getElementById('monthly-revenue-value');
    const monthlyUnitsEl = document.getElementById('monthly-units-value');
    let chart;

    const salesDataUrl = salesChartEl.dataset.url;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const chartOptions = {
        series: [{
            name: 'Unit Terjual',
            data: [] 
        }],
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: false },
            zoom: { enabled: false }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 5,
                columnWidth: '50%',
                dataLabels: {
                    position: 'top',
                },
            },
        },
        dataLabels: { 
            enabled: true, 
            formatter: function (val) { return val; },
            offsetY: -20,
            style: { fontSize: '12px', colors: ["#cbd5e1"] }
        },
        xaxis: {
            type: 'category',
            title: {
                text: 'Nama Kendaraan',
                style: { color: '#9ca3af', fontWeight: 'normal' }
            },
            labels: { 
                style: { colors: '#9ca3af', fontSize: '12px' },
                trim: true,
                hideOverlappingLabels: false,
                rotate: -45,
                rotateAlways: true
            }
        },
        yaxis: {
            title: {
                text: 'Unit Terjual',
                style: { color: '#9ca3af', fontWeight: 'normal' }
            },
            labels: {
                style: { colors: '#9ca3af' },
                formatter: function (value) {
                    if (Number.isInteger(value)) return value;
                    return '';
                }
            },
            tickAmount: 5
        },
        colors: ['#10b981'],
        grid: { 
            borderColor: '#374151', 
            strokeDashArray: 4,
            xaxis: { lines: { show: false } }, 
            yaxis: { lines: { show: true } } 
        },
        tooltip: {
            theme: 'dark',
            custom: function({ series, seriesIndex, dataPointIndex, w }) {
                const dataPoint = w.config.series[seriesIndex].data[dataPointIndex];
                if (!dataPoint) return '';
                const vehicleName = dataPoint.x;
                const unitsSold = dataPoint.y;
                const revenue = dataPoint.revenue;
                const formattedRevenue = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(revenue);
                return `<div class="p-2 bg-gray-700 border border-slate-600 rounded-lg shadow-lg text-left">
                            <div class="font-bold text-white mb-1">${vehicleName}</div>
                            <div class="text-slate-300">Unit Terjual: ${unitsSold}</div>
                            <div class="text-slate-300">Pemasukan: ${formattedRevenue}</div>
                        </div>`;
            }
        },
        noData: {
            text: '',
            style: { color: '#9ca3af', fontSize: '14px' }
        }
    };

    if (salesChartEl) {
        const initialData = window.initialChartData;
        chartOptions.series[0].data = initialData;
        
        if (!initialData || initialData.length === 0) {
            chartOptions.noData.text = 'Tidak ada data penjualan pada periode ini.';
        }

        chart = new ApexCharts(salesChartEl, chartOptions);
        chart.render();
    }

    function populateFilters() {
        const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        const currentYear = new Date().getFullYear();
        const currentMonth = new Date().getMonth();

        months.forEach((month, index) => {
            const option = document.createElement('option');
            option.value = index + 1;
            option.textContent = month;
            if (index === currentMonth) option.selected = true;
            monthSelect.appendChild(option);
        });

        for (let i = 0; i < 5; i++) {
            const year = currentYear - i;
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            yearSelect.appendChild(option);
        }
    }

    async function updateChart(year, month) {
        if (!chart) return;
        
        chart.updateOptions({ noData: { text: 'Memuat data...' } });

        try {
            const response = await fetch(`${salesDataUrl}?year=${year}&month=${month}`, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) {
                throw new Error('Gagal mengambil data dari server. Sesi Anda mungkin telah berakhir.');
            }
            
            const result = await response.json();

            const formattedRevenue = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(result.monthly_revenue);
            monthlyRevenueEl.textContent = formattedRevenue;
            monthlyUnitsEl.textContent = result.monthly_units;

            chart.updateSeries([{
                data: result.data
            }]);

            if (!result.data || result.data.length === 0) {
                chart.updateOptions({ noData: { text: 'Tidak ada data penjualan pada periode ini.' } });
            }

        } catch (error) {
            console.error('Error updating chart:', error);
            chart.updateSeries([{ data: [] }]);
            chart.updateOptions({ noData: { text: `Gagal memuat data.` } });
            monthlyRevenueEl.textContent = 'Rp 0';
            monthlyUnitsEl.textContent = '0';
        }
    }

    [monthSelect, yearSelect].forEach(select => {
        select.addEventListener('change', () => {
            updateChart(yearSelect.value, monthSelect.value);
        });
    });

    populateFilters();
});
</script>
@endpush
