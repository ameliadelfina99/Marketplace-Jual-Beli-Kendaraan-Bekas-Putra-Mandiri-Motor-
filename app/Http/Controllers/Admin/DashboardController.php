<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller 
{
    /**
     * Menampilkan halaman utama dashboard dan data awal untuk grafik.
     */
    public function index()
    {
        try {
            // Data Statistik Global
            $totalRevenue = DB::table('transactions')->sum('total_amount');
            $totalVehicles = Vehicle::count();
            $totalOrders = DB::table('transactions')->count();

            // Data untuk Tabel Kendaraan
            $vehicles = Vehicle::with('user', 'brand')->latest()->get();

            // Ambil data awal untuk grafik saat halaman dimuat
            $currentYear = Carbon::now()->year;
            $currentMonth = Carbon::now()->month;

            // PERBAIKAN: Menggunakan whereBetween untuk filter tanggal yang lebih andal
            $startDate = Carbon::createFromDate($currentYear, $currentMonth, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($currentYear, $currentMonth, 1)->endOfMonth();

            $initialSalesData = DB::table('transactions')
                ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
                ->select(
                    'transaction_items.vehicle_title', 
                    DB::raw('COUNT(transaction_items.id) as units_sold'),
                    DB::raw('SUM(transaction_items.price) as total_revenue')
                )
                ->whereBetween('transactions.created_at', [$startDate, $endDate])
                ->groupBy('transaction_items.vehicle_title')
                ->orderByRaw('COUNT(transaction_items.id) DESC')
                ->get();

            $initialChartData = $initialSalesData->map(function($item) {
                return [
                    'x' => $item->vehicle_title,
                    'y' => $item->units_sold,
                    'revenue' => (float) $item->total_revenue
                ];
            });
            
            $initialMonthlyRevenue = $initialSalesData->sum('total_revenue');
            $initialMonthlyUnits = $initialSalesData->sum('units_sold');

        } catch (\Exception $e) {
            report($e);
            $totalRevenue = 0;
            $totalVehicles = 0;
            $totalOrders = 0;
            $vehicles = collect();
            $initialChartData = collect();
            $initialMonthlyRevenue = 0;
            $initialMonthlyUnits = 0;
            session()->flash('error', 'Gagal memuat sebagian data dashboard.');
        }

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalVehicles',
            'totalOrders',
            'vehicles',
            'initialChartData',
            'initialMonthlyRevenue',
            'initialMonthlyUnits'
        ));
    }

    /**
     * Mengambil data unit terjual berdasarkan nama kendaraan untuk grafik (via AJAX).
     */
    public function getSalesData(Request $request)
    {
        try {
            $validated = $request->validate([
                'year' => 'required|integer|digits:4',
                'month' => 'required|integer|between:1,12',
            ]);

            $year = $validated['year'];
            $month = $validated['month'];
            
            // PERBAIKAN: Menggunakan whereBetween untuk filter tanggal yang lebih andal
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

            $salesData = DB::table('transactions')
                ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
                ->select(
                    'transaction_items.vehicle_title',
                    DB::raw('COUNT(transaction_items.id) as units_sold'),
                    DB::raw('SUM(transaction_items.price) as total_revenue')
                )
                ->whereBetween('transactions.created_at', [$startDate, $endDate])
                ->groupBy('transaction_items.vehicle_title')
                ->orderByRaw('COUNT(transaction_items.id) DESC')
                ->get();

            $chartData = $salesData->map(function($item) {
                return [
                    'x' => $item->vehicle_title,
                    'y' => $item->units_sold,
                    'revenue' => (float) $item->total_revenue
                ];
            });

            $monthlyRevenue = $salesData->sum('total_revenue');
            $monthlyUnits = $salesData->sum('units_sold');

            return response()->json([
                'data' => $chartData,
                'monthly_revenue' => $monthlyRevenue,
                'monthly_units' => $monthlyUnits,
            ]);

        } catch (ValidationException $e) {
            return response()->json(['error' => 'Input tidak valid.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['error' => 'Terjadi kesalahan pada server.', 'message' => $e->getMessage()], 500);
        }
    }
}
