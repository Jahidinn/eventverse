@extends('layouts.main')

@section('content')
    {{-- Form Pencarian --}}

    <div class="header-wave">
        <!--Content before waves-->
        <div class="inner-header-search flex">
            <div class="wave-content w-100">
                <h1>PRICING</h1>
            </div>
        </div>
        <!--Waves end-->
    </div>

    <section class="container mt-0 pb-0 pt-5">
        <div class="mb-3">
            <b>Biaya transaksi di eventhub.web.id</b><br>
            <small class="text-danger"><i>Biaya transaksi di bebankan kepada penyelenggara</i></small>
        </div>
        <div class="row text-article">
            <div class="col-md-8 mb-3">
                <div class="card mb-3">
                    <div class="card-header">
                        QRIS, Gopay, Shopeepay, Linkaja <span class="text-success">(Rekomendasi)</span>
                    </div>
                    <div class="card-body">
                        <b>3% (per transaksi)</b>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        Virtual Account (VA) dan Bank Transfer
                    </div>
                    <div class="card-body">
                        <b>1,5% + 4.500 (Per transaksi)</b>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        Credit Card dan Metode Pembayaran Lainya
                    </div>
                    <div class="card-body">
                        <b>2,5% + 2.500 (Per transaksi)</b>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <p>Biaya transaksi <b>berbeda</b> tergantung dari metode pembayaran yang dipilih oleh pembeli tiket atau
                    peserta event! <br>
                </p>
                <a href="#simulasi-pembayaran" class="btn btn-info btn-sm">Simulasi biaya <i
                        class="fas fa-chevron-circle-right"></i></a>
                <div class="bg-secondary p-2 mt-2 text-white">
                    <small>
                        <i class="fas fa-caret-right"></i> Total Penjualan = Total Tiket Terjual x Harga Tiket
                    </small>
                    <br>
                    <small>
                        <i class="fas fa-caret-right"></i> Biaya sudah termasuk PPN 11%
                    </small>
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-4" id="simulasi-pembayaran">
        <div class="mb-3">
            <h4>Simulasi biaya</h4>
        </div>
        <div class="card">
            <div class="card-body text-article">
                <p>
                    <i>Sebuah lembaga pendidikan <b>Smart Education</b>, membuat event “Lomba Karya Tulis Ilmiah (LKTIN)”
                        dengan harga tiket pendaftaran <b>Rp 50.000.</b></i>
                </p>
                <p>
                    <b>Contoh 1: </b><br>
                    Melani membeli 2 tiket event menggunakan QRIS, maka: melani akan membayar sebesar Rp 100.000, Smart
                    Education sebagai penyelenggara akan dikenakan biaya sebesar <b>3% x Total per transaksi (100.000 x 3% = Rp. 3.000)</b>
                    Maka jumlah uang yang didapat oleh penyelenggara dari transaksi melani adalah sebesar Rp 97.000
                </p>

                <p>
                    <b>Contoh 2:</b><br>
                    Jika ada 10 pendaftar event artinya membeli 10 tiket pendaftaran, jika pembayaran menggunakan Gopay/Shopeepay maka jumlah yang di bayarkan oleh peserta sebesar Rp
                    500.000
                </p>
                <p>Perhitungannya biaya transaksi sebagai berikut :</p>
                <p>Biaya transaksi : 3%<br>
                    = Total transaksi x 3%<br>
                    = 500.000 x 3% <br>
                    = Rp15.000</p>

                <p>Biaya admin yang dikenakan dari 10 pendaftar tersebut adalah: Rp15.000<br>
                    Maka, jumlah uang yang bisa di withdraw oleh penyelenggara event adalah sebesar: <b>Rp 500.000 - Rp 15.000
                        = Rp 485.000</b>
                </p>
            </div>
        </div>
        <div class="mt-4 text-article">
            Kenapa harus eventhub? <a href="/about-us" class="text-info"> <b>Cek selengkapnya ...</b></a>
        </div>
    </section>
@endsection
