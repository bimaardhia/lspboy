<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik ringkas
        $todayTransactions = Transaction::whereDate('created_at', Carbon::today())->count(); // Transaksi hari ini
        $todayRevenue = Transaction::whereDate('created_at', Carbon::today())->sum('total'); // Total revenue hari ini

        // Grafik 7 hari terakhir
        $chartData = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total')
            )
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        // Process the data for Chart.js
        $chartLabels = $chartData->pluck('date')->toArray();
        $chartValues = $chartData->pluck('total')->map(function($value) {
            return floatval($value); // Convert the string to a float
        })->toArray();

        // 5 Transaksi terakhir
        $latestTransactions = Transaction::latest()->take(5)->get();

        return view('dashboard.index', compact('todayTransactions', 'todayRevenue', 'chartLabels', 'chartValues', 'latestTransactions'));
    }



}