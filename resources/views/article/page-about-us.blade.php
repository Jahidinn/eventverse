@extends('layouts.main')

@section('content')
    {{-- Form Pencarian --}}

    <div class="header-wave">
        <!--Content before waves-->
        <div class="inner-header-search flex">
            <div class="wave-content w-100">
                <h1>Tentang Eventconnect.id</h1>
            </div>
        </div>
        <!--Waves end-->
    </div>

    <section class="container mt-0 pt-5 px-3">
        <p class="text-article">
            <b>Eventconnect.id</b> merupakan platform Ticketing Management Service (TMS) didirikan oleh <b>PT Konektivitas
                Tanpa Batas</b> dan dikelola oleh <b>ILB media</b> (@Info.lomba.beasiswa) serta menggunakan sistem
            pembayaran yang terkoneksi dengan midtrans (by gojek). <b>eventconnect.id</b> menyediakan solusi
            teknologi dalam mendukung penyelenggaraan event mulai dari distribusi tiket, manajemen pendaftaran, pembayaran,
            hingga penyediaan report/laporan akhir event.
        </p>


        {{-- Yang bisa dilakukan eventconnect.id --}}
        <h5 class="mt-4 mb-3">Apa yang bisa dilakukan platform eventconnect.id?</h5>
        <div class="text-article">
            <ul>
                <li class="mb-1">Melakukan distribusi informasi event sekaligus tiket pendaftaran</li>
                <li class="mb-1">Manajemen sistem pembayaran yang beragam bagi peserta dan penyelenggara event.</li>
                <li class="mb-1">Menyediakan report dokumen laporan penyelenggaraan event.</li>
                <li class="mb-1">Fitur checkin peserta event.</li>
                <li class="mb-1">an masih banyak fitur lainya, <a href="/dashboard">Lihat fitur</a></li>
            </ul>
        </div>

        {{-- Alasan menggunakan eventconnect.id --}}
        <h5 class="mt-4">Kenapa harus eventconnect.id?</h5>
        <div class="mb-3">
            <ul class="text-article">
                <li class="mb-1">Event kamu bisa jadi lebih keren & profesional! </li>
                <li class="mb-1">Manajemen sistem pendaftaran, ticketing, pembayaran, & report data yang lebih baik.</li>
                <li class="mb-1">Tidak perlu urusin data peserta, kita yang urus!</li>
                <li class="mb-1">Tidak perlu urus masalaah pembayaran, kita yang urus!</li>
                <li class="mb-1">Meningkatkan kepercayaan peserta!</li>
                <li class="mb-1">Buat artikel, pengumuman, dan sebagainya dari menu manajemen artikel FREE!</li>
                <li class="mb-1">Yang pasti kamu bisa menggunkanan platform eventconect.id kapanpun dan <span
                        class="text-success"><b>GRATIS!</b></span>
                </li>
            </ul>
        </div>
        <p class="mt-3">Jadikan event kamu lebih keren dengan <b>eventconnect.id</b> sob!</p>
        <h5>Bagaimana caranya?</h5>
        <div>
            <a href="/creator-guide" class="btn btn-success"><i class="fas fa-file-alt"></i> Baca panduan</a>
            <a href="/faq" class="btn btn-info"><i class="fas fa-file-alt"></i> Frequently Asked Question</a>
        </div>
    </section>
@endsection
