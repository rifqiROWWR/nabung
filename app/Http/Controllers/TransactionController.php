<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')
            ->orderByDesc('transaction_date')
            ->paginate(6);

        return view('transactions', compact('transactions'));
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'description' => 'required|string|max:255',
        'category' => 'required|string|max:100',
        'amount' => 'required|numeric',
        'status' => 'required|in:completed,pending,flagged',
        'transaction_date' => 'required|date',
    ]);

    $validated['user_id'] = Auth::id();

    $transaction = Transaction::create($validated);

    ActivityLog::log('Tambah Transaksi', "{$transaction->description} (\${$transaction->amount})");

    return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan.');
}
    public function destroy(Transaction $transaction)
{
    ActivityLog::log('Hapus Transaksi', $transaction->description);

    $transaction->delete();

    return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
}
}