@extends('layouts.main')

@section('content')
    {{-- Form Pencarian --}}

    <div class="header-wave">
        <!--Content before waves-->
        <div class="inner-header-search flex">
            <div class="wave-content w-100">
                <h1>Tentang eventhub.web.id</h1>
            </div>
        </div>
        <!--Waves end-->
    </div>

    <section class="container mt-0 pt-5 px-3">
        <p class="text-article">
            <b>Eventhub</b> merupakan platform web ticketing management service (TMS) didirikan oleh <b>PT Konektivitas
                Tanpa Batas</b> dan dikelola oleh <b>ILB media</b> (@Info.lomba.beasiswa) serta terintegrasi dengan sistem
            pembayaran midtrans (by gojek). <b>eventhub.web.id</b> menyediakan solusi
            teknologi dalam mendukung penyelenggaraan event mulai dari publikasi event, distribusi tiket pendaftaran, manajemen pendaftaran, pembayaran,
            hingga penyediaan report/laporan akhir event.
        </p>


        {{-- Yang bisa dilakukan eventconnect.id --}}
        <h5 class="mt-4 mb-3">Apa aja fitur web eventhub.web.id?</h5>
        <div class="text-article">
            <ul>
                <li class="mb-1">Publikasi informasi event dan tiket pendaftaran.</li>
                <li class="mb-1">Manajemen event, peserta, tiket, formulir, dan organisasi.</li>
                <li class="mb-1">Menyediakan sistem pembayaran yang beragam bagi peserta dan penyelenggara.</li>
                <li class="mb-1">Menyediakan data report event.</li>
                <li class="mb-1">Fitur check/validasi peserta event.</li>
                <li class="mb-1">Custom short link event.</li>
                <li class="mb-1">Fitur sharing ke berbagai sosial media.</li>
                <li class="mb-1">Sharing artikel</li>
                <li class="mb-1">dan masih banyak fitur lainya, <a href="/dashboard">Lihat fitur</a></li>
            </ul>
        </div>

        {{-- Alasan menggunakan eventconnect.id --}}
        <h5 class="mt-4">Kenapa harus kolaborasi dengan eventhub.web.id?</h5>
        <div class="mb-3">
            <ul class="text-article">
                <li class="mb-1">Event kamu bisa jadi lebih keren & profesional! </li>
                <li class="mb-1">Manajemen sistem pendaftaran, ticketing, pembayaran, & report data yang lebih efisien.
                </li>
                <li class="mb-1">Tidak perlu urusin data peserta, sistem kita yang urus!</li>
                <li class="mb-1">Tidak perlu urus masalaah pembayaran, kita yang urus!</li>
                <li class="mb-1">Meningkatkan kepercayaan peserta!</li>
                <li class="mb-1">Buat artikel, pengumuman, dan sebagainya dari menu manajemen artikel FREE!</li>
                <li class="mb-1">Yang pasti kamu bisa menggunkanan platform eventhub kapanpun dan tentunya<span
                        class="text-success"><b>GRATIS!</b></span>
                </li>
            </ul>
        </div>
        <p class="mt-3">Jadikan event kamu lebih keren dengan <b>eventhub.web.id</b> sob!</p>
        <h5>Gimana caranya?</h5>
        <div>
            <a href="/creator-guide" class="btn btn-success"><i class="fas fa-file-alt"></i> Baca panduan</a>
            <a href="/faq" class="btn btn-info"><i class="fas fa-file-alt"></i> Faq</a>
        </div>
    </section>
@endsection
