@extends('layouts.app')

@section('title', 'Panduan - Eventverse.id')
@section('meta_description', 'Panduan lengkap event creator dan pengguna Eventverse.id — dari registrasi, membuat event, hingga mendaftar sebagai peserta.')

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
                <i class="ti ti-book"></i>
                <span>Panduan</span>
            </div>

            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#0f172a] tracking-tight leading-[1.15] m-0">
                Panduan
                <span class="text-[#2282ff]">Eventverse</span>
            </h1>

            <p class="mt-4 text-sm sm:text-base text-[#64748b] leading-relaxed">
                Panduan lengkap untuk <strong class="text-[#0f172a]">event creator</strong>
                dan <strong class="text-[#0f172a]">pengguna</strong> Eventverse.id — mulai dari registrasi
                sampai siap menyelenggarakan atau mengikuti event.
            </p>

        </div>
    </div>
</section>


{{-- ==================== MAIN TIMELINE ==================== --}}
<section class="bg-[#f8fafc] py-10 sm:py-12">
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    @php
        $steps = [
            [
                'title' => 'Registrasi',
                'icon' => 'ti ti-user-plus',
                'items' => [
                    'Untuk event creator pastikan kamu punya akun di eventverse, jika belum punya bisa <a href="/register" class="text-[#2282ff] font-bold hover:underline">registrasi di sini</a>, kamu bisa membuat event atas nama individu atau organisasi. Jika atas nama organisasi kamu bisa menambahkan data organisasi di profil.',
                    'Login menggunakan email dan password yang telah terdaftar.',
                    'Pengguna akan menerima email verifikasi dan diarahkan untuk mengklik tautan dalam email tersebut untuk mengaktifkan akun yang sudah di daftarkan.',
                    'Setting profil kamu yaitu termasuk menambahkan foto profil, mengisi biodata, dan rekening (Jika bukan event creator bisa kosongkan kolom rekening).',
                    'Pada <strong>menu organisasi</strong> kamu bisa membuat organisasi baru, gabung organisasi, menambahkan anggota, menetapkan peran dan tanggung jawab, serta mengelola event yang diselenggarakan oleh organisasi tersebut.',
                ],
                'video' => 'https://youtu.be/7PKrnsQUx90',
            ],
            [
                'title' => 'Create Event',
                'icon' => 'ti ti-plus',
                'items' => [
                    'Masuk ke Akun kamu: Langkah pertama untuk memulai adalah masuk ke akun eventverse.id kamu, login dengan email dan password yang telah terdaftar.',
                    'Navigasi ke Dashboard: setelah berhasil login, kamu akan diarahkan ke dashboard utama. Di sini, kamu dapat melihat menu <strong>manajemen event</strong> untuk membuat event baru.',
                    'Ikuti langkah demi langkah form untuk membuat event baru, termasuk mengisi detail acara seperti judul, deskripsi, tiket pendaftaran, tanggal, waktu, lokasi, dan formulir pendaftaran event. Kamu juga akan diajarkan cara mengunggah gambar atau poster acara untuk menarik perhatian peserta.',
                    'Atur <strong>tiket pendaftaran</strong> seperti deskripsi tiket pendaftaran, berbayar atau gratis, serta batasan jumlah peserta. Selain itu buat juga <strong>formulir</strong> yang diperlukan untuk pendaftaran event.',
                    'Promosikan event dengan berbagi link menggunakan fitur promosi seperti QR code dan menu share event untuk meningkatkan visibilitas acara.',
                    'Setelah posting, kelola event yang telah dipublikasikan, Ini mencakup cara memperbarui informasi acara, tiket registrasi, formulir, kelola data peserta, kelola uang pembayaran masuk dan memantau pendaftaran secara real-time pada dashboard.',
                ],
                'video' => 'https://youtu.be/igdg2VMQjn0',
            ],
            [
                'title' => 'Management Event',
                'icon' => 'ti ti-settings',
                'items' => [
                    'Buka menu <strong>manajemen event</strong> untuk memperbarui informasi event setelah dipublikasikan, ini mencakup mengubah detail acara seperti judul, deskripsi, tanggal, waktu, dan lokasi, serta cara memberikan pembaruan kepada peserta yang telah terdaftar.',
                    'Pada menu <strong>manajemen event</strong> juga terdapat menu untuk kelola tiket pendaftaran, menu ini bisa membuat tiket baru (berbayar, gratis, dsb), mengatur kuota tiket, serta mengelola pembatalan atau perubahan tiket.',
                    'Dalam menu <strong>manajemen event</strong> juga terdapat menu edit formulir untuk membuat dan menyesuaikan formulir pendaftaran. Kamu bisa menambahkan formulir yang relevan untuk peserta, membuat kolom isian wajib, dan mengumpulkan informasi penting dari peserta.',
                    'Untuk mengakses dan melihat data peserta yang telah mendaftar event, kamu bisa akses ke menu <strong>data peserta</strong> untuk menampilkan data peserta dalam berbagai format dan memfilter informasi yang dibutuhkan, serta melihat pembayaran yang digunakan.',
                    'Download Data Peserta: kamu bisa untuk mengunduh data peserta dalam format excel digunakan untuk analisis lebih lanjut atau keperluan administrasi pada <strong>menu data peserta</strong>.',
                    'Pencairan dana event: untuk mencairkan dana yang diperoleh dari penjualan tiket dan pembayaran lainnya kamu bisa akses ke menu <strong>laporan transaksi</strong>.',
                ],
                'video' => 'https://youtu.be/CKDndwnmPk0',
            ],
            [
                'title' => 'Manajemen Artikel',
                'icon' => 'ti ti-article',
                'intro' => 'Tidak hanya menyediakan platform untuk mengelola event, tetapi eventverse.id juga memungkinkan user menulis dan mengelola artikel untuk berbagai keperluan seperti pengumuman, berita, dan sebagainya.',
                'items' => [
                    'Buka menu manajemen artikel untuk mengelola artikel kamu.',
                    'Pada menu <strong>manajemen artikel</strong> kamu bisa menulis artikel, mulai dari menentukan judul yang menarik, menulis konten informatif, hingga menambahkan gambar atau media lain yang relevan. Selain itu bisa memperbarui artikel atau menghapus artikel yang kamu buat.',
                ],
                'video' => 'https://youtu.be/rquCGbrnzqI',
            ],
            [
                'title' => 'Mendaftar Event (Peserta)',
                'icon' => 'ti ti-ticket',
                'items' => [
                    'Untuk registrasi atau membeli tiket event di eventverse.id tidak harus punya akun, kamu bisa registrasi event dengan akun atau tanpa akun.',
                    'Cari event: cari event yang kamu suka di halaman utama atau melalui fitur pencarian, filter supaya hasilnya relevan dengan yang kamu cari.',
                    'Pahami detail event: kamu harus paham tentang informasi penting terkait event, seperti penyelenggara, syarat dan ketentuan, kategori event, jadwal, dan hadiah. Ini bertujuan untuk memastikan peserta mengetahui semua informasi yang dibutuhkan sebelum mendaftar.',
                    'Registrasi: setelah memahami detail event, registrasi event pada tiket pendaftaran yang tersedia, isikan detail informasi atau formulir yang dibutuhkan untuk event tersebut.',
                    'Pembayaran biaya registrasi: lakukan pembayaran biaya registrasi (jika ada) dengan <strong>berbagai metode pembayaran</strong> yang tersedia setelah submit data pendaftaran.',
                    'Konfirmasi pendaftaran: setelah sukses melakukan pendaftaran kamu akan <strong>menerima email</strong> konfirmasi yang berisi status pendaftaran, kode pendaftaran, beserta informasi lainnya.',
                    'Persiapan dan partisipasi: Untuk event offline persiapkan diri sebelum lomba, termasuk jadwal pelaksanaan, persiapan teknis, dan aturan yang harus diikuti selama lomba.',
                ],
                'video' => 'https://youtu.be/u2ewB5TRY0o',
            ],
        ];
    @endphp

    {{-- ============ TIMELINE ============ --}}
    <div class="relative">

        {{-- Vertical line --}}
        <div class="hidden sm:block absolute left-[23px] top-2 bottom-2 w-0.5 bg-gradient-to-b from-[#2282ff] via-[#60a5fa] to-[#c2dcff]"></div>

        <div class="space-y-5">

            @foreach($steps as $index => $step)
                <div class="relative sm:pl-16">

                    {{-- Step Number Circle --}}
                    <div class="hidden sm:flex absolute left-0 top-0 w-12 h-12 rounded-2xl bg-white border-2 border-[#2282ff] shadow-[0_4px_14px_rgba(34,130,255,0.2)] items-center justify-center text-[#2282ff] text-lg font-extrabold shrink-0 z-10">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </div>

                    {{-- Card --}}
                    <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] overflow-hidden">

                        {{-- Card Header --}}
                        <div class="flex items-start gap-3.5 p-5 sm:p-6 border-b border-[#f1f5f9]">
                            <div class="sm:hidden w-10 h-10 rounded-xl bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center text-lg shrink-0">
                                <i class="{{ $step['icon'] }}"></i>
                            </div>
                            <div class="hidden sm:flex w-10 h-10 rounded-xl bg-[#ebf3ff] text-[#2282ff] items-center justify-center text-lg shrink-0">
                                <i class="{{ $step['icon'] }}"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-[10px] font-extrabold tracking-[0.08em] text-[#94a3b8] uppercase mb-0.5">
                                    Langkah {{ $index + 1 }}
                                </div>
                                <h2 class="text-base sm:text-lg font-extrabold text-[#0f172a] m-0 leading-snug">
                                    {{ $step['title'] }}
                                </h2>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="p-5 sm:p-6">

                            @if(!empty($step['intro']))
                                <p class="text-sm text-[#475569] leading-relaxed mb-4 m-0">
                                    {{ $step['intro'] }}
                                </p>
                            @endif

                            <ol class="list-none p-0 m-0 flex flex-col gap-3">
                                @foreach($step['items'] as $item)
                                    <li class="flex items-start gap-3 text-sm text-[#475569] leading-relaxed">
                                        <div class="w-6 h-6 rounded-lg bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center text-[11px] font-bold shrink-0 mt-0.5">
                                            {{ $loop->iteration }}
                                        </div>
                                        <span class="flex-1">{!! $item !!}</span>
                                    </li>
                                @endforeach
                            </ol>

                            @if(!empty($step['video']))
                                <div class="mt-5 pt-5 border-t border-[#f1f5f9]">
                                    <a href="{{ $step['video'] }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-br from-[#dc2626] to-[#b91c1c] text-white text-sm font-bold shadow-[0_4px_14px_rgba(220,38,38,0.3)] hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(220,38,38,0.4)] transition-all">
                                        <i class="ti ti-player-play text-base"></i>
                                        <span>Lihat Video Tutorial</span>
                                    </a>
                                </div>
                            @endif

                        </div>

                    </div>

                </div>
            @endforeach

            {{-- ============ DONE CARD ============ --}}
            <div class="relative sm:pl-16">
                <div class="hidden sm:flex absolute left-0 top-0 w-12 h-12 rounded-2xl bg-gradient-to-br from-[#16a34a] to-[#15803d] text-white shadow-[0_4px_14px_rgba(22,163,74,0.35)] items-center justify-center text-xl shrink-0 z-10">
                    <i class="ti ti-check"></i>
                </div>

                <div class="relative overflow-hidden bg-gradient-to-br from-[#2282ff] to-[#02559b] rounded-2xl shadow-[0_10px_30px_-8px_rgba(34,130,255,0.4)] p-6 sm:p-8 text-center">

                    <div class="pointer-events-none absolute inset-0 overflow-hidden">
                        <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full bg-white/5 blur-2xl"></div>
                        <div class="absolute -bottom-16 -left-16 w-52 h-52 rounded-full bg-white/5 blur-2xl"></div>
                    </div>

                    <div class="relative">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur text-white text-[11px] font-bold border border-white/20 mb-3">
                            <i class="ti ti-confetti"></i>
                            <span>Done!</span>
                        </div>

                        <h2 class="text-lg sm:text-xl font-extrabold text-white m-0 leading-snug">
                            Selamat! Kamu Siap Memulai
                        </h2>

                        <p class="mt-3 text-xs sm:text-sm text-white/85 max-w-lg mx-auto leading-relaxed">
                            Kamu sudah bisa menjadi <strong>event creator</strong> atau <strong>peserta event</strong>
                            di Eventverse.id. Mulai buat event pertamamu, atau jelajahi event menarik
                            yang tersedia di platform kami.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-2.5 justify-center mt-5">
                            <a href="/dashboard"
                               class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-white text-[#2282ff] text-sm font-bold shadow-sm hover:-translate-y-0.5 hover:shadow-[0_8px_20px_rgba(0,0,0,0.15)] transition-all">
                                <i class="ti ti-plus text-base"></i>
                                <span>Buat Event</span>
                            </a>

                            <a href="/search"
                               class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-white/10 backdrop-blur border border-white/25 text-white text-sm font-bold hover:bg-white/20 transition-all">
                                <i class="ti ti-search text-base"></i>
                                <span>Cari Event</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>
</section>

@endsection