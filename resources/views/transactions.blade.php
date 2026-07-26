<x-layouts.app title="Transactions">
    <h1 class="text-xl font-semibold mb-6">Transactions</h1>

    <div class="bg-white rounded-xl p-6">
        <table class="w-full text-sm">
            <thead class="text-left text-slate-400 border-b">

                <tr>
                    <th class="py-2">Date</th><th>Description</th><th>Category</th><th>Status</th><th class="text-right">Amount</th><th>Hapus</th>
                </tr>
            </thead>
            <tbody>
    @foreach ($transactions as $t)
    <tr class="border-b last:border-0">
        <td class="py-3">{{ $t->transaction_date->format('M d, Y') }}</td>
        <td class="font-medium">{{ $t->description }}</td>
        <td><span class="bg-slate-100 px-2 py-1 rounded-full text-xs">{{ $t->category }}</span></td>
        <td>
            @if($t->status === 'completed')
                <span class="text-green-600">● Completed</span>
            @elseif($t->status === 'pending')
                <span class="text-slate-400">● Pending</span>
            @else
                <span class="text-red-500">● Under Review</span>
            @endif
        </td>
        <td class="text-right">
            <p class="{{ $t->amount >= 0 ? 'text-green-600' : ($t->status === 'flagged' ? 'text-red-500' : '') }}">
                {{ $t->amount >= 0 ? '+' : '' }}${{ number_format($t->amount, 2) }}
            </p>
            <p class="text-xs text-slate-400 font-normal">by {{ $t->user->name }}</p>
        </td>
        <td class="text-right">
            <form method="POST" action="{{ route('transactions.destroy', $t->id) }}"
                onsubmit="return confirm('Hapus transaksi ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 text-xs hover:underline">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>
        </table>

        <div class="mt-4">
            {{ $transactions->links() }}
        </div>
    </div>
</x-layouts.app>