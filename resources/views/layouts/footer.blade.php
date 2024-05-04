{{-- <div class="footer-newsletter" style="background: rgb(58, 108, 183)"> --}}
<div class="footer-newsletter">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h4>Subscribe</h4>
                <p>Subscribe biar nggak ketinggalan update event terbaru ya!</p>
            </div>
            <div class="col-lg-6">
                <form method="post" id="form-subscribe">
                    @csrf
                    <input type="email" name="email">
                    <input type="submit" id="btn-subscribe" value="Subscribe">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="footer-top">
    <div class="container">
        <div class="row">

            <div class="col-lg-3 col-md-6 footer-links">
                <h4>Link penting</h4>
                <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="/">Home</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/blog/about-us">Tentang eventconnec.id</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Layanan</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 footer-links">
                <h4>Layanan</h4>
                <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Info kampus</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Blog</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Perpustakaan</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Download</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">MP event</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 footer-contact">
                <h4>Contact</h4>
                <p>
                    Kawasan UNNES Sekaran <br>
                    Kota Semarang, Pos 50229<br>
                    Indonesia <br><br>
                    <strong>Phone:</strong> +62 821 3355 3002<br>
                    <strong>Email:</strong> info@eventconect.id<br>
                </p>

            </div>

            <div class="col-lg-3 col-md-6 footer-info">
                <h3>About eventconnect.id</h3>
                <p>Eventconnect.id merupaan platform Ticketing Management Sistem yang
                    menyediakan solusi dalam mendukung penyelenggaraan event. <a href="/blog/about-us"
                        class="text-success">selengkapnya ...</a></p>
                <div class="social-links mt-3">
                    <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                    <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                    <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="containe bg-copyright pb-4">
    <div class="copyright">2018 - {{ date('Y') }}
        &copy; Copyright <strong><span>www.eventconnect.id</span></strong>. All Rights Reserved
    </div>
    <!-- All the links in the footer should remain intact. -->
    <!-- You can delete the links only if you purchased the pro version. -->
    <!-- Licensing information: https://bootstrapmade.com/license/ -->
</div>
