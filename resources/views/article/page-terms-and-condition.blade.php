@extends('layouts.main')

@section('content')
    {{-- Form Pencarian --}}

    <div class="header-wave">
        <!--Content before waves-->
        <div class="inner-header-search flex">
            <div class="wave-content w-100">
                <h1>Terms and condition</h1>
            </div>
        </div>
        <!--Waves end-->
    </div>

    <section class="container mt-0 pt-5 px-1">
        <div class="card mb-3 mx-1 shadow">
            <div class="card-body p-4">
                <div class="legal-document">

                    <div class="legal-header mb-4">
                        <h3>Terms and condition</h3>
                        <p class="text-muted mb-0">
                            Syarat dan Ketentuan Penggunaan EventHub Web ID
                        </p>
                        <small class="text-muted">
                            Terakhir diperbarui: [15 June 2026]
                        </small>
                    </div>

                    <div class="alert alert-primary">
                        <strong>Penting:</strong><br>
                        Dengan mengakses, menggunakan, mendaftarkan akun, membuat event,
                        membeli tiket, melakukan pembayaran, menggunakan dashboard organizer,
                        melakukan check-in peserta, menerima sertifikat elektronik,
                        maupun menggunakan layanan lainnya yang tersedia di EventHub,
                        Anda dianggap telah membaca, memahami, dan menyetujui seluruh
                        Syarat dan Ketentuan ini.
                    </div>

                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h4>Daftar Isi</h4>

                            <ol>
                                <li>Definisi</li>
                                <li>Layanan yang Disediakan</li>
                                <li>Akun Pengguna</li>
                                <li>Persyaratan Usia dan Kapasitas Hukum</li>
                                <li>Verifikasi Penyelenggara (KYC)</li>
                                <li>Ketentuan Penyelenggara Event</li>
                                <li>Registrasi Peserta dan Pembelian Tiket</li>
                                <li>Tiket Elektronik dan QR Code</li>
                                <li>Pembayaran</li>
                                <li>Pencairan Dana Penyelenggara</li>
                                <li>Refund dan Pembatalan</li>
                                <li>Perubahan atau Pembatalan Event</li>
                                <li>Check-In dan Verifikasi Kehadiran</li>
                                <li>Sertifikat Elektronik</li>
                                <li>Dokumentasi Event</li>
                                <li>Data Pribadi dan Privasi</li>
                                <li>Komunikasi Elektronik</li>
                                <li>Anti Fraud dan Chargeback</li>
                                <li>Pencegahan Pencucian Uang</li>
                                <li>API dan Integrasi Pihak Ketiga</li>
                                <li>Larangan Penggunaan</li>
                                <li>Hak Kekayaan Intelektual</li>
                                <li>User Generated Content</li>
                                <li>Ketersediaan Layanan</li>
                                <li>Force Majeure</li>
                                <li>Hubungan antara Peserta dan Penyelenggara</li>
                                <li>Batasan Tanggung Jawab</li>
                                <li>Batas Maksimum Ganti Rugi</li>
                                <li>Ganti Rugi oleh Pengguna</li>
                                <li>Penangguhan dan Penghapusan Akun</li>
                                <li>Pajak dan Kewajiban Finansial</li>
                                <li>Pengalihan Bisnis</li>
                                <li>Kepatuhan Hukum</li>
                                <li>Perubahan Ketentuan</li>
                                <li>Hukum yang Berlaku</li>
                                <li>Kontak</li>
                            </ol>
                        </div>
                    </div>

                    <hr>

                    <section class="py-2">
                        <h4>1. Definisi</h4>

                        <p>
                            Dalam Syarat dan Ketentuan ini, istilah-istilah berikut memiliki arti sebagaimana dijelaskan di bawah ini:
                        </p>

                        <ul>
                            <li>
                                <strong>Platform</strong> adalah situs web, aplikasi, dashboard,
                                API, sistem ticketing, sistem registrasi, sistem check-in,
                                serta seluruh layanan digital yang disediakan oleh EventHub.
                            </li>

                            <li>
                                <strong>EventHub</strong> adalah penyedia layanan teknologi
                                manajemen event dan ticketing online.
                            </li>

                            <li>
                                <strong>Pengguna</strong> adalah setiap individu, organisasi,
                                badan usaha, komunitas, lembaga, atau badan hukum yang menggunakan layanan EventHub.
                            </li>

                            <li>
                                <strong>Penyelenggara (Organizer)</strong> adalah pihak yang membuat,
                                mengelola, atau menyelenggarakan event melalui Platform.
                            </li>

                            <li>
                                <strong>Peserta</strong> adalah individu yang melakukan pendaftaran,
                                pembelian tiket, atau mengikuti suatu event.
                            </li>

                            <li>
                                <strong>Event</strong> adalah kegiatan yang dipublikasikan melalui Platform.
                            </li>

                            <li>
                                <strong>Tiket</strong> adalah bukti registrasi atau hak akses terhadap suatu event.
                            </li>

                            <li>
                                <strong>Pembayaran</strong> adalah transaksi yang dilakukan melalui sistem pembayaran yang terintegrasi dengan Platform.
                            </li>

                            <li>
                                <strong>Mitra Pembayaran</strong> adalah pihak ketiga yang memproses transaksi pembayaran pengguna.
                            </li>

                            <li>
                                <strong>Konten</strong> adalah seluruh informasi, teks, foto, video,
                                desain, logo, dokumen, rekaman suara, dan materi lainnya yang diunggah ke Platform.
                            </li>
                        </ul>
                    </section>

                    <hr>

                    <section class="py-2">
                        <h4>2. Layanan yang Disediakan</h4>

                        <p>
                            EventHub menyediakan layanan teknologi yang mendukung penyelenggaraan event secara online maupun offline.
                        </p>

                        <p>
                            Layanan tersebut meliputi namun tidak terbatas pada:
                        </p>

                        <ul>
                            <li>Publikasi event.</li>
                            <li>Registrasi peserta.</li>
                            <li>Penjualan tiket online.</li>
                            <li>QR Code ticketing.</li>
                            <li>Check-in peserta.</li>
                            <li>Verifikasi tiket.</li>
                            <li>Email otomatis.</li>
                            <li>Notifikasi sistem.</li>
                            <li>Invoice elektronik.</li>
                            <li>Sertifikat elektronik.</li>
                            <li>Dashboard laporan.</li>
                            <li>Analitik event.</li>
                            <li>Pencairan dana organizer.</li>
                            <li>API dan integrasi.</li>
                            <li>Layanan pendukung lainnya.</li>
                        </ul>

                        <p>
                            EventHub berhak menambah, mengubah, mengurangi,
                            membatasi, menangguhkan, atau menghentikan sebagian
                            maupun seluruh layanan kapan saja sesuai kebutuhan operasional,
                            keamanan sistem, atau kepatuhan hukum.
                        </p>
                    </section>

                    <hr>

                    <section class="py-2">
                        <h4>3. Akun Pengguna</h4>

                        <p>
                            Untuk menggunakan fitur tertentu, pengguna wajib membuat akun.
                        </p>

                        <p>
                            Pengguna wajib:
                        </p>

                        <ul>
                            <li>Memberikan data yang benar, akurat, dan terkini.</li>
                            <li>Menjaga kerahasiaan akun dan password.</li>
                            <li>Menjaga keamanan perangkat yang digunakan.</li>
                            <li>Bertanggung jawab atas seluruh aktivitas akun.</li>
                            <li>Segera melaporkan akses tidak sah.</li>
                        </ul>

                        <p>
                            Pengguna dilarang:
                        </p>

                        <ul>
                            <li>Membuat akun palsu.</li>
                            <li>Menyamar sebagai pihak lain.</li>
                            <li>Meminjamkan akun tanpa izin.</li>
                            <li>Menggunakan akun untuk kegiatan ilegal.</li>
                        </ul>

                        <p>
                            Seluruh aktivitas yang dilakukan melalui akun pengguna
                            dianggap dilakukan oleh pemilik akun tersebut.
                        </p>
                    </section>
                    <hr>

                    <section class="py-2">
                        <h4>4. Persyaratan Usia dan Kapasitas Hukum</h4>

                        <p>
                            Dengan menggunakan layanan EventHub,
                            pengguna menyatakan memiliki kapasitas hukum yang cukup
                            untuk menyetujui Syarat dan Ketentuan ini.
                        </p>

                        <p>
                            Apabila pengguna belum memenuhi usia yang dipersyaratkan
                            oleh hukum yang berlaku, penggunaan layanan harus dilakukan
                            dengan persetujuan dan pengawasan orang tua atau wali yang sah.
                        </p>
                    </section>

                    <hr>

                    <section class="py-2">
                        <h4>5. Verifikasi Penyelenggara (KYC)</h4>

                        <p>
                            EventHub dapat melakukan proses verifikasi identitas
                            terhadap penyelenggara sebelum memberikan akses
                            terhadap fitur tertentu.
                        </p>

                        <p>
                            Dokumen yang dapat diminta meliputi:
                        </p>

                        <ul>
                            <li>KTP atau identitas resmi lainnya.</li>
                            <li>Rekening bank.</li>
                            <li>NPWP.</li>
                            <li>Dokumen legalitas usaha.</li>
                            <li>Surat izin.</li>
                            <li>Dokumen pendukung lainnya.</li>
                        </ul>

                        <p>
                            EventHub berhak menolak, membatasi,
                            atau menghentikan layanan apabila data verifikasi
                            dianggap tidak lengkap, tidak valid,
                            atau menimbulkan risiko hukum maupun keamanan.
                        </p>
                    </section>
                    <hr>

                    <section class="py-2">
                        <h4>6. Ketentuan Penyelenggara Event</h4>

                        <p>
                            Penyelenggara bertanggung jawab penuh atas seluruh event
                            yang dibuat melalui Platform.
                        </p>

                        <p>
                            Tanggung jawab tersebut meliputi:
                        </p>

                        <ul>
                            <li>Keabsahan event.</li>
                            <li>Keakuratan informasi event.</li>
                            <li>Perizinan yang diperlukan.</li>
                            <li>Pelaksanaan event.</li>
                            <li>Keamanan peserta.</li>
                            <li>Pengelolaan peserta.</li>
                            <li>Kebijakan refund.</li>
                            <li>Kepatuhan hukum.</li>
                        </ul>

                        <p>
                            EventHub hanya bertindak sebagai penyedia platform teknologi
                            dan bukan penyelenggara event.
                        </p>

                        <p>
                            Segala bentuk sengketa antara peserta dan penyelenggara
                            merupakan tanggung jawab masing-masing pihak.
                        </p>
                    </section>

                    <hr>

                    <section class="py-2">
                        <h4>7. Registrasi Peserta dan Pembelian Tiket</h4>

                        <p>
                            Peserta wajib memberikan informasi yang benar saat registrasi.
                        </p>

                        <p>
                            Setelah pembayaran berhasil:
                        </p>

                        <ul>
                            <li>Tiket elektronik dapat diterbitkan.</li>
                            <li>Email konfirmasi dapat dikirimkan.</li>
                            <li>Invoice dapat diterbitkan secara otomatis.</li>
                        </ul>

                        <p>
                            Tiket hanya berlaku untuk event yang tercantum pada tiket tersebut.
                        </p>

                        <p>
                            Penyalahgunaan tiket dapat menyebabkan pembatalan akses
                            tanpa kompensasi.
                        </p>
                    </section>

                    <hr>

                    <section class="py-2">
                        <h4>8. Tiket Elektronik dan QR Code</h4>

                        <p>
                            Tiket elektronik dan QR Code merupakan bukti registrasi yang sah.
                        </p>

                        <p>
                            Pengguna wajib menjaga kerahasiaan QR Code
                            dan tidak membagikannya kepada pihak yang tidak berwenang.
                        </p>

                        <p>
                            EventHub maupun penyelenggara berhak menolak tiket yang:
                        </p>

                        <ul>
                            <li>Telah digunakan sebelumnya.</li>
                            <li>Dipalsukan.</li>
                            <li>Dimodifikasi tanpa izin.</li>
                            <li>Diperoleh melalui aktivitas ilegal.</li>
                        </ul>

                        <p>
                            EventHub tidak bertanggung jawab atas penyalahgunaan tiket
                            akibat kelalaian pengguna.
                        </p>
                    </section>

                    <hr>

                    <section id="pembayaran" class="py-2">
                        <h4>9. Pembayaran</h4>

                        <p>
                            Seluruh pembayaran yang dilakukan melalui Platform diproses
                            melalui mitra pembayaran resmi yang telah bekerja sama
                            dan terintegrasi dengan sistem EventHub.
                        </p>

                        <p>
                            Dengan melakukan pembayaran, pengguna memahami dan menyetujui
                            bahwa transaksi dapat diproses oleh pihak ketiga yang memiliki
                            syarat layanan, kebijakan privasi, dan ketentuan penggunaan tersendiri.
                        </p>

                        <h5>9.1 Metode Pembayaran</h5>

                        <p>
                            EventHub dapat menyediakan berbagai metode pembayaran,
                            termasuk namun tidak terbatas pada:
                        </p>

                        <ul>
                            <li>Transfer bank.</li>
                            <li>Virtual Account.</li>
                            <li>Kartu kredit.</li>
                            <li>Kartu debit.</li>
                            <li>E-wallet.</li>
                            <li>QRIS.</li>
                            <li>Metode pembayaran lainnya.</li>
                        </ul>

                        <h5>9.2 Keamanan Pembayaran</h5>

                        <p>
                            EventHub tidak menyimpan nomor kartu kredit, PIN,
                            CVV/CVC, password e-wallet, maupun kredensial pembayaran sensitif lainnya.
                        </p>

                        <p>
                            Pengguna bertanggung jawab untuk menjaga keamanan
                            informasi pembayaran yang digunakan.
                        </p>

                        <h5>9.3 Kegagalan Pembayaran</h5>

                        <p>
                            EventHub tidak bertanggung jawab atas kegagalan transaksi
                            yang disebabkan oleh gangguan sistem bank,
                            mitra pembayaran, jaringan internet,
                            atau faktor lain di luar kendali yang wajar.
                        </p>

                        <h5>9.4 Biaya Layanan</h5>

                        <p>
                            EventHub dapat mengenakan biaya layanan,
                            biaya administrasi, biaya transaksi,
                            biaya pemrosesan pembayaran,
                            maupun biaya lainnya sesuai ketentuan yang berlaku.
                        </p>
                    </section>

                    <hr>

                    <section id="pencairan-dana" class="py-2">
                        <h4>10. Pencairan Dana Penyelenggara</h4>

                        <p>
                            Dana hasil penjualan tiket dapat dicairkan kepada penyelenggara
                            sesuai jadwal dan kebijakan pencairan yang berlaku pada Platform.
                        </p>

                        <h5>10.1 Verifikasi Sebelum Pencairan</h5>

                        <p>
                            Sebelum pencairan dilakukan, EventHub dapat meminta proses
                            verifikasi tambahan terhadap identitas penyelenggara,
                            rekening bank, dokumen legalitas organisasi,
                            maupun dokumen pendukung lainnya.
                        </p>

                        <h5>10.2 Penundaan Pencairan</h5>

                        <p>
                            EventHub berhak menunda atau menahan pencairan dana apabila:
                        </p>

                        <ul>
                            <li>Proses verifikasi belum selesai.</li>
                            <li>Terdapat laporan peserta.</li>
                            <li>Terdapat indikasi pelanggaran hukum.</li>
                            <li>Terdapat chargeback.</li>
                            <li>Terdapat indikasi penipuan.</li>
                            <li>Terdapat sengketa transaksi.</li>
                            <li>Terdapat permintaan regulator atau aparat berwenang.</li>
                        </ul>

                        <h5>10.3 Cadangan Risiko (Reserve Fund)</h5>

                        <p>
                            Dalam kondisi tertentu EventHub dapat menahan sebagian dana
                            sebagai cadangan risiko untuk melindungi peserta,
                            penyelenggara, dan Platform dari potensi kerugian,
                            refund, chargeback, sengketa transaksi,
                            atau kewajiban hukum lainnya.
                        </p>

                        <h5>10.4 Tanggung Jawab Rekening</h5>

                        <p>
                            Penyelenggara bertanggung jawab penuh atas keakuratan
                            informasi rekening yang diberikan kepada EventHub.
                        </p>

                        <p>
                            EventHub tidak bertanggung jawab atas kegagalan pencairan
                            yang disebabkan oleh kesalahan data rekening.
                        </p>

                    </section>
                    <hr>

<section id="refund">
    <h2>11. Refund dan Pembatalan</h2>

```
<p>
    Kebijakan refund ditentukan oleh masing-masing penyelenggara event
    dan dapat berbeda untuk setiap event.
</p>

<h3>11.1 Pengajuan Refund</h3>

<p>
    Peserta dapat mengajukan refund sesuai syarat dan ketentuan
    yang diumumkan oleh penyelenggara.
</p>

<h3>11.2 Penolakan Refund</h3>

<p>
    Permintaan refund dapat ditolak apabila:
</p>

<ul>
    <li>Event telah berlangsung.</li>
    <li>Melewati batas waktu refund.</li>
    <li>Melanggar kebijakan event.</li>
    <li>Data peserta tidak dapat diverifikasi.</li>
    <li>Terdapat indikasi penyalahgunaan sistem.</li>
</ul>

<h3>11.3 Peran EventHub</h3>

<p>
    EventHub dapat membantu proses administrasi refund
    namun tidak menjamin bahwa refund akan disetujui.
</p>

<p>
    Keputusan akhir refund berada pada penyelenggara
    sesuai kebijakan event yang berlaku.
</p>
```

</section>

<section id="perubahan-event">
    <h2>12. Perubahan atau Pembatalan Event</h2>

```
<p>
    Penyelenggara berhak melakukan perubahan terhadap event,
    termasuk namun tidak terbatas pada:
</p>

<ul>
    <li>Jadwal kegiatan.</li>
    <li>Lokasi event.</li>
    <li>Narasumber.</li>
    <li>Agenda acara.</li>
    <li>Harga tiket.</li>
    <li>Fasilitas event.</li>
</ul>

<h3>12.1 Pembatalan Event</h3>

<p>
    Dalam hal event dibatalkan,
    penyelenggara bertanggung jawab atas kebijakan refund
    yang diumumkan kepada peserta.
</p>

<h3>12.2 Batasan Tanggung Jawab EventHub</h3>

<p>
    EventHub tidak bertanggung jawab atas kerugian langsung maupun tidak langsung
    yang timbul akibat perubahan atau pembatalan event.
</p>
```

</section>

<section id="checkin">
    <h2>13. Check-In dan Verifikasi Kehadiran</h2>

```
<p>
    Peserta dapat diwajibkan menunjukkan dokumen tertentu
    untuk memperoleh akses ke event.
</p>

<ul>
    <li>Tiket elektronik.</li>
    <li>QR Code.</li>
    <li>Kartu identitas.</li>
    <li>Dokumen pendukung lainnya.</li>
</ul>

<h3>13.1 Penolakan Akses</h3>

<p>
    Penyelenggara berhak menolak akses apabila:
</p>

<ul>
    <li>Tiket tidak valid.</li>
    <li>Tiket telah digunakan.</li>
    <li>Data peserta tidak sesuai.</li>
    <li>Identitas tidak dapat diverifikasi.</li>
    <li>Terdapat indikasi penyalahgunaan tiket.</li>
</ul>

<h3>13.2 Data Check-In</h3>

<p>
    Sistem dapat mencatat waktu check-in,
    perangkat yang digunakan,
    lokasi check-in (apabila tersedia),
    dan informasi lain yang diperlukan untuk audit,
    pelaporan, keamanan, dan dokumentasi event.
</p>
```

</section>

<section id="sertifikat">
    <h2>14. Sertifikat Elektronik</h2>

```
<p>
    EventHub dapat menyediakan fitur penerbitan sertifikat elektronik
    apabila diaktifkan oleh penyelenggara.
</p>

<h3>14.1 Data Sertifikat</h3>

<p>
    Sertifikat diterbitkan berdasarkan data yang diberikan peserta
    saat registrasi.
</p>

<p>
    Peserta bertanggung jawab atas kebenaran data yang digunakan.
</p>

<h3>14.2 Syarat Penerbitan</h3>

<p>
    Penyelenggara berhak menentukan syarat penerbitan sertifikat,
    termasuk kehadiran minimum, penyelesaian tugas,
    atau persyaratan lainnya.
</p>
```

</section>

<section id="dokumentasi-event">
    <h2>15. Dokumentasi Event</h2>

```
<p>
    Selama event berlangsung,
    penyelenggara atau pihak yang ditunjuk dapat melakukan dokumentasi
    dalam bentuk foto, video, rekaman suara,
    live streaming, maupun media lainnya.
</p>

<h3>15.1 Penggunaan Dokumentasi</h3>

<p>
    Dokumentasi dapat digunakan untuk:
</p>

<ul>
    <li>Publikasi kegiatan.</li>
    <li>Promosi event berikutnya.</li>
    <li>Laporan kegiatan.</li>
    <li>Materi pemasaran.</li>
    <li>Dokumentasi internal.</li>
</ul>

<h3>15.2 Persetujuan Peserta</h3>

<p>
    Dengan mengikuti event, peserta memberikan izin yang wajar
    atas penggunaan dokumentasi tersebut sepanjang tidak bertentangan
    dengan hukum yang berlaku.
</p>
```

</section>

<section id="privasi">
    <h2>16. Data Pribadi dan Privasi</h2>

```
<p>
    Pengumpulan, penggunaan, penyimpanan,
    pengungkapan, dan pemrosesan data pribadi pengguna
    diatur lebih lanjut dalam Kebijakan Privasi EventHub.
</p>

<p>
    Dengan menggunakan layanan EventHub,
    pengguna menyetujui pemrosesan data pribadi
    sesuai Kebijakan Privasi yang berlaku.
</p>

<p>
    EventHub berkomitmen melindungi data pribadi pengguna
    sesuai ketentuan hukum yang berlaku,
    termasuk Undang-Undang Perlindungan Data Pribadi.
</p>
```

</section>

<section id="komunikasi-elektronik">
    <h2>17. Komunikasi Elektronik</h2>

```
<p>
    Pengguna menyetujui untuk menerima komunikasi elektronik
    dari EventHub maupun penyelenggara event.
</p>

<ul>
    <li>Email.</li>
    <li>Notifikasi sistem.</li>
    <li>WhatsApp.</li>
    <li>SMS.</li>
    <li>Push Notification.</li>
    <li>Media komunikasi digital lainnya.</li>
</ul>

<p>
    Komunikasi tersebut dapat berisi informasi transaksi,
    tiket, invoice, pengingat event,
    pembaruan layanan, maupun pemberitahuan keamanan akun.
</p>

<p>
    Komunikasi dianggap telah diterima ketika dikirim
    ke alamat kontak yang terdaftar.
</p>
```

</section>

<section id="anti-fraud">
    <h2>18. Anti Fraud dan Chargeback</h2>

```
<p>
    EventHub berhak melakukan investigasi terhadap aktivitas
    yang diduga mengandung unsur:
</p>

<ul>
    <li>Penipuan.</li>
    <li>Pencucian uang.</li>
    <li>Penyalahgunaan pembayaran.</li>
    <li>Chargeback tidak sah.</li>
    <li>Penyalahgunaan tiket.</li>
    <li>Penggunaan identitas palsu.</li>
    <li>Aktivitas mencurigakan lainnya.</li>
</ul>

<h3>18.1 Tindakan yang Dapat Dilakukan</h3>

<p>
    Dalam kondisi tertentu EventHub dapat:
</p>

<ul>
    <li>Membekukan akun.</li>
    <li>Menahan dana.</li>
    <li>Membatalkan transaksi.</li>
    <li>Membatasi akses layanan.</li>
    <li>Meminta dokumen tambahan.</li>
    <li>Melaporkan kepada pihak berwenang.</li>
</ul>

<p>
    Keputusan investigasi yang dilakukan EventHub bersifat final
    sepanjang tidak bertentangan dengan hukum yang berlaku.
</p>
```

</section>

<section id="anti-money-laundering">
    <h2>19. Pencegahan Pencucian Uang dan Pendanaan Terlarang</h2>

```
<p>
    EventHub berkomitmen mendukung upaya pencegahan pencucian uang,
    pendanaan terorisme, penipuan keuangan, dan aktivitas ilegal lainnya.
</p>

<p>
    EventHub berhak melakukan pemeriksaan tambahan terhadap akun,
    transaksi, event, maupun penyelenggara yang dianggap memiliki risiko tinggi.
</p>

<p>
    EventHub dapat meminta dokumen tambahan, melakukan pembatasan akun,
    menunda pencairan dana, atau melaporkan aktivitas tertentu kepada pihak berwenang
    sesuai ketentuan hukum yang berlaku.
</p>
```

</section>

<section id="api-integrasi">
    <h2>20. API dan Integrasi Pihak Ketiga</h2>

```
<p>
    EventHub dapat menyediakan API, webhook, maupun integrasi dengan layanan pihak ketiga
    untuk mendukung operasional pengguna.
</p>

<h3>20.1 Penggunaan API</h3>

<p>
    Pengguna bertanggung jawab penuh atas keamanan API Key,
    Access Token, Secret Key, maupun kredensial lainnya.
</p>

<h3>20.2 Batasan Penggunaan</h3>

<p>
    Pengguna dilarang menggunakan API untuk:
</p>

<ul>
    <li>Mengganggu stabilitas sistem.</li>
    <li>Mengambil data tanpa izin.</li>
    <li>Melakukan scraping massal.</li>
    <li>Mengakses data pengguna lain tanpa otorisasi.</li>
</ul>

<h3>20.3 Perubahan API</h3>

<p>
    EventHub berhak mengubah, membatasi,
    atau menghentikan API kapan saja tanpa kewajiban kompensasi.
</p>
```

</section>

<section id="larangan-penggunaan">
    <h2>21. Larangan Penggunaan</h2>

```
<p>
    Pengguna dilarang menggunakan layanan EventHub untuk tujuan yang melanggar hukum,
    merugikan pihak lain, atau mengganggu operasional Platform.
</p>

<p>
    Termasuk namun tidak terbatas pada:
</p>

<ul>
    <li>Menyebarkan malware, virus, trojan, ransomware, atau kode berbahaya lainnya.</li>
    <li>Melakukan hacking atau percobaan akses tanpa izin.</li>
    <li>Melakukan scraping tanpa izin tertulis.</li>
    <li>Menggunakan identitas palsu.</li>
    <li>Menyalahgunakan data peserta.</li>
    <li>Menjual kembali tiket secara ilegal.</li>
    <li>Mengunggah konten yang melanggar hukum.</li>
    <li>Melakukan spam atau phishing.</li>
    <li>Menyebarkan ujaran kebencian, pornografi, atau konten terlarang lainnya.</li>
</ul>
```

</section>

<section id="hak-kekayaan-intelektual">
    <h2>22. Hak Kekayaan Intelektual</h2>

```
<p>
    Seluruh sistem, desain, logo, nama dagang, database,
    perangkat lunak, kode program, tampilan antarmuka,
    dan materi lain yang terdapat pada Platform merupakan milik EventHub
    atau pihak yang memberikan lisensi kepada EventHub.
</p>

<p>
    Pengguna tidak diperkenankan:
</p>

<ul>
    <li>Menyalin sistem.</li>
    <li>Melakukan reverse engineering.</li>
    <li>Mendistribusikan ulang kode program.</li>
    <li>Menggunakan logo atau merek tanpa izin.</li>
    <li>Memodifikasi layanan tanpa persetujuan tertulis.</li>
</ul>
```

</section>

<section id="user-generated-content">
    <h2>23. User Generated Content</h2>

```
<p>
    Pengguna tetap memiliki hak atas konten yang diunggah ke Platform.
</p>

<p>
    Dengan mengunggah konten, pengguna memberikan hak kepada EventHub
    untuk menyimpan, memproses, menampilkan, mendistribusikan,
    dan menggunakan konten tersebut sejauh diperlukan
    untuk penyediaan layanan.
</p>

<h3>23.1 Tanggung Jawab Konten</h3>

<p>
    Pengguna bertanggung jawab penuh atas seluruh konten yang diunggah,
    termasuk:
</p>

<ul>
    <li>Poster event.</li>
    <li>Logo.</li>
    <li>Foto.</li>
    <li>Video.</li>
    <li>Dokumen.</li>
    <li>Deskripsi event.</li>
</ul>

<p>
    Pengguna menjamin bahwa konten tersebut tidak melanggar hak cipta,
    merek dagang, hak privasi, atau hak pihak ketiga lainnya.
</p>
```

</section>

<section id="ketersediaan-layanan">
    <h2>24. Ketersediaan Layanan</h2>

```
<p>
    EventHub berupaya menjaga layanan tetap tersedia dan berfungsi dengan baik.
</p>

<p>
    Namun EventHub tidak menjamin bahwa layanan akan:
</p>

<ul>
    <li>Selalu tersedia tanpa gangguan.</li>
    <li>Bebas kesalahan.</li>
    <li>Bebas bug.</li>
    <li>Bebas serangan siber.</li>
    <li>Selalu sesuai dengan kebutuhan setiap pengguna.</li>
</ul>

<p>
    Layanan disediakan berdasarkan prinsip
    <strong>"As Is"</strong> dan <strong>"As Available"</strong>.
</p>
```

</section>

<section id="force-majeure">
    <h2>25. Force Majeure</h2>

```
<p>
    EventHub tidak bertanggung jawab atas keterlambatan,
    gangguan, atau kegagalan layanan yang disebabkan oleh keadaan
    di luar kendali yang wajar.
</p>

<ul>
    <li>Bencana alam.</li>
    <li>Kebakaran.</li>
    <li>Banjir.</li>
    <li>Gempa bumi.</li>
    <li>Gangguan internet.</li>
    <li>Pemadaman listrik.</li>
    <li>Serangan siber.</li>
    <li>Pandemi.</li>
    <li>Kebijakan pemerintah.</li>
    <li>Perang atau kerusuhan.</li>
</ul>
```

</section>

<section id="hubungan-peserta-organizer">
    <h2>26. Hubungan antara Peserta dan Penyelenggara</h2>

```
<p>
    EventHub hanya menyediakan sarana teknologi yang mempertemukan
    peserta dan penyelenggara.
</p>

<p>
    Hubungan hukum terkait pelaksanaan event terjadi secara langsung
    antara peserta dan penyelenggara.
</p>

<p>
    EventHub bukan pihak dalam perjanjian antara peserta dan penyelenggara,
    kecuali ditentukan lain secara tertulis.
</p>
```

</section>

<section id="batasan-tanggung-jawab">
    <h2>27. Batasan Tanggung Jawab</h2>

```
<p>
    Sejauh diizinkan oleh hukum yang berlaku,
    EventHub tidak bertanggung jawab atas:
</p>

<ul>
    <li>Pembatalan event.</li>
    <li>Perubahan jadwal event.</li>
    <li>Perubahan lokasi event.</li>
    <li>Kerugian bisnis.</li>
    <li>Kehilangan keuntungan.</li>
    <li>Kehilangan data.</li>
    <li>Kerusakan perangkat pengguna.</li>
    <li>Perselisihan antara peserta dan penyelenggara.</li>
    <li>Tindakan pihak ketiga.</li>
</ul>
```

</section>

<section id="maksimum-ganti-rugi">
    <h2>28. Batas Maksimum Ganti Rugi</h2>

```
<p>
    Sejauh diizinkan oleh hukum yang berlaku,
    total tanggung jawab EventHub kepada pengguna
    tidak akan melebihi jumlah biaya layanan yang dibayarkan pengguna
    kepada EventHub dalam periode 12 (dua belas) bulan terakhir.
</p>
```

</section>

<section id="indemnification">
    <h2>29. Ganti Rugi oleh Pengguna (Indemnification)</h2>

```
<p>
    Pengguna setuju untuk membebaskan, membela,
    dan mengganti kerugian EventHub,
    afiliasi, direksi, karyawan, maupun mitra kami
    dari segala klaim, tuntutan, kerugian, biaya,
    dan kewajiban yang timbul akibat:
</p>

<ul>
    <li>Pelanggaran terhadap Syarat dan Ketentuan ini.</li>
    <li>Pelanggaran hukum.</li>
    <li>Pelanggaran hak pihak ketiga.</li>
    <li>Penyalahgunaan layanan.</li>
    <li>Konten yang diunggah pengguna.</li>
</ul>
```

</section>

<section id="suspend-account">
    <h2>30. Penangguhan dan Penghapusan Akun</h2>

```
<p>
    EventHub berhak menangguhkan, membatasi,
    atau menghapus akun pengguna apabila:
</p>

<ul>
    <li>Melanggar ketentuan ini.</li>
    <li>Melanggar hukum.</li>
    <li>Menimbulkan risiko keamanan.</li>
    <li>Menimbulkan risiko hukum.</li>
    <li>Terlibat aktivitas penipuan.</li>
    <li>Menyalahgunakan layanan.</li>
</ul>

<p>
    Tindakan tersebut dapat dilakukan tanpa pemberitahuan sebelumnya
    apabila dianggap diperlukan untuk menjaga keamanan sistem,
    pengguna lain, atau kepentingan hukum.
</p>
```

</section>

<section id="pajak-organizer">
    <h2>31. Pajak dan Kewajiban Finansial</h2>

```
<p>
    Penyelenggara bertanggung jawab atas seluruh kewajiban perpajakan,
    retribusi, biaya perizinan, dan kewajiban finansial lainnya
    yang timbul akibat penyelenggaraan event.
</p>

<p>
    EventHub tidak bertanggung jawab atas kewajiban perpajakan
    yang menjadi tanggung jawab penyelenggara.
</p>
```

</section>

<section id="pengalihan-bisnis">
    <h2>32. Pengalihan Bisnis</h2>

```
<p>
    Dalam hal terjadi merger, akuisisi,
    restrukturisasi perusahaan,
    penjualan aset,
    atau transaksi korporasi lainnya,
    hak dan kewajiban berdasarkan Syarat dan Ketentuan ini
    dapat dialihkan kepada pihak penerus yang sah.
</p>
```

</section>

<section id="kepatuhan-hukum">
    <h2>33. Kepatuhan Hukum</h2>

```
<p>
    Pengguna wajib mematuhi seluruh peraturan perundang-undangan
    yang berlaku di Indonesia.
</p>

<ul>
    <li>Undang-Undang Perlindungan Data Pribadi.</li>
    <li>Undang-Undang Informasi dan Transaksi Elektronik.</li>
    <li>Peraturan Penyelenggara Sistem Elektronik.</li>
    <li>Peraturan Perdagangan Elektronik.</li>
    <li>Peraturan Perpajakan.</li>
    <li>Peraturan lainnya yang berlaku.</li>
</ul>
```

</section>

<section id="perubahan-ketentuan">
    <h2>34. Perubahan Syarat dan Ketentuan</h2>

```
<p>
    EventHub berhak memperbarui atau mengubah Syarat dan Ketentuan ini
    sewaktu-waktu.
</p>

<p>
    Perubahan akan dipublikasikan melalui Platform
    dan berlaku sejak tanggal yang ditentukan.
</p>

<p>
    Penggunaan layanan setelah perubahan dipublikasikan
    dianggap sebagai persetujuan terhadap versi terbaru.
</p>
```

</section>

<section id="hukum-berlaku">
    <h2>35. Hukum yang Berlaku dan Penyelesaian Sengketa</h2>

```
<p>
    Syarat dan Ketentuan ini tunduk pada hukum Republik Indonesia.
</p>

<p>
    Setiap sengketa yang timbul akan diselesaikan terlebih dahulu
    melalui musyawarah untuk mufakat.
</p>

<p>
    Apabila tidak tercapai kesepakatan,
    sengketa akan diselesaikan melalui pengadilan
    yang berwenang di Indonesia.
</p>
```

</section>

<section id="kontak">
    <h2>36. Kontak</h2>

```
<p>
    Apabila Anda memiliki pertanyaan mengenai Syarat dan Ketentuan ini,
    silakan menghubungi:
</p>

<p>
    <strong>EventHub Web ID</strong><br>
    Website: https://eventhub.web.id<br>
    Email: support@eventhub.web.id
</p>

<p>
    Dengan menggunakan layanan EventHub,
    Anda menyatakan telah membaca, memahami,
    dan menyetujui seluruh isi Syarat dan Ketentuan ini.
</p>
```

</section>


```

</div>

            </div>
        </div>
    </section>
@endsection
