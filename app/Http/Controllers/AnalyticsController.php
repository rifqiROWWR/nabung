<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $monthly = Transaction::selectRaw("DATE_FORMAT(transaction_date, '%Y-%m') as ym, SUM(amount) as total")
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('total', 'ym');

        $labels = [];
        $data = [];
        $cumulative = 0;

        foreach ($monthly as $ym => $total) {
            $cumulative += $total;
            $labels[] = Carbon::createFromFormat('Y-m', $ym)->format('M Y');
            $data[] = round($cumulative, 2);
        }

        $growths = [];
        for ($i = 1; $i < count($data); $i++) {
            if ($data[$i - 1] != 0) {
                $growths[$i] = (($data[$i] - $data[$i - 1]) / abs($data[$i - 1])) * 100;
            }
        }

        $bestMonthIndex = !empty($growths) ? array_keys($growths, max($growths))[0] : null;
        $bestGrowth = $bestMonthIndex !== null ? round($growths[$bestMonthIndex], 1) : 0;
        $bestMonthName = $bestMonthIndex !== null ? $labels[$bestMonthIndex] : '-';

        // === Projected Year-End ===
        $currentBalance = Transaction::sum('amount');

        // Rata-rata perubahan saldo per bulan, dihitung dari selisih antar bulan yang ada datanya
        $diffs = [];
        for ($i = 1; $i < count($data); $i++) {
            $diffs[] = $data[$i] - $data[$i - 1];
        }
        $avgMonthlyGrowth = count($diffs) > 0 ? array_sum($diffs) / count($diffs) : 0;

        $monthsLeft = 12 - now()->month;
        $projectedYearEnd = $currentBalance + ($avgMonthlyGrowth * $monthsLeft);

        $annualGoal = 60000; // target tahunan, sesuaikan angka ini
        $goalPercent = $annualGoal > 0 ? min(100, round(($projectedYearEnd / $annualGoal) * 100)) : 0;

        return view('analytics', [
            'chartLabels' => $labels,
            'chartData' => $data,
            'bestGrowth' => $bestGrowth,
            'bestMonthName' => $bestMonthName,
            'projectedYearEnd' => $projectedYearEnd,
            'goalPercent' => $goalPercent,
            'annualGoal' => $annualGoal,
        ]);
    }
}