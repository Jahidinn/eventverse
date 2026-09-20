@extends('layouts.app')

@section('title', 'Biaya Transaksi - Eventverse.id')
@section('meta_description', 'Eventverse gratis tanpa potongan biaya untuk penyelenggara. Biaya transaksi sepenuhnya dibebankan kepada pembeli di setiap transaksi.')

@section('content')

{{-- ==================== HERO ==================== --}}
<section class="relative overflow-hidden bg-white border-b border-[#e2e8f0] py-10 sm:py-14 lg:py-16">

    {{-- Abstract Background --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-[560px] h-[560px] rounded-full bg-[#2282ff]/[0.08] blur-3xl"></div>
        <div class="absolute top-[30%] -right-24 w-[420px] h-[420px] rounded-full bg-[#60a5fa]/[0.06] blur-3xl"></div>
        <div class="absolute bottom-8 left-[30%] w-24 h-24 rounded-[2rem] border border-[#2282ff]/[0.07] rotate-12"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center">

            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#dcfce7] text-[#15803d] text-xs font-bold border border-[#86efac] mb-5">
                <i class="ti ti-shield-check"></i>
                <span>0% Potongan untuk Penyelenggara</span>
            </div>

            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#0f172a] tracking-tight leading-[1.15] m-0">
                Pakai Eventverse
                <span class="text-[#2282ff]">Tanpa Potongan Biaya</span>
            </h1>

            <p class="mt-4 text-sm sm:text-base text-[#64748b] leading-relaxed max-w-2xl mx-auto">
                Eventverse <strong class="text-[#0f172a]">tidak memotong dana</strong> dari hasil penjualan tiket Anda.
                <strong class="text-[#0f172a]">Seluruh biaya transaksi dibebankan kepada pembeli</strong>
                di setiap transaksi — sehingga penyelenggara menerima dana penuh dari harga tiket yang dijual.
            </p>

        </div>
    </div>
</section>


{{-- ==================== STATS STRIP ==================== --}}
<section class="bg-[#f8fafc] pt-10 sm:pt-12">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">

        <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-6 text-center sm:text-left">
            <div class="w-11 h-11 rounded-xl bg-[#dcfce7] text-[#15803d] flex items-center justify-center text-lg mb-3 mx-auto sm:mx-0">
                <i class="ti ti-percentage"></i>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-[#0f172a] tracking-tight leading-none">0%</div>
            <div class="text-xs sm:text-sm text-[#64748b] mt-1.5 font-medium">Potongan dari Penyelenggara</div>
        </div>

        <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-6 text-center sm:text-left">
            <div class="w-11 h-11 rounded-xl bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center text-lg mb-3 mx-auto sm:mx-0">
                <i class="ti ti-wallet"></i>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-[#0f172a] tracking-tight leading-none">100%</div>
            <div class="text-xs sm:text-sm text-[#64748b] mt-1.5 font-medium">Dana Diterima Penyelenggara</div>
        </div>

        <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-6 text-center sm:text-left">
            <div class="w-11 h-11 rounded-xl bg-[#fef3c7] text-[#b45309] flex items-center justify-center text-lg mb-3 mx-auto sm:mx-0">
                <i class="ti ti-calendar-off"></i>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-[#0f172a] tracking-tight leading-none">Rp0</div>
            <div class="text-xs sm:text-sm text-[#64748b] mt-1.5 font-medium">Biaya Bulanan / Langganan</div>
        </div>

    </div>
</div>
</section>


{{-- ==================== MAIN CONTENT ==================== --}}
<section class="bg-[#f8fafc] py-10 sm:py-12">
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

    {{-- ============ INTRO HIGHLIGHT ============ --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-[#ebf3ff] to-white border border-[#c2dcff] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-7">

        <div class="pointer-events-none absolute -top-16 -right-16 w-48 h-48 rounded-full bg-[#2282ff]/10 blur-3xl"></div>

        <div class="relative flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[#2282ff] text-white flex items-center justify-center text-xl shrink-0 shadow-[0_4px_14px_rgba(34,130,255,0.35)]">
                <i class="ti ti-info-circle"></i>
            </div>

            <div class="min-w-0">
                <h2 class="text-base sm:text-lg font-extrabold text-[#0f172a] m-0 mb-2 leading-snug">
                    Bagaimana Eventverse Bekerja?
                </h2>
                <p class="text-sm text-[#475569] leading-relaxed m-0">
                    Eventverse dapat digunakan secara <strong class="text-[#0f172a]">gratis</strong> untuk membuat,
                    mengelola, dan mempublikasikan event — tanpa biaya pendaftaran, tanpa biaya bulanan,
                    dan <strong class="text-[#0f172a]">tanpa potongan dari harga tiket yang Anda jual</strong>.
                    Biaya transaksi sepenuhnya <strong class="text-[#0f172a]">dibebankan kepada pembeli</strong>
                    dan otomatis ditambahkan saat checkout sesuai metode pembayaran yang dipilih.
                </p>
            </div>
        </div>

    </div>


    {{-- ============ PRICING SECTION ============ --}}
    <div class="pt-2">
        <div class="text-center max-w-2xl mx-auto mb-6">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#ebf3ff] text-[#2282ff] text-[11px] font-bold uppercase tracking-wider mb-3">
                <i class="ti ti-receipt"></i>
                <span>Biaya Transaksi</span>
            </div>
            <h3 class="text-lg sm:text-xl font-extrabold text-[#0f172a] m-0 mb-2 leading-snug">
                Dibebankan ke Pembeli, Bukan Penyelenggara
            </h3>
            <p class="text-sm text-[#64748b] m-0 leading-relaxed">
                Biaya di bawah ini <strong class="text-[#0f172a]">ditambahkan ke total pembayaran pembeli</strong>
                dan sudah mencakup <strong class="text-[#0f172a]">Platform Fee Eventverse</strong>
                serta <strong class="text-[#0f172a]">Biaya Admin Payment Gateway</strong>.
            </p>
        </div>

        @php
            $pricingCards = [
                [
                    'icon' => 'ti ti-qrcode',
                    'icon_bg' => 'bg-[#ebf3ff]',
                    'icon_color' => 'text-[#2282ff]',
                    'title' => 'QRIS, GoPay, ShopeePay, LinkAja',
                    'subtitle' => 'Rekomendasi untuk biaya transaksi yang lebih efisien.',
                    'value' => '3%',
                ],
                [
                    'icon' => 'ti ti-building-bank',
                    'icon_bg' => 'bg-[#fef3c7]',
                    'icon_color' => 'text-[#b45309]',
                    'title' => 'Virtual Account & Bank Transfer',
                    'subtitle' => 'Berlaku untuk seluruh Virtual Account dan transfer bank.',
                    'value' => '1,5% + Rp4.500',
                ],
                [
                    'icon' => 'ti ti-credit-card',
                    'icon_bg' => 'bg-[#f3e8ff]',
                    'icon_color' => 'text-[#7e22ce]',
                    'title' => 'Kartu Kredit & Metode Pembayaran Lainnya',
                    'subtitle' => 'Menyesuaikan metode pembayaran yang dipilih pembeli.',
                    'value' => '2,5% + Rp2.500',
                ],
            ];
        @endphp

        <div class="space-y-3">
            @foreach($pricingCards as $card)
                <div class="group bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_2px_12px_-2px_rgba(15,23,42,0.04)] hover:shadow-[0_12px_30px_-8px_rgba(34,130,255,0.15)] hover:border-[#c2dcff] hover:-translate-y-0.5 transition-all p-4 sm:p-5">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                        <div class="flex items-start gap-3.5 min-w-0 flex-1">
                            <div class="w-11 h-11 rounded-xl {{ $card['icon_bg'] }} {{ $card['icon_color'] }} flex items-center justify-center text-lg shrink-0">
                                <i class="{{ $card['icon'] }}"></i>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-sm sm:text-base font-bold text-[#0f172a] m-0 leading-snug">
                                    {{ $card['title'] }}
                                </h4>
                                <p class="text-xs text-[#64748b] mt-1 m-0 leading-relaxed">
                                    {{ $card['subtitle'] }}
                                </p>
                            </div>
                        </div>

                        <div class="shrink-0 sm:text-right">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-[#94a3b8] mb-1">
                                Dibebankan ke Pembeli
                            </div>
                            <span class="inline-block bg-[#ebf3ff] text-[#2282ff] text-base font-extrabold px-4 py-2.5 rounded-xl whitespace-nowrap">
                                {{ $card['value'] }}
                            </span>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>


    {{-- ============ NOTES GRID ============ --}}
    <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-7">

        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl bg-[#dcfce7] text-[#15803d] flex items-center justify-center text-lg shrink-0">
                <i class="ti ti-checklist"></i>
            </div>
            <div>
                <h3 class="text-base font-extrabold text-[#0f172a] m-0 leading-snug">
                    Yang Perlu Diketahui
                </h3>
                <p class="text-xs text-[#64748b] mt-0.5 m-0">
                    Poin penting tentang kebijakan biaya Eventverse
                </p>
            </div>
        </div>

        @php
            $notes = [
                'Eventverse <strong class="text-[#0f172a]">gratis digunakan</strong> untuk penyelenggara.',
                'Tidak ada biaya pendaftaran maupun biaya bulanan.',
                'Biaya transaksi sepenuhnya <strong class="text-[#0f172a]">dibebankan kepada pembeli</strong> di setiap transaksi.',
                'Terdiri dari <strong class="text-[#0f172a]">Platform Fee Eventverse</strong> dan <strong class="text-[#0f172a]">Biaya Admin Payment Gateway</strong>.',
                '<strong class="text-[#0f172a]">Platform Fee Eventverse sudah termasuk PPN.</strong>',
                '<strong class="text-[#0f172a]">Pajak Hiburan (PBJT)</strong>, apabila berlaku, <strong class="text-[#0f172a]">belum termasuk</strong> dalam biaya transaksi.',
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
            @foreach($notes as $note)
                <div class="flex items-start gap-2.5 p-3 rounded-xl bg-[#f8fafc] border border-[#f1f5f9] hover:border-[#c2dcff] hover:bg-[#f8fbff] transition-all">
                    <div class="w-5 h-5 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center text-[10px] shrink-0 mt-0.5">
                        <i class="ti ti-check"></i>
                    </div>
                    <span class="text-sm text-[#475569] leading-relaxed">{!! $note !!}</span>
                </div>
            @endforeach
        </div>

    </div>

</div>
</section>


{{-- ==================== SIMULATION ==================== --}}
<section id="simulasi-pembayaran" class="bg-white border-y border-[#e2e8f0] py-10 sm:py-12">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center max-w-2xl mx-auto mb-6">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#ebf3ff] text-[#2282ff] text-[11px] font-bold uppercase tracking-wider mb-3">
            <i class="ti ti-calculator"></i>
            <span>Simulasi</span>
        </div>
        <h2 class="text-lg sm:text-xl font-extrabold text-[#0f172a] m-0 mb-1.5">
            Contoh Perhitungan Biaya Transaksi
        </h2>
        <p class="text-sm text-[#64748b] m-0 leading-relaxed">
            Ilustrasi bagaimana biaya dibebankan ke pembeli, bukan ke penyelenggara.
        </p>
    </div>

    <div class="max-w-5xl mx-auto">

        <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] overflow-hidden">

            {{-- Header --}}
            <div class="p-5 sm:p-6 bg-gradient-to-br from-[#ebf3ff] to-white border-b border-[#e2e8f0]">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#2282ff] text-white text-[10px] font-extrabold tracking-wider uppercase">
                    <i class="ti ti-bulb"></i>
                    Contoh Kasus
                </span>

                <h3 class="text-base sm:text-lg font-extrabold text-[#0f172a] mt-3 mb-1.5">
                    Smart Education — LKTIN
                </h3>
                <p class="text-sm text-[#64748b] m-0 leading-relaxed">
                    Event <strong class="text-[#0f172a]">Lomba Karya Tulis Ilmiah</strong> dengan harga tiket <strong class="text-[#0f172a]">Rp50.000</strong> per tiket.
                </p>
            </div>

            {{-- Table --}}
            <div class="p-5 sm:p-6">
                <div class="flex flex-col divide-y divide-[#f0f2f6]">
                    <div class="flex justify-between items-center gap-4 py-3 first:pt-0 text-sm">
                        <span class="text-[#64748b]">Harga Tiket</span>
                        <strong class="text-[#0f172a]">Rp50.000</strong>
                    </div>
                    <div class="flex justify-between items-center gap-4 py-3 text-sm">
                        <span class="text-[#64748b]">Jumlah Tiket Dibeli</span>
                        <strong class="text-[#0f172a]">2 Tiket</strong>
                    </div>
                    <div class="flex justify-between items-center gap-4 py-3 text-sm">
                        <span class="text-[#64748b]">Total Harga Tiket</span>
                        <strong class="text-[#0f172a]">Rp100.000</strong>
                    </div>
                    <div class="flex justify-between items-center gap-4 py-3 text-sm">
                        <span class="text-[#64748b]">Metode Pembayaran</span>
                        <strong class="text-[#0f172a]">QRIS</strong>
                    </div>
                    <div class="flex justify-between items-center gap-4 py-3 text-sm">
                        <span class="text-[#64748b]">Biaya Transaksi (3%)</span>
                        <strong class="text-rose-500">+ Rp3.000</strong>
                    </div>
                    <div class="flex justify-between items-center gap-4 py-3.5 last:pb-0 bg-[#ebf3ff] -mx-5 sm:-mx-6 px-5 sm:px-6 mt-2 rounded-lg">
                        <span class="text-sm font-bold text-[#0f172a]">Total Dibayar Pembeli</span>
                        <strong class="text-base font-extrabold text-[#2282ff]">Rp103.000</strong>
                    </div>
                </div>
            </div>

            {{-- Info: Dana Penyelenggara --}}
            <div class="px-5 sm:px-6 pb-5 sm:pb-6">
                <div class="p-4 rounded-xl bg-[#ecfdf5] border border-[#a7f3d0] mb-3">
                    <div class="flex items-center gap-2 mb-1.5">
                        <i class="ti ti-wallet text-[#15803d] text-base"></i>
                        <h4 class="text-sm font-bold text-[#065f46] m-0">Dana Diterima Penyelenggara</h4>
                    </div>
                    <p class="text-xs text-[#065f46] m-0 mb-2 leading-relaxed">
                        Tanpa potongan apapun — penyelenggara menerima dana penuh dari harga tiket:
                    </p>
                    <div class="text-xl font-extrabold text-[#15803d]">Rp100.000</div>
                </div>

                <div class="p-4 rounded-xl bg-[#f8fafc] border border-[#e2e8f0]">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="ti ti-info-circle text-[#64748b] text-base"></i>
                        <h4 class="text-sm font-bold text-[#0f172a] m-0">Informasi Penting</h4>
                    </div>
                    <ul class="list-disc pl-5 m-0 flex flex-col gap-1.5 text-xs text-[#475569] leading-relaxed">
                        <li>Biaya transaksi dibebankan kepada pembeli.</li>
                        <li>Sudah mencakup <strong class="text-[#0f172a]">Platform Fee Eventverse</strong> dan <strong class="text-[#0f172a]">Biaya Admin Payment Gateway</strong>.</li>
                        <li>Platform Fee Eventverse <strong class="text-[#0f172a]">sudah termasuk PPN</strong>.</li>
                        <li>Pajak Hiburan (PBJT) <strong class="text-[#0f172a]">belum termasuk</strong>.</li>
                    </ul>
                </div>
            </div>

            {{-- CTA --}}
            <div class="px-5 sm:px-6 pb-5 sm:pb-6 text-center">
                <a href="/register"
                   class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-[#2282ff] text-white text-sm font-bold shadow-[0_4px_14px_rgba(34,130,255,0.3)] hover:bg-[#1b6cd6] hover:-translate-y-0.5 transition-all">
                    <i class="ti ti-rocket text-base"></i>
                    <span>Mulai Gratis</span>
                </a>
            </div>

        </div>

    </div>
</div>
</section>


{{-- ==================== FAQ ==================== --}}
<section class="bg-[#f8fafc] py-10 sm:py-12">
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center mb-6">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#ebf3ff] text-[#2282ff] text-[11px] font-bold uppercase tracking-wider mb-3">
            <i class="ti ti-help-circle"></i>
            <span>FAQ</span>
        </div>
        <h2 class="text-lg sm:text-xl font-extrabold text-[#0f172a] m-0 mb-1.5">
            Pertanyaan yang Sering Diajukan
        </h2>
        <p class="text-sm text-[#64748b] m-0 leading-relaxed">
            Beberapa pertanyaan umum seputar kebijakan biaya di Eventverse.
        </p>
    </div>

    @php
        $faqs = [
            [
                'q' => 'Apakah Eventverse benar-benar gratis digunakan?',
                'a' => 'Ya. Eventverse dapat digunakan secara gratis tanpa biaya pendaftaran maupun biaya berlangganan.',
            ],
            [
                'q' => 'Apakah Eventverse memotong dana hasil penjualan tiket?',
                'a' => 'Tidak. Eventverse tidak memotong dana dari harga tiket. Penyelenggara menerima dana penuh dari harga tiket yang dijual.',
            ],
            [
                'q' => 'Siapa yang membayar biaya transaksi?',
                'a' => 'Biaya transaksi sepenuhnya dibebankan kepada pembeli, ditambahkan secara otomatis saat checkout sesuai metode pembayaran yang dipilih.',
            ],
            [
                'q' => 'Apa saja yang termasuk biaya transaksi?',
                'a' => 'Biaya transaksi terdiri dari Platform Fee Eventverse dan Biaya Admin Payment Gateway.',
            ],
        ];
    @endphp

    <div class="space-y-3" x-data="{ open: 0 }">

        @foreach($faqs as $i => $faq)
            <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_2px_12px_-2px_rgba(15,23,42,0.04)] overflow-hidden transition-all"
                 :class="open === {{ $i }} && 'border-[#c2dcff] shadow-[0_8px_24px_-6px_rgba(34,130,255,0.12)]'">

                <button type="button"
                        @click="open = (open === {{ $i }} ? null : {{ $i }})"
                        class="w-full flex items-center justify-between gap-4 px-5 sm:px-6 py-4 sm:py-5 text-left bg-transparent border-0 cursor-pointer hover:bg-[#f8fafc] transition-colors">
                    <span class="text-sm sm:text-base font-bold text-[#0f172a] leading-snug">
                        {{ $faq['q'] }}
                    </span>
                    <i class="ti ti-chevron-down text-lg text-[#64748b] transition-transform duration-300 shrink-0"
                       :class="open === {{ $i }} && 'rotate-180 text-[#2282ff]'"></i>
                </button>

                <div x-show="open === {{ $i }}"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     x-cloak
                     class="border-t border-[#f1f5f9]">
                    <p class="px-5 sm:px-6 py-4 text-sm text-[#64748b] leading-relaxed m-0">
                        {{ $faq['a'] }}
                    </p>
                </div>

            </div>
        @endforeach

    </div>

</div>
</section>


{{-- ==================== CTA ==================== --}}
<section class="bg-[#f8fafc] pb-10 sm:pb-12">
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="relative overflow-hidden bg-gradient-to-br from-[#2282ff] to-[#02559b] rounded-2xl shadow-[0_10px_30px_-8px_rgba(34,130,255,0.4)] p-6 sm:p-8 text-center">

        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full bg-white/5 blur-2xl"></div>
            <div class="absolute -bottom-16 -left-16 w-52 h-52 rounded-full bg-white/5 blur-2xl"></div>
        </div>

        <div class="relative">

            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur text-white text-[11px] font-bold border border-white/20 mb-4">
                <i class="ti ti-confetti"></i>
                <span>Siap Memulai?</span>
            </div>

            <h2 class="text-lg sm:text-xl font-extrabold text-white m-0 leading-snug">
                Kelola Event Lebih Mudah Bersama Eventverse
            </h2>

            <p class="mt-3 text-xs sm:text-sm text-white/80 max-w-lg mx-auto leading-relaxed">
                Mulai membuat event secara gratis, kelola peserta, ticketing, pembayaran online,
                QR Code Check-in, sertifikat digital, hingga dashboard analitik dalam satu platform.
            </p>

            <div class="flex flex-col sm:flex-row gap-2.5 justify-center mt-5">
                <a href="/register"
                   class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-white text-[#2282ff] text-sm font-bold shadow-sm hover:-translate-y-0.5 hover:shadow-[0_8px_20px_rgba(0,0,0,0.15)] transition-all">
                    <i class="ti ti-rocket text-base"></i>
                    <span>Mulai Gratis</span>
                </a>

                <a href="/about-us"
                   class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-white/10 backdrop-blur border border-white/25 text-white text-sm font-bold hover:bg-white/20 transition-all">
                    <i class="ti ti-info-circle text-base"></i>
                    <span>Pelajari Eventverse</span>
                </a>
            </div>

        </div>
    </div>

    {{-- Disclaimer --}}
    <div class="mt-5 p-4 rounded-xl bg-white border border-[#e2e8f0]">
        <p class="text-xs text-[#64748b] leading-relaxed m-0">
            <strong class="text-[#475569]">Catatan:</strong>
            Informasi biaya transaksi pada halaman ini dapat berubah sewaktu-waktu mengikuti kebijakan
            penyedia payment gateway, perubahan regulasi perpajakan, maupun pengembangan layanan Eventverse.
            Besaran Pajak Hiburan (PBJT), apabila berlaku, mengikuti ketentuan pemerintah daerah
            sesuai lokasi penyelenggaraan event.
        </p>
    </div>

</div>
</section>

@endsection