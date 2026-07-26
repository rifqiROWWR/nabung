<x-layouts.app title="Analytics">
    <h1 class="text-xl font-semibold mb-6">Savings Analysis</h1>

    <div class="grid grid-cols-2 gap-6 mb-6">
        <div class="bg-[#0B255C] text-white rounded-2xl p-6">
            <p class="text-xs uppercase text-slate-300">Highest Monthly Growth</p>
            <p class="text-3xl font-bold mt-1">{{ $bestGrowth >= 0 ? '+' : '' }}{{ $bestGrowth }}%</p>
            <p class="text-sm text-slate-300 mt-1">Achieved in {{ $bestMonthName }}</p>
        </div>
       <div class="bg-white rounded-2xl p-6">
    <p class="text-slate-500 text-sm">Projected Year-End</p>
    <p class="text-2xl font-bold">${{ number_format($projectedYearEnd, 2) }}</p>
    <div class="w-full bg-slate-100 rounded-full h-2 mt-2">
        <div class="bg-green-600 h-2 rounded-full" style="width:{{ $goalPercent }}%"></div>
    </div>
    <p class="text-xs text-slate-400 mt-1">{{ $goalPercent }}% of your ${{ number_format($annualGoal) }} annual goal</p>
</div>

    <div class="bg-white rounded-2xl p-6">
        <h2 class="font-semibold mb-4">Savings Growth</h2>
        <canvas id="growthChart" height="90"
            data-labels='@json($chartLabels)'
            data-values='@json($chartData)'></canvas>
    </div>

    @vite('resources/js/chart-setup.js')
</x-layouts.app>