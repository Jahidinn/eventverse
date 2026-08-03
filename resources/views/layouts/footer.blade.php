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
                    <li><i class="bx bx-chevron-right"></i> <a href="/about-us">Tentang eventverse.id</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/terms-and-condition">Terms and condition</a>
                    </li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/privacy-policy">Privacy policy</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/faq">FAQ</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 footer-links">
                <h4>Layanan</h4>
                <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="/event/create">Sharing event</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/dashboard">Manajemen event</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/dashboard">Ticketing</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/blog">Blog</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/id/event">Event organizer</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 footer-contact">
                <h4>Contact</h4>
                <p>
                    Jl Mijen permai, mijen permai/BSB city,
                    Kota Semarang, Pos 50219
                    Indonesia <br><br>
                    <strong>Phone:</strong> +62 896 123 94600<br>
                    <strong>Email:</strong> info@eventverse.id<br>
                    <a href="/blog/contact-us" class="btn bg-blue btn-sm text-white mt-2">contact us</a>
                </p>

            </div>

            <div class="col-lg-3 col-md-6 footer-info">
                <h3>About eventverse.id</h3>
                <p>Eventverse.id merupaan platform Ticketing Management Sistem yang
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
        &copy; Copyright <strong><span>www.eventverse.id</span></strong>. All Rights Reserved
    </div>
    <!-- All the links in the footer should remain intact. -->
    <!-- You can delete the links only if you purchased the pro version. -->
    <!-- Licensing information: https://bootstrapmade.com/license/ -->
</div>
