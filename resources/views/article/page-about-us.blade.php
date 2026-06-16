@extends('layouts.main')

@section('content')
    {{-- Form Pencarian --}}

    <div class="header-wave">
        <!--Content before waves-->
        <div class="inner-header-search flex">
            <div class="wave-content w-100">
                <h1>Tentang EventHub</h1>
            </div>
        </div>
        <!--Waves end-->
    </div>

    <section class="container mt-0 pt-5 px-3">

<p class="text-article">
    <strong>EventHub Web ID</strong> adalah platform <em>Event Management & Ticketing System</em> yang dikembangkan oleh
    <strong>PT Konektivitas Tanpa Batas</strong> dan dikelola bersama oleh
    <strong>ILB Media (Info Lomba & Beasiswa)</strong>.
    Platform ini terintegrasi dengan berbagai layanan pembayaran digital untuk membantu
    penyelenggara mengelola event secara lebih mudah, profesional, dan efisien.
</p>

<p class="text-article">
    EventHub menyediakan solusi teknologi yang mendukung seluruh proses penyelenggaraan event,
    mulai dari publikasi acara, registrasi peserta, penjualan tiket online, pengelolaan pembayaran,
    check-in peserta berbasis QR Code, hingga penyajian laporan dan analisis event secara real-time.
</p>

<h5 class="mt-5 mb-3">Fitur Unggulan EventHub</h5>

<div class="text-article">
    <ul>
        <li class="mb-2">Publikasi event dan informasi pendaftaran secara online.</li>
        <li class="mb-2">Manajemen event, peserta, tiket, formulir registrasi, dan organisasi dalam satu dashboard.</li>
        <li class="mb-2">Sistem pembayaran online dengan berbagai metode pembayaran yang mudah dan aman.</li>
        <li class="mb-2">QR Code Ticketing dan sistem check-in peserta yang cepat dan akurat.</li>
        <li class="mb-2">Dashboard laporan dan statistik event secara real-time.</li>
        <li class="mb-2">Custom short link untuk halaman event.</li>
        <li class="mb-2">Fitur berbagi event ke berbagai platform media sosial.</li>
        <li class="mb-2">Manajemen artikel, pengumuman, dan informasi pendukung event.</li>
        <li class="mb-2">Penerbitan sertifikat digital untuk peserta (jika diaktifkan oleh penyelenggara).</li>
        <li class="mb-2">Berbagai fitur tambahan yang terus dikembangkan sesuai kebutuhan penyelenggara.</li>
    </ul>
</div>

<h5 class="mt-5 mb-3">Mengapa Memilih EventHub?</h5>

<div class="text-article">
    <ul>
        <li class="mb-2">
            Membantu meningkatkan profesionalisme penyelenggaraan event melalui sistem yang terstruktur dan modern.
        </li>

        <li class="mb-2">
            Mengelola registrasi peserta, ticketing, pembayaran, dan pelaporan dalam satu platform terintegrasi.
        </li>

        <li class="mb-2">
            Mengurangi pekerjaan administratif dengan otomatisasi proses pendaftaran dan pengelolaan data peserta.
        </li>

        <li class="mb-2">
            Mendukung berbagai metode pembayaran sehingga memudahkan peserta melakukan transaksi.
        </li>

        <li class="mb-2">
            Meningkatkan kepercayaan peserta melalui sistem registrasi dan pembayaran yang lebih aman dan transparan.
        </li>

        <li class="mb-2">
            Menyediakan data dan laporan event yang dapat digunakan untuk evaluasi dan pengambilan keputusan.
        </li>

        <li class="mb-2">
            Cocok digunakan untuk seminar, workshop, webinar, pelatihan, kompetisi, konferensi, komunitas, maupun event perusahaan.
        </li>

        <li class="mb-2">
            Dapat digunakan kapan saja dengan proses yang mudah, fleksibel, dan ramah bagi penyelenggara maupun peserta.
        </li>
    </ul>
</div>

<div class="mt-4">
    <p class="text-article">
        Fokus pada pengembangan event Anda, sementara EventHub membantu mengelola proses registrasi,
        ticketing, pembayaran, dan pelaporan secara lebih efisien.
    </p>
</div>

<h5 class="mt-4">Mulai Sekarang</h5>

<div class="mt-3">
    <a href="/creator-guide" class="btn btn-success">
        <i class="fas fa-book-open"></i> Panduan Pengguna
    </a>

    <a href="/faq" class="btn btn-info">
        <i class="fas fa-question-circle"></i> FAQ
    </a>
</div>

</section>

@endsection
