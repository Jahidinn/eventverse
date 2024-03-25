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
        <p><b>Eventconnect.id</b> merupakan platform Ticketing Management Service (TMS) dibawah naungan <b>PT Konektivitas
                Tanpa Batas</b> dan yang bekerja sama dengan <b>ILB media</b> (@Info.lomba.beasiswa) yang menyediakan solusi
            teknologi
            dalam mendukung penyelenggaraan event mulai dari distribusi dan manajemen tiket pendaftaran, hingga penyediaan
            report/laporan event.</p>
        <h5 class="mt-4">Apa yang bisa dilakukan platform eventconnect.id?</h5>
        <div>
            <span><i class="fas fa-check-circle text-info mr-2"></i> Melakukan distribusi informasi event sekaligus tiket
                pendaftaran</span><br>
            <span><i class="fas fa-check-circle text-info mr-2"></i> Manajemen sistem pembayaran yang beragam bagi peserta
                dan penyelenggara event.</span><br>
            <span><i class="fas fa-check-circle text-info mr-2"></i> Menyediakan report dokumen laporan penyelenggaraan
                event.</span><br>
            <span><i class="fas fa-check-circle text-info mr-2"></i> Fitur checkin peserta event.</span><br>
        </div>
        <p class="mt-3">Jadikan event kamu lebih keren dengan <b>eventconnect.id</b> sob!</p>
        <h5>Bagaimana caranya?</h5>
        <div>
            <a href="/blog/guide" class="btn btn-success"><i class="fas fa-file-alt"></i> Baca panduan</a>
        </div>
    </section>
@endsection
