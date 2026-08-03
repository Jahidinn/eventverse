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
                        <b>Apa itu eventverse.id?</b>
                    </a>
                    <div class="collapse" id="faq-1">
                        <hr class="m-2 mt-3">
                        <p>
                            eventverse adalah platform ticketing management service (TMS) yang dikelola oleh PT
                            Satu Karya Teknologi. Kami bekerja sama dengan ILB media (@Info.lomba.beasiswa) untuk
                            menyediakan solusi teknologi dalam mendukung penyelenggaraan event, mulai dari distribusi dan manajemen tiket
                            pendaftaran hingga penyediaan laporan event secara efisien, info selengkapnya <a href="/about-us">about
                                eventverse</a>.
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
                        <b>Apa saja layanan yang ditawarkan oleh eventverse?</b>
                    </a>

                    <div class="collapse" id="faq-2">
                        <hr class="m-2 mt-3">
                        <p>
                            eventverse menyediakan berbagai layanan terkait manajemen event, ticketing event,
                            kelola data event, manajemen pendaftaran peserta, pembayaran terverifikasi, dan masih banyak lagi yang membuat eventmu terintegrasi. <a href="/about-us">More
                                info</a>.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        {{-- FAQ 2.1 --}}
        <div class="card mb-3 mx-1 shadow-sm">
            <div class="card-body px-4 py-3">
                <div class="text-article mt-0">
                    <a class="btn w-100 text-left" data-toggle="collapse" href="#faq-2-1" role="button">
                        <b>Apakah eventverse.id dapat dipercaya?</b>
                    </a>

                    <div class="collapse" id="faq-2">
                        <hr class="m-2 mt-3">
                        <p>Ya, eventverse.id di kelola organisasi/perusahaan yang berbadan hukum dan dikelola oleh ILB media
                            (@info.lomba.beasiswa) serta menggunakan sistem pembayaran dari midtrans (by gojek) jadi tidak perlu
                            diragukan keamananannya.</a>.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        {{-- FAQ 3 --}}
        <div class="card mb-3 mx-1 shadow-sm">
            <div class="card-body px-4 py-3">
                <div class="text-article mt-0">
                    <a class="btn w-100 text-left" data-toggle="collapse" href="#faq-3" role="button">
                        <b>Bagaimana cara menggunakan eventverse.id sebagai penyelenggara event?</b>
                    </a>
                    <div class="collapse" id="faq-3">
                        <hr class="m-2 mt-3">
                        <p>Kamu dapat mendaftarkan event di platform kami dan mengatur detailnya, termasuk jenis tiket
                            yang akan dijual, harga tiket, jumlah tiket yang tersedia, dan informasi lainnya. Setelah itu,
                            kamu bisa mempromosikan event kamu dan mengelola penjualan tiket melalui dashboard kami, <a
                                href="/creator-guide">baca panduan</a>.</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- FAQ 4 --}}
        <div class="card mb-3 mx-1 shadow-sm">
            <div class="card-body px-4 py-3">
                <div class="text-article mt-0">
                    <a class="btn w-100 text-left" data-toggle="collapse" href="#faq-4" role="button">
                        <b>Apakah eventverse.id menyediakan layanan pembayaran online?</b>
                    </a>
                    <div class="collapse" id="faq-4">
                        <hr class="m-2 mt-3">
                        <p>Ya, kami menyediakan integrasi dengan berbagai metode pembayaran online seperti transfer bank,
                            virtual account (VA), e-wallet, QRIS, dan metode pembayaran lain untuk memudahkan
                            pembelian tiket bagi peserta event.</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- FAQ 5 --}}
        <div class="card mb-3 mx-1 shadow-sm">
            <div class="card-body px-4 py-3">
                <div class="text-article mt-0">
                    <a class="btn w-100 text-left" data-toggle="collapse" href="#faq-5" role="button">
                        <b>Bagaimana cara mendapatkan laporan atau analisis setelah event selesai?</b>
                    </a>
                    <div class="collapse" id="faq-5">
                        <hr class="m-2 mt-3">
                        <p>Setelah event selesai, Anda dapat mengakses report lengkap dengan mudah melalui dashboard kami.
                            Laporan
                            tersebut mencakup data penjualan tiket, kehadiran peserta, report data peserta, report data
                            pembayaran, pencairan dana dan informasi lainnya yang relevan untuk
                            membantu kamu mengevaluasi kesuksesan event Anda.</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- FAQ 6 --}}
        <div class="card mb-3 mx-1 shadow-sm">
            <div class="card-body px-4 py-3">
                <div class="text-article mt-0">
                    <a class="btn w-100 text-left" data-toggle="collapse" href="#faq-6" role="button">
                        <b>Apakah eventverse.id memiliki dukungan pelanggan?</b>
                    </a>
                    <div class="collapse" id="faq-6">
                        <hr class="m-2 mt-3">
                        <p>Ya, kami menyediakan dukungan pelanggan melalui berbagai saluran komunikasi seperti email dan
                            chat. Tim kami siap membantu Anda dengan pertanyaan atau masalah apa pun yang Anda hadapi dalam
                            menggunakan platform kami, <a href="/contact-us">hubungi kami</a>.</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- FAQ 7 --}}
        <div class="card mb-3 mx-1 shadow-sm">
            <div class="card-body px-4 py-3">
                <div class="text-article mt-0">
                    <a class="btn w-100 text-left" data-toggle="collapse" href="#faq-7" role="button">
                        <b>Bagaimana keamanan data peserta yang menggunakan platform eventverse?</b>
                    </a>
                    <div class="collapse" id="faq-7">
                        <hr class="m-2 mt-3">
                        <p>Kami mengutamakan keamanan data peserta dan mengikuti praktik terbaik dalam pengelolaan data
                            pribadi. Kami menggunakan enkripsi data dan memiliki <a href="/privacy-policy">kebijakan
                                privasi</a> yang ketat untuk
                            melindungi informasi pribadi peserta ataupun penyelenggara.</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- FAQ 8 --}}
        <div class="card mb-3 mx-1 shadow-sm">
            <div class="card-body px-4 py-3">
                <div class="text-article mt-0">
                    <a class="btn w-100 text-left" data-toggle="collapse" href="#faq-8" role="button">
                        <b>Apakah eventverse menyediakan integrasi dengan platform lain seperti media sosial atau
                            aplikasi lainnya?</b>
                    </a>
                    <div class="collapse" id="faq-8">
                        <hr class="m-2 mt-3">
                        <p>Ya, kami menyediakan integrasi dengan berbagai platform termasuk media sosial seperti instagram
                            untuk membantu
                            kamu mempromosikan event secara lebih luas dan meningkatkan visibilitasnya. akun yang kami
                            kelola : <a href="http://instagram.com/eventconnect.id">eventconnect</a> dan <a
                                href="http://instagram.com/info.lomba.beasiswa">ILB MEdia</a></p>
                    </div>
                </div>

            </div>
        </div>

        {{-- FAQ 9 --}}
        <div class="card mb-3 mx-1 shadow-sm">
            <div class="card-body px-4 py-3">
                <div class="text-article mt-0">
                    <a class="btn w-100 text-left" data-toggle="collapse" href="#faq-9" role="button">
                        <b>Apakah ada biaya atau komisi yang dikenakan oleh eventverse?</b>
                    </a>
                    <div class="collapse" id="faq-9">
                        <hr class="m-2 mt-3">
                        <p>Kamu bisa menyebarkan event secara gratis, kami hanya mengenakan biaya pada transaksi penjualan tiket atau komisi sesuai dengan layanan yang kamu gunakan. Detail tarif dan
                            biaya akan dijelaskan saat kamu mendaftar dan menggunakan platform kami, atau bisa di akses
                            melalui halaman <a href="/pricing">biaya</a>.</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- FAQ 10 --}}
        <div class="card mb-3 mx-1 shadow-sm">
            <div class="card-body px-4 py-3">
                <div class="text-article mt-0">
                    <a class="btn w-100 text-left" data-toggle="collapse" href="#faq-10" role="button">
                        <b>Bagaimana cara saya memulai menggunakan eventverse untuk event saya?</b>
                    </a>
                    <div class="collapse" id="faq-10">
                        <hr class="m-2 mt-3">
                        <p>Kamu dapat mulai dengan mendaftar di situs web kami dan mengikuti langkah-langkah pendaftaran
                            event. Tim kami juga siap membantu kamu dalam proses ini jika diperlukan, <a
                                href="/register">Daftar sekarang!</a>.</p>
                    </div>
                </div>

            </div>
        </div>

        {{--  --}}
        <div class="card mb-3 mx-1 shadow-sm">
            <div class="card-body px-4 py-3">
                <div class="text-article mt-0">
                    <b class="text-info">Hubungi kami</b>
                    <hr class="m-2 mt-3">
                    <p>Apakah kamu memiliki pertanyaan, masukan, atau hanya ingin menyapa kami? Jangan ragu untuk mengirim
                        pesan kepada tim kami menggunakan formulir di bawah ini. Kami berusaha untuk merespons setiap pesan
                        secepat mungkin!</p>
                    <a class="btn btn-success btn-sm" href="/contact-us">Hubungi sekarang!</a>
                </div>

            </div>
        </div>

    </section>
@endsection
