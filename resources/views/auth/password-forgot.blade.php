@extends('layouts.auth')

@section('title', 'Lupa Password - Eventverse.id')

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
                <i class="ti ti-key"></i>
                <span>Reset Password</span>
            </div> --}}
            <h2 class="text-xl sm:text-2xl font-semibold text-[#0f172a] m-0 tracking-tight">
                Lupa Password?
            </h2>
            <p class="mt-2 text-sm text-[#64748b] m-0">
                Masukkan email kamu dan kami akan mengirimkan tautan untuk mengatur ulang password.
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

            <form action="/auth/forgot-password" method="POST" class="space-y-4">
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
                               autofocus
                               autocomplete="email"
                               placeholder="contoh@email.com"
                               class="flex-1 min-w-0 h-12 border-0 bg-transparent text-sm text-[#0f172a] outline-none placeholder:text-[#94a3b8] focus:ring-0">
                    </div>
                    @error('email')
                        <small class="block text-xs text-rose-500 mt-1.5">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full h-12 inline-flex items-center justify-center gap-2 rounded-xl font-bold text-sm text-white bg-gradient-to-br from-[#2282ff] to-[#02559b] shadow-[0_4px_14px_rgba(34,130,255,0.35)] hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(34,130,255,0.45)] transition-all">
                    <i class="ti ti-send text-base"></i>
                    <span>Kirim Tautan Reset</span>
                </button>
            </form>

        </div>

        {{-- Back to login --}}
        <div class="mt-6 text-center text-sm text-[#64748b]">
            Ingat password Anda?
            <a href="/login" class="font-bold text-[#2282ff] hover:text-[#1b6cd6] transition-colors">
                Kembali ke Login
            </a>
        </div>

    </div>

</div>

{{-- Notifikasi sukses reset (Toastry) --}}
@if (Session::has('status'))
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof toast !== 'undefined') {
                toast.success('Berhasil!', {
                    description: @json(session('status')),
                    duration: 4000,
                    action: {
                        label: 'Ke Login',
                        onClick() {
                            window.location.href = '/login';
                        },
                    },
                });
            } else {
                alert(@json(session('status')));
                window.location.href = '/login';
            }
        });
    </script>
    @endpush
@endif

@endsection