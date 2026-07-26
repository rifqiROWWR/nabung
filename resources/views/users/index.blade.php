<x-layouts.app title="Kelola Akun">
    <div x-data="{ openCreate: false, editingUserId: null }">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-semibold">Kelola Akun</h1>
            <button @click="openCreate = true" type="button"
                class="bg-[#0B255C] text-white px-4 py-2 rounded-lg font-semibold">
                + Tambah Akun
            </button>
        </div>

        <div class="bg-white rounded-xl p-6">
            <table class="w-full text-sm">
                <thead class="text-left text-slate-400 border-b">
                    <tr><th class="py-2">Nama</th><th>Email</th><th>Role</th><th>Bergabung</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="border-b last:border-0">
                        <td class="py-3 font-medium">
                            {{ $user->name }}
                            @if($user->id === auth()->id())
                                <span class="text-xs text-slate-400">(kamu)</span>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="text-xs px-2 py-1 rounded-full {{ $user->role === 'admin' ? 'bg-[#0B255C] text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td class="text-right space-x-3">
                            <button @click="editingUserId = {{ $user->id }}" type="button"
                                class="text-[#0B255C] text-xs hover:underline">Edit</button>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="inline"
                                onsubmit="return confirm('Hapus akun {{ $user->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 text-xs hover:underline">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Modal Tambah Akun --}}
        <div x-show="openCreate" x-cloak class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 px-4">
            <div @click.outside="openCreate = false" class="bg-white rounded-xl p-6 w-full max-w-md">
                <h2 class="font-semibold text-lg mb-4">Tambah Akun Baru</h2>
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="text-sm font-medium">Nama</label>
                        <input type="text" name="name" required class="w-full border rounded-lg px-3 py-2 mt-1">
                    </div>
                    <div class="mb-3">
                        <label class="text-sm font-medium">Email</label>
                        <input type="email" name="email" required class="w-full border rounded-lg px-3 py-2 mt-1">
                    </div>
                    <div class="mb-3">
                        <label class="text-sm font-medium">Password</label>
                        <input type="password" name="password" required class="w-full border rounded-lg px-3 py-2 mt-1">
                    </div>
                    <div class="mb-4">
                        <label class="text-sm font-medium">Role</label>
                        <select name="role" class="w-full border rounded-lg px-3 py-2 mt-1">
                            <option value="member">Member</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="flex gap-2 justify-end">
                        <button type="button" @click="openCreate = false" class="px-4 py-2 rounded-lg border">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-lg bg-[#0B255C] text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Edit Akun --}}
        @foreach ($users as $user)
        <div x-show="editingUserId === {{ $user->id }}" x-cloak
            class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 px-4">
            <div @click.outside="editingUserId = null" class="bg-white rounded-xl p-6 w-full max-w-md">
                <h2 class="font-semibold text-lg mb-4">Edit Akun: {{ $user->name }}</h2>
                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="text-sm font-medium">Nama</label>
                        <input type="text" name="name" value="{{ $user->name }}" required class="w-full border rounded-lg px-3 py-2 mt-1">
                    </div>
                    <div class="mb-3">
                        <label class="text-sm font-medium">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" required class="w-full border rounded-lg px-3 py-2 mt-1">
                    </div>
                    <div class="mb-3">
                        <label class="text-sm font-medium">Password Baru (kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="w-full border rounded-lg px-3 py-2 mt-1">
                    </div>
                    <div class="mb-4">
                        <label class="text-sm font-medium">Role</label>
                        <select name="role" class="w-full border rounded-lg px-3 py-2 mt-1">
                            <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Member</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div class="flex gap-2 justify-end">
                        <button type="button" @click="editingUserId = null" class="px-4 py-2 rounded-lg border">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-lg bg-[#0B255C] text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach

    </div>
</x-layouts.app>