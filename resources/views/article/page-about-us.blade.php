@extends('layouts.app')

@section('title', 'Tentang Kami - Eventverse.id')
@section('meta_description', 'Eventverse.id adalah platform Event Management & Ticketing System untuk mengelola event secara profesional, efisien, dan terintegrasi.')

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

            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#ebf3ff] text-[#2282ff] text-xs font-semibold border border-[#2282ff]/20 mb-5">
                <i class="ti ti-info-circle"></i>
                <span>Tentang Kami</span>
            </div>

            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#0f172a] tracking-tight leading-[1.15] m-0">
                Tentang
                <span class="text-[#2282ff]">eventverse.id</span>
            </h1>

            <p class="mt-4 text-sm sm:text-base text-[#64748b] leading-relaxed">
                Platform Event Management & Ticketing System untuk membantu penyelenggara
                mengelola event secara lebih mudah, profesional, dan efisien.
            </p>

        </div>
    </div>
</section>


{{-- ==================== MAIN CONTENT ==================== --}}
<section class="bg-[#f8fafc] py-10 sm:py-12">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- ============ INTRO CARD ============ --}}
        <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-7">
            <div class="flex items-start gap-3.5 mb-4">
                <div class="w-10 h-10 rounded-xl bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center shrink-0">
                    <i class="ti ti-building-community text-lg"></i>
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-extrabold text-[#0f172a] m-0 leading-snug">
                        Siapa Kami
                    </h2>
                    <p class="text-xs text-[#64748b] mt-0.5 m-0">Kenali lebih dekat tentang eventverse.id</p>
                </div>
            </div>

            <div class="text-sm text-[#475569] leading-relaxed space-y-3">
                <p class="m-0">
                    <strong class="text-[#0f172a]">Eventverse.id</strong> adalah platform <em>Event Management & Ticketing System</em> yang dikembangkan oleh
                    <strong class="text-[#0f172a]">PT Satu Karya Teknologi</strong> dan dikelola bersama oleh
                    <strong class="text-[#0f172a]">ILB Media (Info Lomba & Beasiswa)</strong>.
                    Platform ini terintegrasi dengan berbagai layanan pembayaran digital terintegrasi untuk membantu
                    penyelenggara mengelola event secara lebih mudah, profesional, dan efisien.
                </p>

                <p class="m-0">
                    Eventverse menyediakan solusi teknologi yang mendukung seluruh proses penyelenggaraan event,
                    mulai dari publikasi acara, registrasi peserta, penjualan tiket online, pengelolaan pembayaran,
                    check-in peserta berbasis QR Code, hingga penyajian laporan dan analisis event secara real-time.
                </p>
            </div>
        </div>


        {{-- ============ FITUR UNGGULAN ============ --}}
        <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-7">
            <div class="flex items-start gap-3.5 mb-5">
                <div class="w-10 h-10 rounded-xl bg-[#ecfdf5] text-[#16a34a] flex items-center justify-center shrink-0">
                    <i class="ti ti-sparkles text-lg"></i>
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-extrabold text-[#0f172a] m-0 leading-snug">
                        Fitur Unggulan
                    </h2>
                    <p class="text-xs text-[#64748b] mt-0.5 m-0">Semua yang Anda butuhkan dalam satu platform</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                @php
                    $features = [
                        'Publikasi event dan informasi pendaftaran secara online.',
                        'Manajemen event, peserta, tiket, formulir registrasi, dan organisasi dalam satu dashboard.',
                        'Sistem pembayaran online dengan berbagai metode pembayaran yang mudah dan aman.',
                        'QR Code Ticketing dan sistem check-in peserta yang cepat dan akurat.',
                        'Dashboard laporan dan statistik event secara real-time.',
                        'Custom short link untuk halaman event.',
                        'Fitur berbagi event ke berbagai platform media sosial.',
                        'Manajemen artikel, pengumuman, dan informasi pendukung event.',
                        'Penerbitan sertifikat digital untuk peserta (jika diaktifkan oleh penyelenggara).',
                        'Berbagai fitur tambahan yang terus dikembangkan sesuai kebutuhan penyelenggara.',
                    ];
                @endphp

                @foreach($features as $feature)
                    <div class="flex items-start gap-2.5 p-3 rounded-xl bg-[#f8fafc] border border-[#f1f5f9] hover:border-[#c2dcff] hover:bg-[#ebf3ff]/40 transition-all">
                        <div class="w-5 h-5 rounded-full bg-[#dcfce7] text-[#166534] flex items-center justify-center text-[10px] shrink-0 mt-0.5">
                            <i class="ti ti-check"></i>
                        </div>
                        <span class="text-sm text-[#475569] leading-relaxed">{{ $feature }}</span>
                    </div>
                @endforeach
            </div>
        </div>


        {{-- ============ MENGAPA MEMILIH ============ --}}
        <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-7">
            <div class="flex items-start gap-3.5 mb-5">
                <div class="w-10 h-10 rounded-xl bg-[#fef3c7] text-[#b45309] flex items-center justify-center shrink-0">
                    <i class="ti ti-award text-lg"></i>
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-extrabold text-[#0f172a] m-0 leading-snug">
                        Mengapa Memilih Eventverse?
                    </h2>
                    <p class="text-xs text-[#64748b] mt-0.5 m-0">Alasan eventverse jadi partner terbaik event Anda</p>
                </div>
            </div>

            <div class="flex flex-col gap-2.5">
                @php
                    $reasons = [
                        'Membantu meningkatkan profesionalisme penyelenggaraan event melalui sistem yang terstruktur dan modern.',
                        'Mengelola registrasi peserta, ticketing, pembayaran, dan pelaporan dalam satu platform terintegrasi.',
                        'Mengurangi pekerjaan administratif dengan otomatisasi proses pendaftaran dan pengelolaan data peserta.',
                        'Mendukung berbagai metode pembayaran sehingga memudahkan peserta melakukan transaksi.',
                        'Meningkatkan kepercayaan peserta melalui sistem registrasi dan pembayaran yang lebih aman dan transparan.',
                        'Menyediakan data dan laporan event yang dapat digunakan untuk evaluasi dan pengambilan keputusan.',
                        'Cocok digunakan untuk seminar, workshop, webinar, pelatihan, kompetisi, konferensi, komunitas, maupun event perusahaan.',
                        'Dapat digunakan kapan saja dengan proses yang mudah, fleksibel, dan ramah bagi penyelenggara maupun peserta.',
                    ];
                @endphp

                @foreach($reasons as $reason)
                    <div class="flex items-start gap-3 p-3.5 rounded-xl border border-[#f1f5f9] hover:border-[#c2dcff] hover:bg-[#f8fbff] transition-all">
                        <div class="w-6 h-6 rounded-lg bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center text-xs shrink-0 mt-0.5 font-bold">
                            {{ $loop->iteration }}
                        </div>
                        <span class="text-sm text-[#475569] leading-relaxed">{{ $reason }}</span>
                    </div>
                @endforeach
            </div>
        </div>


        {{-- ============ CTA ============ --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-[#2282ff] to-[#02559b] rounded-2xl shadow-[0_10px_30px_-8px_rgba(34,130,255,0.4)] p-6 sm:p-8 text-center">

            {{-- Decorative dots --}}
            <div class="pointer-events-none absolute inset-0 overflow-hidden">
                <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full bg-white/5 blur-2xl"></div>
                <div class="absolute -bottom-16 -left-16 w-52 h-52 rounded-full bg-white/5 blur-2xl"></div>
            </div>

            <div class="relative">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur text-white text-[11px] font-bold border border-white/20 mb-4">
                    <i class="ti ti-rocket"></i>
                    <span>Mulai Sekarang</span>
                </div>

                <h3 class="text-lg sm:text-xl font-extrabold text-white m-0 leading-snug">
                    Fokus pada event Anda, sisanya biar kami urus.
                </h3>

                <p class="mt-2.5 text-xs sm:text-sm text-white/80 max-w-lg mx-auto leading-relaxed">
                    Eventverse membantu mengelola proses registrasi, ticketing, pembayaran,
                    dan pelaporan secara lebih efisien.
                </p>

                <div class="flex flex-col sm:flex-row gap-2.5 justify-center mt-5">
                    <a href="/creator-guide"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-white text-[#2282ff] text-sm font-bold shadow-sm hover:-translate-y-0.5 hover:shadow-[0_8px_20px_rgba(0,0,0,0.15)] transition-all">
                        <i class="ti ti-book text-base"></i>
                        <span>Panduan Pengguna</span>
                    </a>

                    <a href="/faq"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-white/10 backdrop-blur border border-white/25 text-white text-sm font-bold hover:bg-white/20 transition-all">
                        <i class="ti ti-help-circle text-base"></i>
                        <span>FAQ</span>
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
</section>

@endsection