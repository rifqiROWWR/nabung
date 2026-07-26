<x-guest-layout>
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-[#0B255C]">Halo, Selamat Datang!</h1>
        <p class="text-slate-500 mt-1">Mulai perjalanan menabungmu hari ini.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" class="font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full rounded-lg" type="email" name="email"
                placeholder="nama@email.com" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <div class="flex justify-between items-center">
                <x-input-label for="password" value="Password" class="font-semibold" />
                @if (Route::has('password.request'))
                    <a class="text-sm text-[#0B255C]" href="{{ route('password.request') }}">Lupa?</a>
                @endif
            </div>
            <x-text-input id="password" class="block mt-1 w-full rounded-lg" type="password" name="password"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-6">
            <button type="submit"
                class="w-full bg-[#0B255C] text-white font-semibold py-3 rounded-lg flex items-center justify-center gap-2 hover:bg-[#0a1f4d]">
                Masuk Ke VaultTrack
                <span>→</span>
            </button>
        </div>

        <p class="text-center text-sm text-slate-500 mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-[#0B255C] font-semibold">Daftar Sekarang</a>
        </p>
    </form>
</x-guest-layout>