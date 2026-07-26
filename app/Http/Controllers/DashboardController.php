<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $recent = Transaction::with('user')
            ->orderByDesc('transaction_date')
            ->take(3)
            ->get();

        $totalBalance = Transaction::sum('amount');

        $monthlyIncome = Transaction::whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->where('amount', '>', 0)
            ->sum('amount');

        $monthlyExpense = Transaction::whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->where('amount', '<', 0)
            ->sum('amount');

        $lastMonthBalance = Transaction::where('transaction_date', '<', now()->startOfMonth())
            ->sum('amount');

        $growthPercent = $lastMonthBalance != 0
            ? round((($totalBalance - $lastMonthBalance) / abs($lastMonthBalance)) * 100, 1)
            : 0;

        return view('dashboard', [
            'recent' => $recent,
            'totalBalance' => $totalBalance,
            'monthlyIncome' => $monthlyIncome,
            'monthlyExpense' => abs($monthlyExpense),
            'growthPercent' => $growthPercent,
        ]);
    }
}