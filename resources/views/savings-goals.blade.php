<x-layouts.app title="Savings Goals">
    <h1 class="text-xl font-semibold mb-6">Savings Goals & Targets</h1>

    <div class="grid grid-cols-3 gap-6 mb-8" x-data="{ openCreate: false }">
        <div class="col-span-2 bg-[#0B255C] text-white rounded-2xl p-6">
            <p class="text-xs uppercase text-slate-300">Total Savings Progress</p>
            <p class="text-3xl font-bold mt-1">Rp {{ number_format($totalCurrent, 0, ',', '.') }}</p>
            <p class="text-sm text-slate-300 mt-2">{{ $totalPercent }}% of total milestone reached</p>
            <div class="w-full bg-white/20 rounded-full h-2 mt-2">
                <div class="bg-green-400 h-2 rounded-full" style="width:{{ $totalPercent }}%"></div>
            </div>
        </div>

        <div>
            <button @click="openCreate = true" type="button"
                class="w-full h-full border-2 border-dashed border-slate-300 rounded-2xl flex flex-col items-center justify-center gap-2 text-[#0B255C] font-semibold">
                <span class="text-3xl">+</span>
                Create New Goal
            </button>

            <div x-show="openCreate" x-cloak class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 px-4">
                <div @click.outside="openCreate = false" class="bg-white rounded-xl p-6 w-full max-w-md">
                    <h2 class="font-semibold text-lg mb-4">Buat Goal Baru</h2>
                    <form method="POST" action="{{ route('savings-goals.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="text-sm font-medium">Nama Goal</label>
                            <input type="text" name="name" required class="w-full border rounded-lg px-3 py-2 mt-1">
                        </div>
                        <div class="mb-3">
                            <label class="text-sm font-medium">Target Dana (Rp)</label>
                            <input type="number" name="target_amount" required class="w-full border rounded-lg px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="text-sm font-medium">Target Tanggal</label>
                            <input type="date" name="target_date" class="w-full border rounded-lg px-3 py-2 mt-1">
                        </div>
                        <div class="flex gap-2 justify-end">
                            <button type="button" @click="openCreate = false" class="px-4 py-2 rounded-lg border">Batal</button>
                            <button type="submit" class="px-4 py-2 rounded-lg bg-[#0B255C] text-white">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        @forelse ($goals as $g)
        <div class="bg-white rounded-xl p-5" x-data="{ openFund: false }">
            <div class="flex justify-between items-start mb-1">
                <h3 class="font-semibold">{{ $g->name }}</h3>
                <form method="POST" action="{{ route('savings-goals.destroy', $g->id) }}"
                    onsubmit="return confirm('Hapus goal ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-400 text-xs hover:underline">Hapus</button>
                </form>
            </div>
            <p class="text-xs text-slate-400 mb-3">
                @if($g->target_date)
                    Est. {{ \Carbon\Carbon::parse($g->target_date)->format('F Y') }}
                @endif
            </p>
            <p class="text-sm mb-2">
                Rp {{ number_format($g->current_amount, 0, ',', '.') }} /
                Rp {{ number_format($g->target_amount, 0, ',', '.') }}
                <span class="text-[#0B255C] font-semibold">{{ $g->progress_percent }}%</span>
            </p>
            <div class="w-full bg-slate-100 rounded-full h-2 mb-4">
                <div class="bg-[#0B255C] h-2 rounded-full" style="width:{{ $g->progress_percent }}%"></div>
            </div>

            <button @click="openFund = true" type="button" class="text-sm text-[#0B255C] font-semibold">
                + Tambah Dana
            </button>

            <div x-show="openFund" x-cloak class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 px-4">
                <div @click.outside="openFund = false" class="bg-white rounded-xl p-6 w-full max-w-sm">
                    <h2 class="font-semibold text-lg mb-4">Tambah Dana ke "{{ $g->name }}"</h2>
                    <form method="POST" action="{{ route('savings-goals.add-fund', $g->id) }}">
                        @csrf
                        <div class="mb-4">
                            <label class="text-sm font-medium">Jumlah (Rp)</label>
                            <input type="number" name="amount" required class="w-full border rounded-lg px-3 py-2 mt-1">
                        </div>
                        <div class="flex gap-2 justify-end">
                            <button type="button" @click="openFund = false" class="px-4 py-2 rounded-lg border">Batal</button>
                            <button type="submit" class="px-4 py-2 rounded-lg bg-[#0B255C] text-white">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <p class="text-slate-400 col-span-3">Belum ada goal. Buat goal pertama kamu!</p>
        @endforelse
    </div>
</x-layouts.app>