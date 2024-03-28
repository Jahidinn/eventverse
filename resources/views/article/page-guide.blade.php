@extends('layouts.main')

@section('content')
    {{-- Form Pencarian --}}

    <div class="header-wave">
        <!--Content before waves-->
        <div class="inner-header-search flex">
            <div class="wave-content w-100">
                <h1>PANDUAN</h1>
            </div>
        </div>
        <!--Waves end-->
    </div>

    <section class="container mt-0 pt-4 px-3">
        <div class="alert alert-success" role="alert">
            <b>Ikuti langkah ini untuk jadikan eventmu lebih keren di evetconnect.id</b>
        </div>
        <div id="content">

            <ul class="timeline">
                <li class="event">
                    <h3>Registrasi</h3>
                    <p>Pastikan kamu punya akun di eventconnect, jika belum punya bisa <a href="">Registrasi
                            disini</a>, kamu bisa membuat event atas nama individu atau organisasi. jika atas nama
                        organisasi kamu bisa menambahkan data organisasi di profil.
                    </p>
                    {{-- <img class="w-100" src="{{ asset('storage/blog-images') }}" alt=""> --}}
                </li>
                <li class="event">
                    <h3>Buat event</h3>
                    <p>Selanjutnya kamu tinggal posting event kamu di link <a href="/event/create">create event</a>, masukan
                        poster/banner, deskripsi lengkap, tiket pendaftaran, serta data formulir pendaftaran untuk peserta
                    </p>
                </li>
                <li class="event">
                    <h3>Share</h3>
                    <p>Share link event yang kamu buat biar makin banyak peserta!</p>
                </li>
                <li class="event">
                    <h3>Manage event</h3>
                    <p>Tanpa ribet mengurus report data peserta kamu bisa langsung memantau perkembangan event, data
                        peserta, pembayaran, pemasukan dan sebagainya di halaman dashboard!</p>
                </li>
                <li class="event">
                    <h3>Report data</h3>
                    <p>Selain kamu bisa pantau perkembangan event, di akhir event kamu juga bisa download report data
                        peserta dalam bentuk file excel dan mencairkan dana event</p>
                </li>
                <li class="event">
                    <h3>Done!</h3>
                    <p>Selamat! Event kamu sukses diselenggarakan bersama eventconnect.id</p>
                </li>
            </ul>
        </div>
    </section>
@endsection
