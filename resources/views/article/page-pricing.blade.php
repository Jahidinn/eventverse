@extends('layouts.main')

@section('content')

<div class="header-wave">

    <div class="inner-header-search flex">

        <div class="wave-content w-100">

            <h1>Biaya Transaksi</h1>

            <p class="text-white mt-2 mb-0">
                Eventverse gratis digunakan. Biaya transaksi hanya dikenakan saat pembeli berhasil melakukan pembayaran.
            </p>

        </div>

    </div>

</div>

<section class="pricing-section py-5">

    <div class="container">

        <div class="row align-items-start">

            <div class="col-lg-8">

                <div class="pricing-intro-card mb-4">

                    <span class="pricing-badge">

                        GRATIS DIGUNAKAN

                    </span>

                    <h5 class="mt-3">

                        Gunakan Eventverse Tanpa Biaya Berlangganan

                    </h5>

                    <p class="mb-0">

                        Eventverse dapat digunakan secara <strong>gratis</strong> untuk membuat,
                        mengelola, dan mempublikasikan event.

                        Biaya hanya dikenakan ketika peserta berhasil melakukan pembayaran
                        tiket sesuai metode pembayaran yang dipilih.

                    </p>

                </div>

                <div class="section-heading mb-3 pl-4">

                    <h5>

                        Biaya Transaksi Pembayaran

                    </h5>

                    <p>

                        Biaya transaksi dibebankan kepada pembeli dan sudah mencakup
                        <strong>Platform Fee Eventverse</strong>
                        serta
                        <strong>Biaya Admin Payment Gateway.</strong>

                    </p>

                </div>

                <div class="pricing-card">

                    <div class="pricing-header">

                        <div>

                            <h5>

                                QRIS, GoPay, ShopeePay, LinkAja

                            </h5>

                            <small>

                                Rekomendasi untuk biaya transaksi yang lebih efisien.

                            </small>

                        </div>

                        <span class="pricing-value">

                            3%

                        </span>

                    </div>

                </div>

                <div class="pricing-card">

                    <div class="pricing-header">

                        <div>

                            <h5>

                                Virtual Account & Bank Transfer

                            </h5>

                            <small>

                                Berlaku untuk seluruh Virtual Account dan transfer bank.

                            </small>

                        </div>

                        <span class="pricing-value">

                            1,5% + Rp4.500

                        </span>

                    </div>

                </div>

                <div class="pricing-card">

                    <div class="pricing-header">

                        <div>

                            <h5>

                                Kartu Kredit & Metode Pembayaran Lainnya

                            </h5>

                            <small>

                                Menyesuaikan metode pembayaran yang dipilih pembeli.

                            </small>

                        </div>

                        <span class="pricing-value">

                            2,5% + Rp2.500

                        </span>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="pricing-side-card">

                    <h5>

                        Yang Perlu Diketahui

                    </h5>

                    <ul>

                        <li>

                            Eventverse <strong>gratis digunakan</strong>.

                        </li>

                        <li>

                            Tidak ada biaya pendaftaran maupun biaya bulanan.

                        </li>

                        <li>

                            Biaya transaksi dibebankan kepada pembeli.

                        </li>

                        <li>

                            Biaya transaksi terdiri dari
                            <strong>Platform Fee Eventverse</strong>
                            dan
                            <strong>Biaya Admin Payment Gateway.</strong>

                        </li>

                        <li>

                            <strong>Platform Fee Eventverse sudah termasuk PPN.</strong>

                        </li>

                        <li>

                            <strong>Pajak Hiburan (PBJT)</strong>, apabila berlaku sesuai
                            ketentuan pemerintah daerah, <strong>belum termasuk</strong>
                            dalam biaya transaksi.

                        </li>

                    </ul>

                    <a href="#simulasi-pembayaran" class="btn bg-blue text-white w-100">

                        Lihat Simulasi Biaya

                        <i class="fas fa-arrow-right ms-2"></i>

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

<section class="pricing-simulation-section py-2" id="simulasi-pembayaran">
    <div class="container">
        <div class="section-heading mb-4 text-center">
            <h5>Simulasi Biaya Transaksi</h5>
            <p>Contoh perhitungan biaya transaksi sesuai metode pembayaran.</p>
        </div>

        <div class="simulation-card modern-card">
            <div class="simulation-header">
                <span class="pricing-badge">CONTOH KASUS</span>
                <h5 class="mt-3 mb-2">Smart Education</h5>
                <p class="mb-0">Event <strong>Lomba Karya Tulis Ilmiah (LKTIN)</strong> dengan harga tiket <strong>Rp50.000</strong>.</p>
            </div>

            <div class="simulation-table mt-4">
                <table class="table table-borderless align-middle mb-0">
                    <tbody>
                        <tr><td>Harga Tiket</td><td class="text-end"><strong>Rp50.000</strong></td></tr>
                        <tr><td>Jumlah Tiket Dibeli</td><td class="text-end"><strong>2 Tiket</strong></td></tr>
                        <tr><td>Total Harga Tiket</td><td class="text-end"><strong>Rp100.000</strong></td></tr>
                        <tr><td>Metode Pembayaran</td><td class="text-end">QRIS</td></tr>
                        <tr><td>Biaya Transaksi (3%)</td><td class="text-end text-danger">+ Rp3.000</td></tr>
                        <tr class="simulation-total">
                            <td>Total Dibayar Pembeli</td><td class="text-end"><strong>Rp103.000</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="alert alert-success mt-4">
                <h6>Dana yang Diterima Penyelenggara</h6>
                <p class="mb-2">Penyelenggara tetap menerima hasil penjualan tiket sebesar:</p>
                <h3 class="mb-0">Rp100.000</h3>
            </div>

            <div class="alert alert-light border mt-3">
                <h6>Informasi Penting</h6>
                <ul class="mb-0">
                    <li>Biaya transaksi dibebankan kepada pembeli.</li>
                    <li>Sudah mencakup <strong>Platform Fee Eventverse</strong> dan <strong>Biaya Admin Payment Gateway</strong>.</li>
                    <li>Platform Fee Eventverse <strong>sudah termasuk PPN</strong>.</li>
                    <li>Pajak Hiburan (PBJT) <strong>belum termasuk</strong>.</li>
                </ul>
            </div>

            <div class="text-center mt-4">
                <a href="/register" class="btn bg-blue text-white px-4">Mulai Gratis</a>
            </div>
        </div>
    </div>
</section>


<section class="pricing-faq-section py-5">

    <div class="container ">

        <div class="section-heading text-center mb-5">

            <h4>

                Pertanyaan yang Sering Diajukan

            </h4>

            <p>

                Berikut beberapa pertanyaan yang sering ditanyakan oleh penyelenggara event mengenai biaya transaksi di Eventverse.

            </p>

        </div>

        <div class="pricing-faq modern-card mt-5">

            <div id="pricingFaq">

                <div class="card mb-3">

                    <div class="card-header p-0" id="headingOne">

                        <button
                            class="btn btn-link btn-block text-left pricing-faq-btn"
                            data-toggle="collapse"
                            data-target="#collapseOne"
                            aria-expanded="true"
                            aria-controls="collapseOne">

                            Apakah Eventverse benar-benar gratis digunakan?

                            <i class="fas fa-chevron-down float-right"></i>

                        </button>

                    </div>

                    <div
                        id="collapseOne"
                        class="collapse show"
                        data-parent="#pricingFaq">

                        <div class="card-body">

                            Ya. Eventverse dapat digunakan secara gratis tanpa biaya
                            pendaftaran maupun biaya berlangganan.

                        </div>

                    </div>

                </div>

                <div class="card mb-3">

                    <div class="card-header p-0">

                        <button
                            class="btn btn-link btn-block text-left pricing-faq-btn collapsed"
                            data-toggle="collapse"
                            data-target="#collapseTwo">

                            Siapa yang membayar biaya transaksi?

                            <i class="fas fa-chevron-down float-right"></i>

                        </button>

                    </div>

                    <div
                        id="collapseTwo"
                        class="collapse"
                        data-parent="#pricingFaq">

                        <div class="card-body">

                            Biaya transaksi dibebankan kepada pembeli sesuai metode pembayaran yang dipilih.

                        </div>

                    </div>

                </div>

                <div class="card mb-3">

                    <div class="card-header p-0">

                        <button
                            class="btn btn-link btn-block text-left pricing-faq-btn collapsed"
                            data-toggle="collapse"
                            data-target="#collapseThree">

                            Apa saja yang termasuk biaya transaksi?

                            <i class="fas fa-chevron-down float-right"></i>

                        </button>

                    </div>

                    <div
                        id="collapseThree"
                        class="collapse"
                        data-parent="#pricingFaq">

                        <div class="card-body">

                            Biaya transaksi terdiri dari Platform Fee Eventverse
                            dan Biaya Admin Payment Gateway.

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="pricing-cta mt-5 modern-card">

            <div class="pricing-cta-card">

                <span class="pricing-badge">

                    SIAP MEMULAI?

                </span>

                <h5 class="mt-3">

                    Kelola Event Lebih Mudah Bersama Eventverse

                </h5>

                <p>

                    Mulai membuat event secara gratis, kelola peserta,
                    ticketing, pembayaran online, QR Code Check-in,
                    sertifikat digital, hingga dashboard analitik dalam
                    satu platform.

                </p>

                <div class="pricing-action">

                    <a href="/register" class="btn bg-blue text-white">

                        Mulai Gratis

                    </a>

                    <a href="/about-us" class="btn btn-outline-primary ms-2">

                        Pelajari Eventverse

                    </a>

                </div>

            </div>

        </div>

        <div class="pricing-disclaimer mt-5">

            <small class="text-muted">

                <strong>Catatan:</strong>
                Informasi biaya transaksi pada halaman ini dapat berubah
                sewaktu-waktu mengikuti kebijakan penyedia payment gateway,
                perubahan regulasi perpajakan, maupun pengembangan layanan
                Eventverse. Besaran Pajak Hiburan (PBJT), apabila berlaku,
                mengikuti ketentuan pemerintah daerah sesuai lokasi
                penyelenggaraan event.

            </small>

        </div>

    </div>

</section>

<style>
    /* ===========================================================
   Pricing Page
=========================================================== */

.pricing-section, .pricing-simulation-section, .pricing-faq-section {

    background: #f8fafc;

}

.section-heading h5{

    font-weight:700;

    color:#1e293b;

    margin-bottom:8px;
    font-size: 20px;

}

.section-heading p{

    color:#64748b;

    margin-bottom:0;

    line-height:1.7;
    font-size: 14px;

}

/* ===========================================================
   Intro
=========================================================== */

.pricing-intro-card{

    background:#fff;

    border-radius:24px;

    padding:35px;

    border:1px solid #e2e8f0;

    box-shadow:0 12px 35px rgba(15,23,42,.05);

}

.pricing-intro-card h5{

    font-size:20px;

    font-weight:700;

    color:#0f172a;

    margin-bottom:18px;

}

.pricing-intro-card p{

    color:#64748b;

    line-height:1.7;

    margin-bottom:0;
    font-size: 14px;

}

/* ===========================================================
   Badge
=========================================================== */

.pricing-badge{

    display:inline-flex;

    align-items:center;

    gap:8px;

    background:#dcfce7;

    color:#15803d;

    padding:8px 16px;

    border-radius:999px;

    font-size:11px;

    font-weight:600;

    letter-spacing:.5px;

    text-transform:uppercase;

}

/* ===========================================================
   Pricing Card
=========================================================== */

.pricing-card{

    background:#fff;

    border:1px solid #e2e8f0;

    border-radius:20px;

    margin-bottom:15px;

    transition:.3s;

    overflow:hidden;

}

.pricing-card:hover{

    transform:translateY(-4px);

    box-shadow:0 18px 40px rgba(15,23,42,.08);

}

.pricing-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:24px 28px;

    gap:20px;

}

.pricing-header h5{

    margin:0;

    font-size:16px;

    font-weight:700;

    color:#0f172a;

}

.pricing-header small{

    display:block;

    margin-top:6px;

    color:#64748b;

    font-size:14px;

}

.pricing-value{

    white-space:nowrap;

    background: #eff6ff;

    color: #2179e4;

    font-size:16px;

    font-weight:700;

    padding:12px 18px;

    border-radius:12px;

}

/* ===========================================================
   Sidebar
=========================================================== */

.pricing-side-card{

    position:sticky;

    top:100px;

    background:#fff;

    border-radius:24px;

    padding:30px;

    border:1px solid #e2e8f0;

    box-shadow:0 12px 35px rgba(15,23,42,.05);

}

.pricing-side-card h5{

    font-weight:700;

    margin-bottom:20px;


}

.pricing-side-card ul{

    list-style:none;

    padding:0;

    margin:0 0 25px;

}

.pricing-side-card li{

    position:relative;

    padding-left:28px;

    margin-bottom:16px;

    color:#475569;

    line-height:1.8;
    font-size: 15px;

}

.pricing-side-card li::before{

    content:"✓";

    position:absolute;

    left:0;

    top:2px;

    width:20px;

    height:20px;

    border-radius:50%;

    background:#dcfce7;

    color:#16a34a;

    font-size:12px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-weight:bold;

}

.pricing-side-card .btn{

    border-radius:12px;

    padding:13px;

    font-weight:600;

}

/* ==========================
   FAQ
========================== */

.pricing-faq .card{

    border:none;

    border-radius:18px;

    overflow:hidden;

    box-shadow:0 8px 30px rgba(15,23,42,.06);

    margin-bottom:18px;

}

.pricing-faq .card-header{

    background:#fff;

    border:none;

}

.pricing-faq-btn{

    color: #1e293b !important;

    font-weight:600;

    font-size:16px;

    padding:22px 24px;

    text-decoration:none !important;

}

.pricing-faq-btn:hover{

    background:#f8fafc;

    text-decoration:none;

}

.pricing-faq-btn:focus{

    box-shadow:none;

}

.pricing-faq .card-body{

    color:#64748b;

    line-height:1.8;

    padding:0 24px 24px;

}

.pricing-faq-btn i{

    transition:.3s;

}

.pricing-faq-btn:not(.collapsed) i{

    transform:rotate(180deg);

}

.pricing-cta-card p{
     color:#64748b;

    line-height:1.7;

    margin-bottom:20px;
    font-size: 14px;

}

.modern-card {
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:24px;
    padding:30px;
    box-shadow:0 12px 35px rgba(15,23,42,.05);
    transition:.3s;
}
.modern-card:hover {
    transform:translateY(-4px);
    box-shadow:0 18px 40px rgba(15,23,42,.08);
}
.simulation-total td {
    font-weight:700;
    color:#0f172a;
}
.btn-primary {
    background: #1969ca;
    border:none;
    border-radius:12px;
    font-weight:600;
}

</style>

@endsection