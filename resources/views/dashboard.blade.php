<x-layouts.app title="Dashboard">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-xl font-semibold">Welcome back, {{ Auth::user()->name }}</h1>
            <p class="text-slate-500">Here's your financial snapshot for {{ now()->translatedFormat('F') }}.</p>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 bg-[#0B255C] text-white rounded-2xl p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs uppercase text-slate-300">Total Balance</p>
                    <p class="text-3xl font-bold mt-1">
                        ${{ number_format($totalBalance, 2) }}
                    </p>
                </div>
                <span class="text-xs {{ $growthPercent >= 0 ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' }} px-2 py-1 rounded-full">
                    {{ $growthPercent >= 0 ? '↗' : '↘' }} {{ $growthPercent }}%
                </span>
            </div>
            <div class="flex gap-3 mt-16">
                <button class="bg-white text-[#0B255C] px-5 py-2 rounded-lg font-semibold">Transfer Money</button>
                <button class="bg-white/10 px-5 py-2 rounded-lg font-semibold">Details</button>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-xl p-4 flex items-center gap-3">
                <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center text-green-600">↓</div>
                <div>
                    <p class="text-sm text-slate-500">Monthly Income</p>
                    <p class="font-semibold">${{ number_format($monthlyIncome, 2) }}</p>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 flex items-center gap-3">
                <div class="w-9 h-9 bg-red-100 rounded-lg flex items-center justify-center text-red-600">↑</div>
                <div>
                    <p class="text-sm text-slate-500">Monthly Expense</p>
                    <p class="font-semibold">${{ number_format($monthlyExpense, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 mt-6">
        <div class="flex justify-between mb-4">
            <h2 class="font-semibold">Recent Activity</h2>
            <a href="{{ route('transactions') }}" class="text-[#0B255C] text-sm">View All</a>
        </div>
        <table class="w-full text-sm">
            <thead class="text-left text-slate-400 border-b">
                <tr>
                    <th class="py-2">Transaction</th><th>Category</th><th>Date</th><th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recent as $t)
                <tr class="border-b last:border-0">
                    <td class="py-3">{{ $t->description }}</td>
                    <td><span class="bg-slate-100 px-2 py-1 rounded-full text-xs">{{ $t->category }}</span></td>
                    <td>{{ $t->transaction_date->format('M d, Y') }}</td>
                    <td class="text-right {{ $t->amount >= 0 ? 'text-green-600' : '' }}">
                        {{ $t->amount >= 0 ? '+' : '' }}${{ number_format($t->amount, 2) }}
                        <p class="text-xs text-slate-400 font-normal">by {{ $t->user->name }}</p>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.app>