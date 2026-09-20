@extends('layouts.app')

@section('title', 'FAQ - Eventverse.id')
@section('meta_description', 'Pertanyaan yang sering diajukan tentang Eventverse.id - platform ticketing management service.')

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
                <i class="ti ti-help-circle"></i>
                <span>FAQ</span>
            </div>

            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#0f172a] tracking-tight leading-[1.15] m-0">
                Frequently Asked
                <span class="text-[#2282ff]">Questions</span>
            </h1>

            <p class="mt-4 text-sm sm:text-base text-[#64748b] leading-relaxed">
                Temukan jawaban atas pertanyaan yang paling sering diajukan tentang
                Eventverse.id dan layanan kami.
            </p>

        </div>
    </div>
</section>


{{-- ==================== FAQ LIST ==================== --}}
<section class="bg-[#f8fafc] py-10 sm:py-12">
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    @php
        $faqs = [
            [
                'q' => 'Apa itu Eventverse.id?',
                'a' => 'Eventverse adalah platform <strong>ticketing management service (TMS)</strong> yang dikelola oleh <strong>PT Satu Karya Teknologi</strong>. Kami bekerja sama dengan <strong>ILB Media (@info.lomba.beasiswa)</strong> untuk menyediakan solusi teknologi dalam mendukung penyelenggaraan event, mulai dari distribusi dan manajemen tiket pendaftaran hingga penyediaan laporan event secara efisien. Info selengkapnya <a href="/about-us" class="text-[#2282ff] font-bold hover:underline">about eventverse</a>.',
            ],
            [
                'q' => 'Apa saja layanan yang ditawarkan oleh Eventverse?',
                'a' => 'Eventverse menyediakan berbagai layanan terkait manajemen event, ticketing event, kelola data event, manajemen pendaftaran peserta, pembayaran terverifikasi, dan masih banyak lagi yang membuat eventmu terintegrasi. <a href="/about-us" class="text-[#2282ff] font-bold hover:underline">More info</a>.',
            ],
            [
                'q' => 'Apakah Eventverse.id dapat dipercaya?',
                'a' => 'Ya, Eventverse.id dikelola organisasi/perusahaan yang berbadan hukum dan dikelola oleh <strong>ILB Media (@info.lomba.beasiswa)</strong> serta menggunakan sistem pembayaran dari <strong>Midtrans (by Gojek)</strong> jadi tidak perlu diragukan keamanannya.',
            ],
            [
                'q' => 'Bagaimana cara menggunakan Eventverse.id sebagai penyelenggara event?',
                'a' => 'Kamu dapat mendaftarkan event di platform kami dan mengatur detailnya, termasuk jenis tiket yang akan dijual, harga tiket, jumlah tiket yang tersedia, dan informasi lainnya. Setelah itu, kamu bisa mempromosikan event kamu dan mengelola penjualan tiket melalui dashboard kami. <a href="/creator-guide" class="text-[#2282ff] font-bold hover:underline">Baca panduan</a>.',
            ],
            [
                'q' => 'Apakah Eventverse.id menyediakan layanan pembayaran online?',
                'a' => 'Ya, kami menyediakan integrasi dengan berbagai metode pembayaran online seperti transfer bank, Virtual Account (VA), E-Wallet, QRIS, dan metode pembayaran lain untuk memudahkan pembelian tiket bagi peserta event.',
            ],
            [
                'q' => 'Bagaimana cara mendapatkan laporan atau analisis setelah event selesai?',
                'a' => 'Setelah event selesai, Anda dapat mengakses report lengkap dengan mudah melalui dashboard kami. Laporan tersebut mencakup data penjualan tiket, kehadiran peserta, report data peserta, report data pembayaran, pencairan dana, dan informasi lainnya yang relevan untuk membantu kamu mengevaluasi kesuksesan event Anda.',
            ],
            [
                'q' => 'Apakah Eventverse.id memiliki dukungan pelanggan?',
                'a' => 'Ya, kami menyediakan dukungan pelanggan melalui berbagai saluran komunikasi seperti email dan chat. Tim kami siap membantu Anda dengan pertanyaan atau masalah apa pun yang Anda hadapi dalam menggunakan platform kami. <a href="/contact-us" class="text-[#2282ff] font-bold hover:underline">Hubungi kami</a>.',
            ],
            [
                'q' => 'Bagaimana keamanan data peserta yang menggunakan platform Eventverse?',
                'a' => 'Kami mengutamakan keamanan data peserta dan mengikuti praktik terbaik dalam pengelolaan data pribadi. Kami menggunakan enkripsi data dan memiliki <a href="/privacy-policy" class="text-[#2282ff] font-bold hover:underline">kebijakan privasi</a> yang ketat untuk melindungi informasi pribadi peserta ataupun penyelenggara.',
            ],
            [
                'q' => 'Apakah Eventverse menyediakan integrasi dengan platform lain seperti media sosial?',
                'a' => 'Ya, kami menyediakan integrasi dengan berbagai platform termasuk media sosial seperti Instagram untuk membantu kamu mempromosikan event secara lebih luas dan meningkatkan visibilitasnya. Akun yang kami kelola: <a href="http://instagram.com/eventconnect.id" target="_blank" class="text-[#2282ff] font-bold hover:underline">eventconnect</a> dan <a href="http://instagram.com/info.lomba.beasiswa" target="_blank" class="text-[#2282ff] font-bold hover:underline">ILB Media</a>.',
            ],
            [
                'q' => 'Apakah ada biaya atau komisi yang dikenakan oleh Eventverse?',
                'a' => 'Kamu bisa menyebarkan event secara gratis, kami hanya mengenakan biaya pada transaksi penjualan tiket atau komisi sesuai dengan layanan yang kamu gunakan. Detail tarif dan biaya akan dijelaskan saat kamu mendaftar dan menggunakan platform kami, atau bisa diakses melalui halaman <a href="/pricing" class="text-[#2282ff] font-bold hover:underline">biaya</a>.',
            ],
            [
                'q' => 'Bagaimana cara saya memulai menggunakan Eventverse untuk event saya?',
                'a' => 'Kamu dapat mulai dengan mendaftar di situs web kami dan mengikuti langkah-langkah pendaftaran event. Tim kami juga siap membantu kamu dalam proses ini jika diperlukan. <a href="/register" class="text-[#2282ff] font-bold hover:underline">Daftar sekarang!</a>',
            ],
        ];
    @endphp

    {{-- Accordion --}}
    <div class="space-y-3" x-data="{ open: 0 }">

        @foreach($faqs as $i => $faq)
            <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_2px_12px_-2px_rgba(15,23,42,0.04)] overflow-hidden transition-all"
                 :class="open === {{ $i }} && 'border-[#c2dcff] shadow-[0_8px_24px_-6px_rgba(34,130,255,0.12)]'">

                <button type="button"
                        @click="open = (open === {{ $i }} ? null : {{ $i }})"
                        class="w-full flex items-center gap-4 px-5 sm:px-6 py-4 sm:py-5 text-left bg-transparent border-0 cursor-pointer hover:bg-[#f8fafc] transition-colors">

                    {{-- Number badge --}}
                    <div class="w-8 h-8 rounded-lg bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center text-xs font-extrabold shrink-0"
                         :class="open === {{ $i }} && 'bg-[#2282ff] text-white'">
                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                    </div>

                    {{-- Question --}}
                    <span class="flex-1 text-sm sm:text-base font-bold text-[#0f172a] leading-snug">
                        {{ $faq['q'] }}
                    </span>

                    {{-- Chevron --}}
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
                    <div class="px-5 sm:px-6 py-4 text-sm text-[#475569] leading-relaxed">
                        {!! $faq['a'] !!}
                    </div>
                </div>

            </div>
        @endforeach

    </div>


    {{-- ============ CONTACT CARD ============ --}}
    <div class="mt-8">
        <div class="relative overflow-hidden bg-gradient-to-br from-[#2282ff] to-[#02559b] rounded-2xl shadow-[0_10px_30px_-8px_rgba(34,130,255,0.4)] p-6 sm:p-8 text-center">

            <div class="pointer-events-none absolute inset-0 overflow-hidden">
                <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full bg-white/5 blur-2xl"></div>
                <div class="absolute -bottom-16 -left-16 w-52 h-52 rounded-full bg-white/5 blur-2xl"></div>
            </div>

            <div class="relative">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur text-white text-[11px] font-bold border border-white/20 mb-4">
                    <i class="ti ti-message-circle"></i>
                    <span>Hubungi Kami</span>
                </div>

                <h2 class="text-lg sm:text-xl font-extrabold text-white m-0 leading-snug">
                    Masih Ada Pertanyaan?
                </h2>

                <p class="mt-3 text-xs sm:text-sm text-white/85 max-w-lg mx-auto leading-relaxed">
                    Apakah kamu memiliki pertanyaan, masukan, atau hanya ingin menyapa kami?
                    Jangan ragu untuk mengirim pesan kepada tim kami. Kami berusaha merespons setiap pesan secepat mungkin.
                </p>

                <div class="flex flex-col sm:flex-row gap-2.5 justify-center mt-5">
                    <a href="/contact-us"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-white text-[#2282ff] text-sm font-bold shadow-sm hover:-translate-y-0.5 hover:shadow-[0_8px_20px_rgba(0,0,0,0.15)] transition-all">
                        <i class="ti ti-send text-base"></i>
                        <span>Hubungi Sekarang</span>
                    </a>

                    <a href="/about-us"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-white/10 backdrop-blur border border-white/25 text-white text-sm font-bold hover:bg-white/20 transition-all">
                        <i class="ti ti-info-circle text-base"></i>
                        <span>Tentang Kami</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
</section>

@endsection