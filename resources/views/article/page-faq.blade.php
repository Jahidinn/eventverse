@extends('layouts.main')

@section('content')
    {{-- Form Pencarian --}}

    <div class="header-wave">
        <!--Content before waves-->
        <div class="inner-header-search flex">
            <div class="wave-content w-100">
                <h1>Frequently asked questions (FAQ)</h1>
            </div>
        </div>
        <!--Waves end-->
    </div>

    <section class="container mt-0 pt-5 px-1">

        {{-- FAQ 1 --}}
        <div class="card mb-3 mx-1 shadow-sm">
            <div class="card-body px-4 py-3">
                <div class="text-article mt-0">
                    <a class="btn w-100 text-left" data-toggle="collapse" href="#faq-1" role="button">
                        <b>Apa itu Eventconnect.id?</b>
                    </a>
                    <div class="collapse" id="faq-1">
                        <hr class="m-2 mt-3">
                        <p>
                            Eventconnect.id adalah platform Ticketing Management Service (TMS) yang dikelola oleh PT
                            Konektivitas Tanpa Batas. Kami bekerja sama dengan ILB media (@Info.lomba.beasiswa) untuk
                            menyediakan solusi
                            teknologi dalam mendukung penyelenggaraan event, mulai dari distribusi dan manajemen tiket
                            pendaftaran hingga penyediaan laporan event.
                        </p>
                    </div>

                </div>

            </div>
        </div>

        {{-- FAQ 2 --}}
        <div class="card mb-3 mx-1 shadow-sm">
            <div class="card-body px-4 py-3">
                <div class="text-article mt-0">
                    <a class="btn w-100 text-left" data-toggle="collapse" href="#faq-2" role="button">
                        <b>Apa saja layanan yang ditawarkan oleh Eventconnect.id?</b>
                    </a>

                    <div class="collapse" id="faq-2">
                        <hr class="m-2 mt-3">
                        <p>
                            Kami menyediakan berbagai layanan terkait manajemen tiket pendaftaran event, distribusi tiket,
                            dan
                            penyediaan laporan event. Ini mencakup pendaftaran peserta, pembelian tiket, verifikasi
                            pembayaran,
                            serta pencetakan dan penggunaan tiket digital.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        {{-- FAQ 3 --}}
        <div class="card mb-3 mx-1 shadow-sm">
            <div class="card-body px-4 py-3">
                <div class="text-article mt-0">
                    <p class="mb-2"><b>Bagaimana cara menggunakan Eventconnect.id sebagai penyelenggara event?</b></p>
                    <hr class="m-2">
                    <p>Anda dapat mendaftarkan event Anda di platform kami dan mengatur detailnya, termasuk jenis tiket yang
                        akan dijual, harga tiket, jumlah tiket yang tersedia, dan informasi lainnya. Setelah itu, Anda dapat
                        mempromosikan event Anda dan mengelola penjualan tiket melalui dashboard kami.</p>
                </div>

            </div>
        </div>

        {{-- FAQ 4 --}}
        <div class="card mb-3 mx-1 shadow-sm">
            <div class="card-body px-4 py-3">
                <div class="text-article mt-0">
                    <p class="mb-2"><b>Apakah Eventconnect.id menyediakan layanan pembayaran online?</b></p>
                    <hr class="m-2">
                    <p>Ya, kami menyediakan integrasi dengan berbagai metode pembayaran online untuk memudahkan pembelian
                        tiket bagi peserta event.</p>
                </div>

            </div>
        </div>

        {{-- FAQ 4 --}}
        <div class="card mb-3 mx-1 shadow-sm">
            <div class="card-body px-4 py-3">
                <div class="text-article mt-0">
                    <p class="mb-2"><b>Bagaimana cara mendapatkan laporan atau analisis setelah event selesai?</b></p>
                    <hr class="m-2">
                    <p>Setelah event selesai, Anda dapat mengakses laporan lengkap melalui dashboard kami. Laporan tersebut
                        mencakup data penjualan tiket, kehadiran peserta, dan informasi lainnya yang relevan untuk membantu
                        Anda mengevaluasi kesuksesan event Anda.</p>
                </div>

            </div>
        </div>

    </section>
@endsection
