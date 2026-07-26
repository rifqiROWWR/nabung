<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'DamBill' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F6FB] text-slate-800">
<div class="flex min-h-screen">
    <aside class="w-72 bg-[#F0F3FA] border-r border-slate-200 flex flex-col px-5 py-6">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-11 h-11 rounded-xl bg-[#0B255C] flex items-center justify-center text-white font-bold">D</div>
            <div>
                <p class="font-bold text-[#0B255C] leading-tight">dambill</p>
                <p class="text-xs text-slate-500 uppercase leading-tight">Tabungan Bersama</p>
            </div>
        </div>

        <nav class="flex-1 space-y-1">
           @php
    $links = [
        ['dashboard', 'Dashboard'],
        ['transactions', 'Transactions'],
        ['analytics', 'Analytics'],
        ['savings-goals', 'Savings Goals'],
        ['activity-logs', 'Activity Log'],
    ];
    if (auth()->user()?->role === 'admin') {
        $links[] = ['users.index', 'Kelola Akun'];
    }
@endphp
            @foreach ($links as [$route, $label])
                <a href="{{ route($route) }}"
                   class="block px-4 py-2.5 rounded-lg font-medium
                   {{ request()->routeIs($route) ? 'bg-[#6EE7B7] text-[#0B255C]' : 'text-slate-600 hover:bg-slate-100' }}">
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        <div x-data="{ open: false }">
    <button @click="open = true" type="button"
        class="w-full bg-[#0B255C] text-white rounded-lg py-3 font-semibold mb-6">
        + New Transaction
    </button>

    <div x-show="open" x-cloak
        class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 px-4">
        <div @click.outside="open = false" class="bg-white rounded-xl p-6 w-full max-w-md">
            <h2 class="font-semibold text-lg mb-4">Tambah Transaksi</h2>

            <form method="POST" action="{{ route('transactions.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="text-sm font-medium">Deskripsi</label>
                    <input type="text" name="description" required
                        class="w-full border rounded-lg px-3 py-2 mt-1">
                </div>
                <div class="mb-3">
                    <label class="text-sm font-medium">Kategori</label>
                    <input type="text" name="category" required
                        class="w-full border rounded-lg px-3 py-2 mt-1">
                </div>
                <div class="mb-3">
                    <label class="text-sm font-medium">Jumlah (pakai minus untuk pengeluaran, contoh -50000)</label>
                    <input type="number" step="0.01" name="amount" required
                        class="w-full border rounded-lg px-3 py-2 mt-1">
                </div>
                <div class="mb-3">
                    <label class="text-sm font-medium">Status</label>
                    <select name="status" class="w-full border rounded-lg px-3 py-2 mt-1">
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="flagged">Flagged</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="text-sm font-medium">Tanggal</label>
                    <input type="date" name="transaction_date" required
                        class="w-full border rounded-lg px-3 py-2 mt-1">
                </div>
                <div class="flex gap-2 justify-end">
                    <button type="button" @click="open = false" class="px-4 py-2 rounded-lg border">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-[#0B255C] text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

        <div class="space-y-1 border-t border-slate-200 pt-4">
             <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-slate-600">Edit Profil</a>
            <a href="#" class="block px-4 py-2 text-slate-600">Support</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="block px-4 py-2 text-red-600 w-full text-left">Logout</button>
            </form>
        </div>
    </aside>
    <main class="flex-1 p-8">
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{ $slot }}
</main>
</div>
</body>
</html>