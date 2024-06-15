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
            <span>Panduan <b>event creator</b> dan <b>pengguna</b> eventconnect.id</span>
        </div>
        <hr>
        <div id="content">

            <ul class="timeline">
                <li class="event">
                    <h3>Registrasi</h3>
                    <ol class="pl-4 text-article">
                        <li class="mb-2">
                            Untuk event creator pastikan kamu punya akun di eventconnect, jika belum punya
                            bisa <a href="">Registrasi disini</a>, kamu bisa membuat event atas nama individu atau
                            organisasi. jika atas nama organisasi kamu bisa menambahkan data organisasi di profil.
                        </li>
                        <li class="mb-2">
                            Login menggunakan email dan kata sandi yang telah terdaftar
                        </li>
                        <li class="mb-2">
                            Pengguna akan menerima email verifikasi dan diarahkan untuk mengklik tautan dalam
                            email tersebut untuk mengaktifkan akun yang sudah di daftarkan.
                        </li>
                        <li class="mb-2">
                            Setting profil kamu yaitu termasuk menambahkan foto profil, mengisi biodata, dan
                            rekening (Untuk bukan event creator bisa kosongkan rekening)
                        </li>
                        <li class="mb-2">
                            Pada menu organisasi kamu bisa membuat organisasi baru, gabung organisasi,
                            menambahkan anggota, menetapkan peran dan tanggung jawab, serta mengelola event yang
                            diselenggarakan oleh organisasi tersebut.
                        </li>
                    </ol>
                    <a href="https://youtu.be/7PKrnsQUx90" target="_blank" class="btn btn-danger btn-sm">
                        <i class="far fa-play-circle"></i> Video panduan
                    </a>

                    {{-- <img class="w-100" src="{{ asset('assets/default-img/blog-images/ev') }}/1.png" alt="">
                    <img class="w-100 mt-2" src="{{ asset('assets/default-img/blog-images/ev') }}/2.png" alt=""> --}}
                </li>
                <li class="event">
                    <h3>Create event</h3>
                    <ol class="pl-4 text-article">
                        <li class="mb-2">
                            Masuk ke Akun kamu: Langkah pertama untuk memulai adalah masuk ke akun Eventconnect.id kamu,
                            login dengan email dan kata sandi yang telah terdaftar.
                        </li>
                        <li class="mb-2">
                            Navigasi ke Dashboard: Setelah berhasil login, kamu akan diarahkan ke dashboard utama. Di sini,
                            kamu dapat melihat menu <b>manajemen event</b> untuk membuat event baru
                        </li>
                        <li class="mb-2">
                            ikuti langkah demi langkah form untuk membuat event baru, termasuk mengisi detail acara seperti
                            judul, deskripsi, tiket pendaftaran, tanggal, waktu, lokasi, dan formulir pendaftaran event.
                            kamu juga akan diajarkan cara mengunggah gambar atau poster acara untuk menarik perhatian
                            peserta.
                        </li>
                        <li class="mb-2">
                            Atur <b>Tiket pendaftaran</b> seperti deskripsi tiket pendaftaran, berbayar atau gratis,
                            serta batasan jumlah peserta. Selain itu buat juga <b>formulir</b> yang diperlukan untuk
                            pendaftaran event.
                        </li>
                        <li class="mb-2">
                            Promosikan event dengan berbagi link menggunakan fitur promosi seperti QR code dan menu share
                            event untuk meningkatkan visibilitas acara.
                        </li>
                        <li class="mb-2">
                            Setelah posting, kelola event yang telah dipublikasikan, Ini mencakup cara memperbarui informasi
                            acara, tiket registrasi, formulir, kelola data peserta, kelola uang pembayaran masuk dan
                            memantau pendaftaran secara real-time pada dashboard.
                        </li>
                    </ol>
                    <a href="https://youtu.be/igdg2VMQjn0" target="_blank" class="btn btn-danger btn-sm">
                        <i class="far fa-play-circle"></i> Video panduan
                    </a>

                    {{-- <img class="w-100 mt-2" src="{{ asset('assets/default-img/blog-images/ev') }}/3.png" alt=""> --}}
                </li>
                <li class="event">
                    <h3>Management event</h3>
                    <ol class="pl-4 text-article">
                        <li class="mb-2">
                            Buka menu manajemen event untuk memperbarui informasi event setelah dipublikasikan,
                            ini mencakup mengubah detail acara seperti judul, deskripsi, tanggal, waktu, dan lokasi,
                            serta cara memberikan pembaruan kepada peserta yang telah terdaftar.
                        </li>
                        <li class="mb-2">
                            Pada menu manajemen event juga terdapat menu untuk kelola tiket pendaftaran, Ini termasuk
                            pembuatan tiket baru(berbayar, gratis, dsb), mengatur kuota tiket, serta mengelola pembatalan
                            atau perubahan tiket.
                        </li>
                        <li class="mb-2">
                            Dalam menu manajemen event juga terdapat menu edit formulir untuk membuat dan menyesuaikan
                            formulir pendaftaran. kamu bisa menambahkan formulir yang relevan untuk peserta,
                            membuat kolom isian wajib, dan mengumpulkan informasi penting dari peserta.
                        </li>
                        <li class="mb-2">
                            Untuk mengakses dan melihat data peserta yang telah mendaftar event, kamu bisa akses ke menu
                            <strong>data peserta</strong> untuk menampilkan data peserta dalam berbagai format dan memfilter
                            informasi yang dibutuhkan, serta melihat pembayaran yang digunakan.
                        </li>
                        <li class="mb-2">
                            Download Data Peserta: kamu bisa untuk mengunduh data peserta dalam format excel digunakan untuk
                            analisis lebih lanjut atau keperluan administrasi pada menu data peserta
                        </li>
                        <li class="mb-2">
                            Pencairan Dana Event: untuk mencairkan dana yang diperoleh dari penjualan tiket
                            dan pembayaran lainnya kamu bisa akses ke menu laporan transaksi.
                        </li>
                    </ol>
                    <a href="https://youtu.be/CKDndwnmPk0" target="_blank" class="btn btn-danger btn-sm">
                        <i class="far fa-play-circle"></i> Video panduan
                    </a>
                    {{-- <img class="w-100 mt-2" src="{{ asset('assets/default-img/blog-images/ev') }}/4.png" alt=""> --}}
                </li>
                <li class="event">
                    <h3>Manajemen artikel</h3>
                    <span class="text-article mb-3">
                        Eventconnect.id tidak hanya menyediakan platform untuk mengelola acara, tetapi juga memungkinkan
                        pengguna untuk membuat dan mengelola artikel untuk berbagai keperluan seperti pengumuman, berita,
                        dan seagainya.
                    </span>
                    <ol class="pl-4 text-article">
                        <li class="mb-2">
                            Buka menu manajemen artikel untuk mengelola artikel kamu.
                        </li>
                        <li class="mb-2">
                            Pada menu manajemen artikel kamu bisa menulis artikel, mulai dari menentukan judul yang menarik,
                            menulis konten informatif, hingga menambahkan gambar atau media lain yang relevan. Selain itu
                            bisa memperbarui artikel atau menghapus artikel yang kamu buat.
                        </li>
                    </ol>
                    <a href="https://youtu.be/rquCGbrnzqI" target="_blank" class="btn btn-danger btn-sm">
                        <i class="far fa-play-circle"></i> Video panduan
                    </a>
                    {{-- <img class="w-100 mt-2" src="{{ asset('assets/default-img/blog-images/ev') }}/5.png" alt=""> --}}
                </li>

                <li class="event">
                    <h3>Mendaftar event</h3>
                    <ol class="pl-4 text-article">
                        <li class="mb-2">
                            Untuk registrasi atau membeli tiket event di eventconnect.id tidak harus punya akun, kamu bisa
                            registrasi event dengan akun atau tanpa akun.
                        </li>
                        <li class="mb-2">
                            Menemukan Event: Cari event yang kamu suka di halaman utama atau melalui fitur
                            pencarian, filter kategori, dan eksplorasi event yang tersedia di eventconnect.id.
                        </li>
                        <li class="mb-2">
                            Pahami detail event: kamu harus paham tentang informasi penting terkait event, seperti syarat
                            dan ketentuan, kategori event, jadwal, dan hadiah. Ini memastikan peserta mengetahui semua
                            informasi yang dibutuhkan sebelum mendaftar.
                        </li>
                        <li class="mb-2">
                            Registrasi : Setelah memahami detail event registrasi sesuai dengan tiket pendaftaran yang
                            tersedia, isikan
                            detail informasi atau formulir yang dibutuhkan untuk event tersebut.
                        </li>
                        <li class="mb-2">
                            Pembayaran biaya registrasi: lakukan pembayaran biaya registrasi (jika ada) dengan berbagai
                            metode pembayaran yang tersedia setelah submit data pendaftaran.
                        </li>
                        <li class="mb-2">
                            Konfirmasi pendaftaran : setelah sukses melakukan pendaftaran kamu akan menerima email
                            konfirmasi yang berisi status pendaftaran, kode pendaftaran, beserta informasi lainya.
                        </li>
                        <li class="mb-2">
                            Persiapan dan Partisipasi: Untuk event offline persiapkan diri sebelum lomba, termasuk jadwal
                            pelaksanaan, persiapan teknis, dan aturan yang harus diikuti selama lomba.
                        </li>
                    </ol>
                    <a href="https://youtu.be/u2ewB5TRY0o" target="_blank" class="btn btn-danger btn-sm">
                        <i class="far fa-play-circle"></i> Video panduan
                    </a>

                    {{-- <img class="w-100 mt-2" src="{{ asset('assets/default-img/blog-images/ev') }}/6.png" alt="">
                    <img class="w-100 mt-3" src="{{ asset('assets/default-img/blog-images/ev') }}/7.png" alt="">
                    <img class="w-100 mt-3" src="{{ asset('assets/default-img/blog-images/ev') }}/8.png" alt=""> --}}
                </li>
                <li class="event">
                    <h3>Done!</h3>
                    <p class="text-article">Selamat! Kamus sudah bisa menjadi event creator atau peserta di eventconnect.id
                    </p>
                </li>
            </ul>
        </div>
    </section>
@endsection
