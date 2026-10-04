@extends('layouts.auth')

@section('title', 'Daftar - Eventverse.id')

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
                <i class="ti ti-rocket text-white text-sm"></i>
                <span class="text-xs font-bold text-white">Mulai GRATIS</span>
            </div>

            <h2 class="text-3xl font-extrabold text-white leading-[1.2] m-0 tracking-tight">
                Buat event pertamamu hari ini
            </h2>

            <p class="mt-4 text-sm text-white/80 leading-relaxed">
                Bergabung dengan banyak penyelenggara yang sudah mempercayai
                eventverse untuk mengelola event mereka.
            </p>

            {{-- Benefit list --}}
            <div class="mt-8 space-y-3">
                @php
                    $benefits = [
                        'Gratis tanpa biaya pendaftaran',
                        'Tanpa potongan dari penjualan tiket',
                        'Dashboard lengkap & real-time',
                        // 'Support 24/7 dari tim kami',
                    ];
                @endphp

                @foreach($benefits as $benefit)
                    <div class="flex items-center gap-3 text-white">
                        <div class="w-7 h-7 rounded-lg bg-white/15 backdrop-blur border border-white/20 flex items-center justify-center shrink-0">
                            <i class="ti ti-check text-xs"></i>
                        </div>
                        <span class="text-sm font-medium">{{ $benefit }}</span>
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
                    Register
                </h2>
                <p class="mt-2 text-sm text-[#64748b] m-0">
                    Mulai buat event, kelola peserta, ticketing, dan pembayaran dalam satu dashboard terintegrasi.
                </p>
            </div>

            {{-- Form --}}
            <form action="/register" method="POST" class="space-y-4">
                @csrf

                {{-- Username --}}
                <div>
                    <label for="username" class="block text-[13px] font-bold text-[#334155] mb-1.5">
                        Username
                    </label>
                    <div class="flex items-center gap-3 rounded-xl border-[1.5px] {{ $errors->has('username') ? 'border-[#fca5a5] bg-[#fef2f2]' : 'border-[#cbd5e1] bg-white' }} px-3.5 transition-all focus-within:border-[#2282ff] focus-within:ring-[3px] focus-within:ring-[#2282ff]/12">
                        <i class="ti ti-user text-[#94a3b8] text-lg shrink-0"></i>
                        <input type="text"
                               id="username"
                               name="username"
                               value="{{ old('username') }}"
                               required
                               autocomplete="username"
                               autofocus
                               placeholder="username"
                               class="flex-1 min-w-0 h-12 border-0 bg-transparent text-sm text-[#0f172a] outline-none placeholder:text-[#94a3b8] focus:ring-0">
                    </div>
                    @error('username')
                        <small class="block text-xs text-rose-500 mt-1.5">{{ $message }}</small>
                    @enderror
                </div>

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
                               placeholder="example@email.com"
                               class="flex-1 min-w-0 h-12 border-0 bg-transparent text-sm text-[#0f172a] outline-none placeholder:text-[#94a3b8] focus:ring-0">
                    </div>
                    @error('email')
                        <small class="block text-xs text-rose-500 mt-1.5">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Password & Konfirmasi Password --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    {{-- Password --}}
                    <div x-data="{ show: false }">
                        <label for="password" class="block text-[13px] font-bold text-[#334155] mb-1.5">
                            Password
                        </label>
                        <div class="flex items-center gap-3 rounded-xl border-[1.5px] {{ $errors->has('password') ? 'border-[#fca5a5] bg-[#fef2f2]' : 'border-[#cbd5e1] bg-white' }} px-3.5 transition-all focus-within:border-[#2282ff] focus-within:ring-[3px] focus-within:ring-[#2282ff]/12">
                            <i class="ti ti-lock text-[#94a3b8] text-lg shrink-0"></i>
                            <input :type="show ? 'text' : 'password'"
                                   id="password"
                                   name="password"
                                   required
                                   autocomplete="new-password"
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

                    {{-- Konfirmasi Password --}}
                    <div x-data="{ show: false }">
                        <label for="confirmPassword" class="block text-[13px] font-bold text-[#334155] mb-1.5">
                            Konfirmasi Password
                        </label>
                        <div class="flex items-center gap-3 rounded-xl border-[1.5px] {{ $errors->has('confirmPassword') ? 'border-[#fca5a5] bg-[#fef2f2]' : 'border-[#cbd5e1] bg-white' }} px-3.5 transition-all focus-within:border-[#2282ff] focus-within:ring-[3px] focus-within:ring-[#2282ff]/12">
                            <i class="ti ti-lock-check text-[#94a3b8] text-lg shrink-0"></i>
                            <input :type="show ? 'text' : 'password'"
                                   id="confirmPassword"
                                   name="confirmPassword"
                                   required
                                   autocomplete="new-password"
                                   placeholder="••••••••"
                                   class="flex-1 min-w-0 h-12 border-0 bg-transparent text-sm text-[#0f172a] outline-none placeholder:text-[#94a3b8] focus:ring-0">
                            <button type="button"
                                    @click="show = !show"
                                    class="text-[#94a3b8] hover:text-[#0f172a] transition-colors shrink-0"
                                    tabindex="-1">
                                <i class="ti text-lg" :class="show ? 'ti-eye-off' : 'ti-eye'"></i>
                            </button>
                        </div>
                        @error('confirmPassword')
                            <small class="block text-xs text-rose-500 mt-1.5">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full h-12 inline-flex items-center justify-center gap-2 rounded-xl font-bold text-sm text-white bg-gradient-to-br from-[#2282ff] to-[#02559b] shadow-[0_4px_14px_rgba(34,130,255,0.35)] hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(34,130,255,0.45)] transition-all">
                    <i class="ti ti-user-plus text-base"></i>
                    <span>Buat Akun</span>
                </button>

            </form>

            {{-- Login link --}}
            <div class="mt-6 text-center text-sm text-[#64748b]">
                Sudah punya akun?
                <a href="/login" class="font-bold text-[#2282ff] hover:text-[#1b6cd6] transition-colors">
                    Login sekarang
                </a>
            </div>

        </div>
    </div>

</div>

@endsection