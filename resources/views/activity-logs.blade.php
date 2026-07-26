<x-layouts.app title="Activity Log">
    <h1 class="text-xl font-semibold mb-6">Activity Log</h1>
    <div class="bg-white rounded-xl p-6">
        <table class="w-full text-sm">
            <thead class="text-left text-slate-400 border-b">
                <tr><th class="py-2">Waktu</th><th>User</th><th>Aksi</th><th>Detail</th></tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                <tr class="border-b last:border-0">
                    <td class="py-3">{{ $log->created_at->format('d M Y, H:i') }}</td>
                    <td>{{ $log->user->name ?? 'System' }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->description }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $logs->links() }}</div>
    </div>
</x-layouts.app>