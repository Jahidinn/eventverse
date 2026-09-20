@extends('layouts.app')

@section('title', 'Hubungi Kami - Eventverse.id')
@section('meta_description', 'Hubungi tim Eventverse.id untuk pertanyaan, masukan, atau bantuan seputar platform.')

@section('content')

{{-- ==================== HERO ==================== --}}
<section class="relative overflow-hidden bg-white border-b border-[#e2e8f0] py-10 sm:py-14 lg:py-16">

    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-[560px] h-[560px] rounded-full bg-[#2282ff]/[0.08] blur-3xl"></div>
        <div class="absolute top-[30%] -right-24 w-[420px] h-[420px] rounded-full bg-[#60a5fa]/[0.06] blur-3xl"></div>
        <div class="absolute bottom-8 left-[30%] w-24 h-24 rounded-[2rem] border border-[#2282ff]/[0.07] rotate-12"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center">

            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#ebf3ff] text-[#2282ff] text-xs font-semibold border border-[#2282ff]/20 mb-5">
                <i class="ti ti-message-circle"></i>
                <span>Hubungi Kami</span>
            </div>

            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#0f172a] tracking-tight leading-[1.15] m-0">
                Ada Pertanyaan?
                <span class="text-[#2282ff]">Kami Siap Membantu</span>
            </h1>

            <p class="mt-4 text-sm sm:text-base text-[#64748b] leading-relaxed">
                Tim kami siap membantu Anda. Kirim pesan melalui formulir di bawah
                atau hubungi kami lewat kontak yang tersedia.
            </p>

        </div>
    </div>
</section>


{{-- ==================== MAIN CONTENT ==================== --}}
<section class="bg-[#f8fafc] py-10 sm:py-12">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 lg:gap-6 items-start">

        {{-- ============ LEFT: CONTACT INFO ============ --}}
        <div class="lg:col-span-5 space-y-4">

            {{-- Intro Card --}}
            <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-6">
                <div class="flex items-start gap-3.5 mb-4">
                    <div class="w-11 h-11 rounded-xl bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center text-lg shrink-0">
                        <i class="ti ti-heart-handshake"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-extrabold text-[#0f172a] m-0 leading-snug">
                            Mari Terhubung
                        </h2>
                        <p class="text-xs text-[#64748b] mt-0.5 m-0">
                            Kami senang mendengar dari Anda
                        </p>
                    </div>
                </div>

                <p class="text-sm text-[#475569] leading-relaxed m-0">
                    Apakah kamu memiliki pertanyaan, masukan, atau hanya ingin menyapa kami?
                    Jangan ragu untuk mengirim pesan kepada tim kami. Kami berusaha
                    merespons setiap pesan secepat mungkin. Terima kasih atas dukungan Anda!
                </p>
            </div>

            {{-- Contact Details --}}
            <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-6">
                <div class="text-[10px] font-extrabold tracking-[0.08em] text-[#94a3b8] uppercase mb-4">
                    Informasi Kontak
                </div>

                <div class="space-y-4">

                    {{-- Address --}}
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center text-base shrink-0">
                            <i class="ti ti-map-pin"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-[#0f172a] mb-0.5">Alamat</div>
                            <p class="text-sm text-[#64748b] leading-relaxed m-0">
                                Jl Mijen Permai, Mijen Permai/BSB City,<br>
                                Kota Semarang, Pos 50219, Indonesia
                            </p>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-[#dcfce7] text-[#15803d] flex items-center justify-center text-base shrink-0">
                            <i class="ti ti-phone"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-[#0f172a] mb-0.5">Telepon</div>
                            <a href="tel:+6282133553002"
                               class="text-sm text-[#64748b] hover:text-[#2282ff] transition-colors break-all">
                                +62 821 3355 3002
                            </a>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-[#fef3c7] text-[#b45309] flex items-center justify-center text-base shrink-0">
                            <i class="ti ti-mail"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-[#0f172a] mb-0.5">Email</div>
                            <a href="mailto:contact@eventverse.id"
                               class="text-sm text-[#64748b] hover:text-[#2282ff] transition-colors break-all">
                                contact@eventverse.id
                            </a>
                        </div>
                    </div>

                    {{-- Instagram --}}
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-[#f3e8ff] text-[#7e22ce] flex items-center justify-center text-base shrink-0">
                            <i class="ti ti-brand-instagram"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-[#0f172a] mb-0.5">Instagram</div>
                            <a href="http://instagram.com/eventverse_id" target="_blank" rel="noopener"
                               class="text-sm text-[#64748b] hover:text-[#2282ff] transition-colors">
                                @eventverse_id
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Support Note --}}
            <div class="p-4 rounded-xl bg-[#ecfdf5] border border-[#a7f3d0]">
                <div class="flex items-start gap-2.5">
                    <i class="ti ti-clock-hour-4 text-[#15803d] text-base shrink-0 mt-0.5"></i>
                    <div class="text-xs text-[#065f46] leading-relaxed">
                        <strong>Jam Operasional:</strong> Senin – Jumat, 09.00 – 17.00 WIB.
                        Kami berusaha merespons setiap pesan dalam 1×24 jam kerja.
                    </div>
                </div>
            </div>

        </div>


        {{-- ============ RIGHT: FORM ============ --}}
        <div class="lg:col-span-7">
            <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] overflow-hidden">

                {{-- Header --}}
                <div class="flex items-start gap-3.5 p-5 sm:p-6 border-b border-[#f1f5f9]">
                    <div class="w-11 h-11 rounded-xl bg-[#2282ff] text-white flex items-center justify-center text-lg shrink-0 shadow-[0_4px_14px_rgba(34,130,255,0.3)]">
                        <i class="ti ti-send"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-extrabold text-[#0f172a] m-0 leading-snug">
                            Kirim Pesan
                        </h2>
                        <p class="text-xs text-[#64748b] mt-0.5 m-0">
                            Isi formulir di bawah ini, kami akan segera membalas
                        </p>
                    </div>
                </div>

                {{-- Form Body --}}
                <div class="p-5 sm:p-6">
                    <form id="form-contact-us" method="POST" class="space-y-4">
                        @csrf

                        {{-- Row: Email + Nama --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            <div>
                                <label for="email" class="block text-[13px] font-bold text-[#334155] mb-1.5">
                                    Email <span class="text-rose-500">*</span>
                                </label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       required
                                       autocomplete="email"
                                       placeholder="email@example.com"
                                       class="w-full h-11 px-3.5 rounded-xl border-[1.5px] border-[#cbd5e1] bg-white text-sm text-[#0f172a] outline-none transition-all placeholder:text-[#94a3b8] focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12">
                            </div>

                            <div>
                                <label for="name" class="block text-[13px] font-bold text-[#334155] mb-1.5">
                                    Nama Kamu <span class="text-rose-500">*</span>
                                </label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       required
                                       autocomplete="name"
                                       placeholder="Masukkan nama"
                                       class="w-full h-11 px-3.5 rounded-xl border-[1.5px] border-[#cbd5e1] bg-white text-sm text-[#0f172a] outline-none transition-all placeholder:text-[#94a3b8] focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12">
                            </div>

                        </div>

                        {{-- Subject --}}
                        <div>
                            <label for="subjek" class="block text-[13px] font-bold text-[#334155] mb-1.5">
                                Subjek <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                   id="subjek"
                                   name="subjek"
                                   required
                                   placeholder="Contoh: Pertanyaan tentang pembayaran"
                                   class="w-full h-11 px-3.5 rounded-xl border-[1.5px] border-[#cbd5e1] bg-white text-sm text-[#0f172a] outline-none transition-all placeholder:text-[#94a3b8] focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12">
                        </div>

                        {{-- Message --}}
                        <div>
                            <label for="message" class="block text-[13px] font-bold text-[#334155] mb-1.5">
                                Pesan <span class="text-rose-500">*</span>
                            </label>
                            <textarea id="message"
                                      name="message"
                                      required
                                      rows="5"
                                      placeholder="Tulis pesan Anda di sini..."
                                      class="w-full min-h-[140px] px-3.5 py-3 rounded-xl border-[1.5px] border-[#cbd5e1] bg-white text-sm text-[#0f172a] outline-none transition-all placeholder:text-[#94a3b8] focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12 resize-y leading-relaxed"></textarea>
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                                id="btn-send-msg"
                                class="w-full h-12 inline-flex items-center justify-center gap-2 rounded-xl font-bold text-sm text-white bg-gradient-to-br from-[#2282ff] to-[#02559b] shadow-[0_4px_14px_rgba(34,130,255,0.35)] hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(34,130,255,0.45)] transition-all disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none">
                            <i class="ti ti-send text-base"></i>
                            <span>Kirim Pesan</span>
                        </button>

                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
</section>

@endsection