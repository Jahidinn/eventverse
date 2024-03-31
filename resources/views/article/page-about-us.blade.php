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
        <p>
            <b>Eventconnect.id</b> merupakan platform Ticketing Management Service (TMS) dibawah naungan <b>PT Konektivitas
                Tanpa Batas</b> dan yang bekerja sama dengan <b>ILB media</b> (@Info.lomba.beasiswa) yang menyediakan solusi
            teknologi dalam mendukung penyelenggaraan event mulai dari distribusi dan manajemen tiket pendaftaran, hingga
            penyediaan report/laporan event.
        </p>


        {{-- Yang bisa dilakukan eventconnect.id --}}
        <h5 class="mt-4 mb-3">Apa yang bisa dilakukan platform eventconnect.id?</h5>
        <div>
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
            <ul>
                <li class="mb-1">Event kamu bisa jadi lebih keren & profesional! </li>
                <li class="mb-1">Manajemen sistem pendaftaran, ticketing, dan report data event lebih baik.</li>
                <li class="mb-1">Tidak perlu urusin data peserta, kita yang urus!</li>
                <li class="mb-1">Tidak perlu urus masalaah pembayaran, kita yang urus!</li>
                <li class="mb-1">Meningkatkan kepercayaan peserta!</li>
                <li class="mb-1">Yang pasti kamu bisa menggunkanan platform eventconect.id kapanpun dan <span
                        class="text-success"><b>GRATIS!</b></span>
                </li>
            </ul>
        </div>
        <p class="mt-3">Jadikan event kamu lebih keren dengan <b>eventconnect.id</b> sob!</p>
        <h5>Bagaimana caranya?</h5>
        <div>

            <a href="/blog/creator-guide" class="btn btn-success"><i class="fas fa-file-alt"></i> Baca panduan</a>
        </div>
    </section>
@endsection
