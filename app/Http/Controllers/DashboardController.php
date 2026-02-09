<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Weekly Stats (Current Week)
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $weeklyCustomers = \App\Models\Customer::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $weeklyIncome = \App\Models\Transaction::whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('total_amount');
        $weeklyServices = \App\Models\ServiceReport::whereBetween('date_in', [$startOfWeek, $endOfWeek])->count();

        // Low Stock Parts (Threshold < 10)
        $lowStockParts = \App\Models\Part::where('quantity_stock', '<', 10)
            ->orderBy('quantity_stock', 'asc')
            ->limit(5)
            ->get();

        // Recent Services for activity feed
        $recentServices = \App\Models\ServiceReport::with('customer')
            ->latest()
            ->limit(5)
            ->get();

        // Recent Transactions (Limit 5)
        $recentTransactions = \App\Models\Transaction::with(['report.customer'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'weeklyCustomers',
            'weeklyIncome',
            'weeklyServices',
            'lowStockParts',
            'recentTransactions',
            'recentServices'
        ));
    }
}
