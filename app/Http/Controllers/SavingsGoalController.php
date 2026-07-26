<?php

namespace App\Http\Controllers;

use App\Models\SavingsGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class SavingsGoalController extends Controller
{
    public function index()
    {
        $goals = SavingsGoal::orderByDesc('created_at')->get();

        $totalCurrent = $goals->sum('current_amount');
        $totalTarget = $goals->sum('target_amount');
        $totalPercent = $totalTarget > 0 ? round(($totalCurrent / $totalTarget) * 100) : 0;

        return view('savings-goals', compact('goals', 'totalCurrent', 'totalTarget', 'totalPercent'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:1',
            'target_date' => 'nullable|date',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['current_amount'] = 0;

        SavingsGoal::create($validated);

        ActivityLog::log('Buat Goal', $validated['name']);

        return redirect()->back()->with('success', 'Goal baru berhasil dibuat.');
    }

    public function addFund(Request $request, SavingsGoal $savingsGoal)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $savingsGoal->increment('current_amount', $request->amount);

         ActivityLog::log('Tambah Dana Goal', "{$savingsGoal->name} +Rp" . number_format($request->amount));

        return redirect()->back()->with('success', 'Dana berhasil ditambahkan ke goal.');
    }

    public function destroy(SavingsGoal $savingsGoal)
    {
        ActivityLog::log('Hapus Goal', $savingsGoal->name);

        $savingsGoal->delete();

        return redirect()->back()->with('success', 'Goal berhasil dihapus.');
    }
}