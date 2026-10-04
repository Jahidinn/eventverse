@extends('layouts.auth')

@section('title', 'Login - Eventverse.id')

@section('content')

<div class="min-h-screen flex">

    {{-- ==================== LEFT: BRANDING (desktop only) ==================== --}}
    <div class="hidden lg:flex lg:w-[45%] relative overflow-hidden bg-gradient-to-br from-[#2282ff] to-[#02559b] items-center justify-center p-12">

        {{-- Decorative blobs --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-[560px] h-[560px] rounded-full bg-white/5 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-[480px] h-[480px] rounded-full bg-white/5 blur-3xl"></div>
            <div class="absolute top-[20%] left-[15%] w-32 h-32 rounded-[2rem] border-2 border-white/10 rotate-12"></div>
            <div class="absolute bottom-[25%] right-[12%] w-24 h-24 rounded-full border-2 border-white/10"></div>
        </div>

        <div class="relative max-w-md">

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 backdrop-blur border border-white/25 mb-6">
                {{-- <i class="ti ti-sparkles text-white text-sm"></i> --}}
                <span class="text-xs font-bold text-white">eventverse.id</span>
            </div>

            <h2 class="text-3xl font-extrabold text-white leading-[1.2] m-0 tracking-tight">
                Satu platform untuk semua event kamu
            </h2>

            <p class="mt-4 text-sm text-white/80 leading-relaxed">
                Kelola event, tiket, peserta, dan pembayaran dalam satu dashboard
                terintegrasi.
            </p>

            {{-- Feature list --}}
            <div class="mt-8 space-y-3">
                @php
                    $features = [
                        'Pembuatan event gratis & tanpa potongan',
                        'Ticketing & QR Code check-in otomatis',
                        'Pembayaran online yang aman & terverifikasi',
                        'Laporan & analitik real-time',
                    ];
                @endphp

                @foreach($features as $feature)
                    <div class="flex items-center gap-3 text-white">
                        <div class="w-7 h-7 rounded-lg bg-white/15 backdrop-blur border border-white/20 flex items-center justify-center shrink-0">
                            <i class="ti ti-check text-xs"></i>
                        </div>
                        <span class="text-sm font-medium">{{ $feature }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Footer note --}}
            <div class="mt-10 pt-6 border-t border-white/15">
                <p class="text-xs text-white/60 m-0">
                    &copy; {{ date('Y') }} Eventverse.id — Dikelola oleh PT Satu Karya Teknologi
                </p>
            </div>

        </div>

    </div>

    {{-- ==================== RIGHT: FORM ==================== --}}
    <div class="flex-1 flex items-center justify-center p-5 sm:p-8 lg:p-10">

        <div class="w-full max-w-md">

            {{-- Logo — center di mobile, kiri di desktop --}}
            <div class="flex justify-center lg:justify-start mb-8">
                <a href="/" class="inline-flex items-center">
                    <img src="{{ asset('assets/img/eventverse-color.png') }}"
                         alt="Eventverse"
                         class="h-9 w-auto">
                </a>
            </div>

            {{-- Heading — center di mobile, kiri di desktop --}}
            <div class="mb-7 text-center lg:text-left">
                <h2 class="text-xl sm:text-2xl font-semibold text-[#0f172a] m-0 tracking-tight">
                    Selamat datang kembali
                </h2>
                <p class="mt-2 text-sm text-[#64748b] m-0">
                    Login untuk melanjutkan ke akun eventverse Anda
                </p>
            </div>

            {{-- Flash messages --}}
            @if (session()->has('success'))
                <div class="flex items-start gap-2.5 p-3.5 rounded-xl border border-[#a7f3d0] bg-[#ecfdf5] mb-4">
                    <div class="w-5 h-5 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center text-[11px] shrink-0 mt-0.5">
                        <i class="ti ti-check"></i>
                    </div>
                    <span class="text-xs text-[#065f46] leading-relaxed">{{ session('success') }}</span>
                </div>
            @endif

            @if (session()->has('loginError'))
                <div class="flex items-start gap-2.5 p-3.5 rounded-xl border border-[#fecaca] bg-[#fef2f2] mb-4">
                    <div class="w-5 h-5 rounded-full bg-[#fee2e2] text-[#dc2626] flex items-center justify-center text-[11px] shrink-0 mt-0.5">
                        <i class="ti ti-alert-triangle"></i>
                    </div>
                    <span class="text-xs text-[#991b1b] leading-relaxed">{{ session('loginError') }}</span>
                </div>
            @endif

            @if (session()->has('logoutSuccess'))
                <div class="flex items-start gap-2.5 p-3.5 rounded-xl border border-[#a7f3d0] bg-[#ecfdf5] mb-4">
                    <div class="w-5 h-5 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center text-[11px] shrink-0 mt-0.5">
                        <i class="ti ti-logout"></i>
                    </div>
                    <span class="text-xs text-[#065f46] leading-relaxed">{{ session('logoutSuccess') }}</span>
                </div>
            @endif

            {{-- Form --}}
            <form action="/login" method="POST" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-[13px] font-bold text-[#334155] mb-1.5">
                        Email
                    </label>
                    <div class="flex items-center gap-3 rounded-xl border-[1.5px] {{ $errors->has('email') ? 'border-[#fca5a5] bg-[#fef2f2]' : 'border-[#cbd5e1] bg-white' }} px-3.5 transition-all focus-within:border-[#2282ff] focus-within:ring-[3px] focus-within:ring-[#2282ff]/12">
                        <i class="ti ti-mail text-[#94a3b8] text-lg shrink-0"></i>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autocomplete="email"
                               autofocus
                               placeholder="example@email.com"
                               class="flex-1 min-w-0 h-12 border-0 bg-transparent text-sm text-[#0f172a] outline-none placeholder:text-[#94a3b8] focus:ring-0">
                    </div>
                    @error('email')
                        <small class="block text-xs text-rose-500 mt-1.5">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Password --}}
                <div x-data="{ show: false }">
                    <label for="password" class="block text-[13px] font-bold text-[#334155] mb-1.5">
                        Password
                    </label>
                    <div class="flex items-center gap-3 rounded-xl border-[1.5px] border-[#cbd5e1] bg-white px-3.5 transition-all focus-within:border-[#2282ff] focus-within:ring-[3px] focus-within:ring-[#2282ff]/12">
                        <i class="ti ti-lock text-[#94a3b8] text-lg shrink-0"></i>
                        <input :type="show ? 'text' : 'password'"
                               id="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="••••••••"
                               class="flex-1 min-w-0 h-12 border-0 bg-transparent text-sm text-[#0f172a] outline-none placeholder:text-[#94a3b8] focus:ring-0">
                        <button type="button"
                                @click="show = !show"
                                class="text-[#94a3b8] hover:text-[#0f172a] transition-colors shrink-0"
                                tabindex="-1">
                            <i class="ti text-lg" :class="show ? 'ti-eye-off' : 'ti-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <small class="block text-xs text-rose-500 mt-1.5">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Forgot password --}}
                <div class="flex justify-end">
                    <a href="/auth/forgot-password"
                       class="text-[13px] font-semibold text-[#2282ff] hover:text-[#1b6cd6] transition-colors">
                        Lupa password?
                    </a>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full h-12 inline-flex items-center justify-center gap-2 rounded-xl font-bold text-sm text-white bg-gradient-to-br from-[#2282ff] to-[#02559b] shadow-[0_4px_14px_rgba(34,130,255,0.35)] hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(34,130,255,0.45)] transition-all">
                    <i class="ti ti-login text-base"></i>
                    <span>Masuk</span>
                </button>
            </form>

            {{-- Register link --}}
            <div class="mt-6 text-center text-sm text-[#64748b]">
                Belum punya akun?
                <a href="/register" class="font-bold text-[#2282ff] hover:text-[#1b6cd6] transition-colors">
                    Daftar sekarang
                </a>
            </div>

        </div>
    </div>

</div>

@endsection