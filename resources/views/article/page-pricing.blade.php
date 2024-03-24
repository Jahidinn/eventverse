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
            <h3>Biaya transaksi di eventconnect.id</h3>
            <span class="text-danger"><i>Biaya transaksi di bebankan kepada penyelenggara</i></span>
        </div>
        <div class="row">
            <div class="col-md-8 mb-3">
                <div class="card mb-3">
                    <div class="card-header">
                        QRIS, GoPay, GoPay Later, ShopeePay, LinkAja
                    </div>
                    <div class="card-body">
                        <b>3% x Total Penjualan</b>
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
                    <small><i class="fas fa-caret-right"></i> Total Penjualan = Total Tiket Terjual x Harga
                        Tiket</small><br>
                    <small><i class="fas fa-caret-right"></i> Biaya sudah termasuk PPN 11%</small>
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-4" id="simulasi-pembayaran">
        <div class="mb-3">
            <h3>Simulasi biaya</h3>
        </div>
        <div class="card">

            <div class="card-body">
                <p><i>Sebuah lembaga pendidikan <b>Smart Education</b>, membuat event “Lomba Karya Tulis Ilmiah (LKTIN)”
                        dengan harga tiket pendaftaran <b>Rp 100.000.</b></i></p>
                <p><b>Case 1: </b><br>
                    Melani membeli 5 tiket menggunakan ShopeePay , maka: Melani akan membayar sebesar Rp 500.000 Smart
                    Education akan dikenakan biaya sebesar <b>3% x Total penjualan = Rp 15.000</b> Maka, jumlah uang yang
                    didapat oleh Smart Educations adalah sebesar Rp 285.000</p>

                <p><b>Case 2:</b><br>
                    Melani membeli 5 tiket pendaftaran menggunakan Virtual Account (VA) dan akan membayar sebesar Rp 500.000
                    Reza membeli 5 tiket menggunakan GoPay dan akan membayar sebesar Rp500.000 </p>
                <p>Smart Education akan dikenakan biaya sebesar:</p>
                <p>Tiket Melani, pembayaran menggunakan Virtual Account (VA)<br>
                    = (1,5% x Total Penjualan) + (4.500 x jumlah tiket)<br>
                    = (1,5% x Rp 500.000) + (4.500 x 5) <br>
                    = Rp7.500 + 22.500<br>
                    = Rp30.000</p>
                <p>
                    Tiket Reza, pembayaran menggunakan GoPay <br>
                    = 3% x Total Penjualan <br>
                    = 3% x Rp 500.000 <br>
                    = Rp15.000</p>

                <p>Biaya yang dikenakan untuk pembelian tiket pendaftaran Melani, dan Reza adalah: Rp30.000 + Rp15.000 =
                    Rp45.000 Maka, jumlah
                    uang yang bisa di-withdraw oleh Smrt Education adalah sebesar: <b>Rp 1.000.000 - Rp 45.000 = Rp
                        955.000</b></p>
            </div>
        </div>
        <div class="mt-4">
            Kenapa harus eventconnect? <a href="/" class="text-info"> <b>Cek selengkapnya ...</b></a>
        </div>
    </section>
@endsection
