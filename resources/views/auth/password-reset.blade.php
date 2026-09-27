@extends('layouts.auth')

@section('title', 'Reset Password - Eventverse.id')

@section('content')

<div class="min-h-screen flex flex-col items-center justify-center p-5 sm:p-8">

    <div class="w-full max-w-md">

        {{-- Logo — center --}}
        <div class="flex justify-center mb-5">
            <a href="/" class="inline-flex items-center">
                <img src="{{ asset('assets/img/eventverse-color.png') }}"
                     alt="Eventverse"
                     class="h-9 w-auto">
            </a>
        </div>

        {{-- Heading --}}
        <div class="mb-7 text-center">
            {{-- <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#ebf3ff] text-[#2282ff] text-[11px] font-bold border border-[#c2dcff] mb-4">
                <i class="ti ti-lock-check"></i>
                <span>Reset Password</span>
            </div> --}}
            <h2 class="text-xl sm:text-2xl font-extrabold text-[#0f172a] m-0 tracking-tight">
                Atur Password Baru
            </h2>
            <p class="mt-2 text-sm text-[#64748b] m-0">
                Buat password baru untuk akun kamu
            </p>
        </div>

        {{-- Card --}}
        <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-6">

            {{-- Flash error --}}
            @if (session()->has('loginError'))
                <div class="flex items-start gap-2.5 p-3.5 rounded-xl border border-[#fecaca] bg-[#fef2f2] mb-4">
                    <div class="w-5 h-5 rounded-full bg-[#fee2e2] text-[#dc2626] flex items-center justify-center text-[11px] shrink-0 mt-0.5">
                        <i class="ti ti-alert-triangle"></i>
                    </div>
                    <span class="text-xs text-[#991b1b] leading-relaxed">{{ session('loginError') }}</span>
                </div>
            @endif

            <form action="/auth/send-reset-password" method="POST" class="space-y-4">
                @csrf

                {{-- Hidden token --}}
                <input type="hidden" name="token" value="{{ $token }}">

                {{-- Email (readonly) --}}
                <div>
                    <label for="email" class="block text-[13px] font-bold text-[#334155] mb-1.5">
                        Email
                    </label>
                    <div class="flex items-center gap-3 rounded-xl border-[1.5px] border-[#e2e8f0] bg-[#f8fafc] px-3.5 transition-all">
                        <i class="ti ti-mail text-[#94a3b8] text-lg shrink-0"></i>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ $email }}"
                               readonly
                               required
                               placeholder="contoh@email.com"
                               class="flex-1 min-w-0 h-12 border-0 bg-transparent text-sm text-[#64748b] outline-none cursor-not-allowed focus:ring-0">
                        <i class="ti ti-lock text-[#94a3b8] text-base shrink-0"></i>
                    </div>
                    @error('email')
                        <small class="block text-xs text-rose-500 mt-1.5">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Password baru --}}
                <div x-data="{ show: false }">
                    <label for="password" class="block text-[13px] font-bold text-[#334155] mb-1.5">
                        Password Baru
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

                {{-- Submit --}}
                <button type="submit"
                        class="w-full h-12 inline-flex items-center justify-center gap-2 rounded-xl font-bold text-sm text-white bg-gradient-to-br from-[#2282ff] to-[#02559b] shadow-[0_4px_14px_rgba(34,130,255,0.35)] hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(34,130,255,0.45)] transition-all">
                    <i class="ti ti-key text-base"></i>
                    <span>Reset Password</span>
                </button>
            </form>

        </div>

        {{-- Back to login --}}
        <div class="mt-6 text-center text-sm text-[#64748b]">
            Sudah ingat password?
            <a href="/login" class="font-bold text-[#2282ff] hover:text-[#1b6cd6] transition-colors">
                Kembali ke Login
            </a>
        </div>

    </div>

</div>

@endsection