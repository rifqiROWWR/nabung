<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nabungan — Tabungan Bersama</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Fraunces', serif; font-optical-sizing: auto; }

        /* Hati ambient melayang pelan di background */
        @keyframes floatUp {
            0%   { transform: translateY(10vh) scale(var(--s, 1)); opacity: 0; }
            10%  { opacity: .35; }
            90%  { opacity: .35; }
            100% { transform: translateY(-70vh) scale(var(--s, 1)); opacity: 0; }
        }
        .heart-ambient {
    position: fixed; bottom: 0; color: #FB7185;
    animation: floatUp var(--dur, 14s) linear infinite;
    animation-delay: var(--delay, 0s);
    user-select: none; pointer-events: none;
}

        /* Heart meter (signature hero) */
        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            10% { transform: scale(1.06); }
            20% { transform: scale(0.99); }
            30% { transform: scale(1.04); }
            40% { transform: scale(1); }
        }
        .heart-meter { animation: heartbeat 3.4s ease-in-out infinite; }
        .heart-fill { animation: fillRise 1.8s cubic-bezier(.22,1,.36,1) forwards; }
        @keyframes fillRise {
            from { y: 190px; }
            to   { y: 48px; }
        }

        /* Hati yang meletup keluar dari heart meter */
        .heart-burst-stage {
            position: fixed; inset: 0; pointer-events: none; z-index: 30; overflow: hidden;
        }
        .heart-burst {
            position: absolute;
            color: #FB7185;
            opacity: 0;
            transform: translate(-50%, -50%) scale(0);
            animation-name: heartBurst;
            animation-timing-function: cubic-bezier(.16,.8,.3,1);
            animation-fill-mode: forwards;
            will-change: transform, opacity;
        }
        @keyframes heartBurst {
            0%   { opacity: 0; transform: translate(-50%, -50%) scale(0) rotate(0deg); }
            12%  { opacity: .85; transform: translate(-50%, -50%) scale(1) rotate(8deg); }
            100% { opacity: 0; transform: translate(calc(-50% + var(--dx)), calc(-50% + var(--dy))) scale(.5) rotate(-12deg); }
        }

        @media (prefers-reduced-motion: reduce) {
            .heart-ambient, .heart-meter, .heart-fill, .heart-burst { animation: none !important; }
        }
    </style>
</head>
<body class="bg-[#F4F6FB] text-[#1E293B] antialiased">

    {{-- Panggung untuk hati yang meletup keluar --}}
    <div class="heart-burst-stage" aria-hidden="true"></div>

    <div class="relative overflow-hidden min-h-screen">

        {{-- Hati ambient melayang di background --}}
       <div class="fixed inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
    <span class="heart-ambient" style="left:3%;  --dur:15s; --delay:0.5s; --s:.6; font-size:18px;">♥</span>
    <span class="heart-ambient" style="left:8%;  --dur:16s; --delay:0s;   --s:.7; font-size:22px;">♥</span>
    <span class="heart-ambient" style="left:13%; --dur:11s; --delay:4s;   --s:.4; font-size:14px;">♥</span>
    <span class="heart-ambient" style="left:18%; --dur:19s; --delay:2s;   --s:.8; font-size:26px;">♥</span>
    <span class="heart-ambient" style="left:24%; --dur:13s; --delay:6.5s; --s:.5; font-size:16px;">♥</span>
    <span class="heart-ambient" style="left:30%; --dur:17s; --delay:1s;   --s:.9; font-size:28px;">♥</span>
    <span class="heart-ambient" style="left:36%; --dur:12s; --delay:5s;   --s:.5; font-size:15px;">♥</span>
    <span class="heart-ambient" style="left:42%; --dur:20s; --delay:3s;   --s:.7; font-size:20px;">♥</span>
    <span class="heart-ambient" style="left:48%; --dur:14s; --delay:7s;   --s:.6; font-size:18px;">♥</span>
    <span class="heart-ambient" style="left:54%; --dur:16s; --delay:2.5s; --s:.8; font-size:24px;">♥</span>
    <span class="heart-ambient" style="left:60%; --dur:11s; --delay:8s;   --s:.4; font-size:14px;">♥</span>
    <span class="heart-ambient" style="left:66%; --dur:18s; --delay:0.8s; --s:.9; font-size:27px;">♥</span>
    <span class="heart-ambient" style="left:72%; --dur:13s; --delay:5.5s; --s:.5; font-size:16px;">♥</span>
    <span class="heart-ambient" style="left:78%; --dur:20s; --delay:9s;   --s:.7; font-size:21px;">♥</span>
    <span class="heart-ambient" style="left:84%; --dur:12s; --delay:3.5s; --s:.6; font-size:18px;">♥</span>
    <span class="heart-ambient" style="left:90%; --dur:17s; --delay:10s;  --s:.8; font-size:25px;">♥</span>
    <span class="heart-ambient" style="left:95%; --dur:15s; --delay:6s;   --s:.5; font-size:16px;">♥</span>
    <span class="heart-ambient" style="left:5%;  --dur:19s; --delay:11s;  --s:.6; font-size:19px;">♥</span>
    <span class="heart-ambient" style="left:50%; --dur:10s; --delay:9.5s; --s:.4; font-size:13px;">♥</span>
    <span class="heart-ambient" style="left:98%; --dur:14s; --delay:1.5s; --s:.7; font-size:22px;">♥</span>
</div>
        {{-- Navbar --}}
        <nav class="relative z-10 flex items-center justify-between px-6 md:px-12 py-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#0B255C] flex items-center justify-center text-white font-bold font-display">N</div>
                <span class="font-display text-lg font-semibold text-[#0B255C]">Nabungan</span>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-5 py-2 rounded-lg bg-[#0B255C] text-white text-sm font-semibold">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-[#0B255C]">Masuk</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 rounded-lg bg-[#0B255C] text-white text-sm font-semibold">Daftar</a>
                @endauth
            </div>
        </nav>

        {{-- Hero --}}
        <section class="relative z-10 grid md:grid-cols-2 gap-12 items-center px-6 md:px-12 pt-10 md:pt-16 pb-24 max-w-6xl mx-auto">
            <div>
                <span class="inline-block text-xs font-semibold tracking-wide uppercase text-[#FB7185] bg-[#FB7185]/10 px-3 py-1 rounded-full mb-5">
                    Tabungan Bersama
                </span>
                <h1 class="font-display text-4xl md:text-5xl font-semibold leading-tight text-[#0B255C]">
                    Menabung lebih berarti,<br class="hidden md:block"> kalau dilakukan berdua.
                </h1>
                <p class="mt-5 text-slate-600 text-base md:text-lg max-w-md">
                    Catat transaksi, kejar target, dan pantau perkembangan tabungan bareng pasangan atau keluarga — semua transparan, semua tercatat.
                </p>
                <div class="mt-8 flex items-center gap-4">
                    <a href="{{ route('register') }}" class="px-6 py-3 rounded-lg bg-[#0B255C] text-white font-semibold hover:bg-[#0a1f4d] transition">
                        Mulai Menabung
                    </a>
                    <a href="{{ route('login') }}" class="px-6 py-3 rounded-lg border border-slate-300 font-semibold text-[#0B255C] hover:bg-white transition">
                        Sudah punya akun
                    </a>
                </div>
            </div>

            {{-- Signature: heart savings meter --}}
            <div class="flex justify-center">
                <div class="relative">
                    <svg viewBox="0 0 200 180" class="heart-meter w-56 md:w-72 drop-shadow-xl">
                        <defs>
                            <clipPath id="heartClip">
                                <path d="M100,170 C40,120 10,80 10,50 C10,20 35,0 60,0 C80,0 95,15 100,35 C105,15 120,0 140,0 C165,0 190,20 190,50 C190,80 160,120 100,170 Z"/>
                            </clipPath>
                            <linearGradient id="fillGrad" x1="0" y1="1" x2="0" y2="0">
                                <stop offset="0%" stop-color="#0B255C"/>
                                <stop offset="100%" stop-color="#34D399"/>
                            </linearGradient>
                        </defs>
                        <path d="M100,170 C40,120 10,80 10,50 C10,20 35,0 60,0 C80,0 95,15 100,35 C105,15 120,0 140,0 C165,0 190,20 190,50 C190,80 160,120 100,170 Z" fill="#EEF2FB"/>
                        <g clip-path="url(#heartClip)">
                            <rect class="heart-fill" x="0" y="190" width="200" height="180" fill="url(#fillGrad)"/>
                        </g>
                        <path d="M100,170 C40,120 10,80 10,50 C10,20 35,0 60,0 C80,0 95,15 100,35 C105,15 120,0 140,0 C165,0 190,20 190,50 C190,80 160,120 100,170 Z"
                              fill="none" stroke="#0B255C" stroke-width="4"/>
                    </svg>
                    <p class="text-center mt-4 text-sm text-slate-500">Target keluarga tercapai <span class="font-semibold text-[#0B255C]">64%</span></p>
                </div>
            </div>
        </section>

        {{-- Fitur --}}
        <section class="relative z-10 px-6 md:px-12 pb-24 max-w-6xl mx-auto">
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <div class="w-11 h-11 rounded-xl bg-[#0B255C]/10 flex items-center justify-center text-[#0B255C] text-xl mb-4">↕</div>
                    <h3 class="font-display font-semibold text-lg text-[#0B255C] mb-1">Transaksi Bersama</h3>
                    <p class="text-sm text-slate-500">Setiap pemasukan dan pengeluaran tercatat lengkap dengan siapa yang menambahkannya.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <div class="w-11 h-11 rounded-xl bg-[#FB7185]/10 flex items-center justify-center text-[#FB7185] text-xl mb-4">♥</div>
                    <h3 class="font-display font-semibold text-lg text-[#0B255C] mb-1">Target & Impian</h3>
                    <p class="text-sm text-slate-500">Buat goal — liburan, rumah, dana darurat — dan lihat progresnya tumbuh sedikit demi sedikit.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <div class="w-11 h-11 rounded-xl bg-[#34D399]/10 flex items-center justify-center text-[#34D399] text-xl mb-4">☰</div>
                    <h3 class="font-display font-semibold text-lg text-[#0B255C] mb-1">Riwayat Aktivitas</h3>
                    <p class="text-sm text-slate-500">Semua aktivitas tercatat rapi, jadi tidak ada yang bikin bingung siapa mengubah apa.</p>
                </div>
            </div>
        </section>

        <footer class="relative z-10 text-center pb-10 text-sm text-slate-400">
            Nabungan · Dibuat dengan ♥ untuk menabung bersama
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const meter = document.querySelector('.heart-meter');
            const stage = document.querySelector('.heart-burst-stage');
            const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (!meter || !stage || prefersReduced) return;

            function spawnHeart() {
                const rect = meter.getBoundingClientRect();
                const heart = document.createElement('span');
                heart.textContent = '♥';
                heart.className = 'heart-burst';

                const startX = rect.left + rect.width / 2;
                const startY = rect.top + rect.height * 0.35;

                const angle = (Math.random() * 160 - 80) * (Math.PI / 180);
                const distance = 140 + Math.random() * 260;
                const dx = Math.sin(angle) * distance;
                const dy = -Math.abs(Math.cos(angle) * distance) - 60;

                const size = 10 + Math.random() * 16;
                const duration = 2.6 + Math.random() * 2;

                heart.style.left = startX + 'px';
                heart.style.top = startY + 'px';
                heart.style.fontSize = size + 'px';
                heart.style.setProperty('--dx', dx + 'px');
                heart.style.setProperty('--dy', dy + 'px');
                heart.style.animationDuration = duration + 's';

                stage.appendChild(heart);
                setTimeout(() => heart.remove(), duration * 1000 + 100);
            }

            setInterval(spawnHeart, 200);
        });
    </script>
</body>
</html>