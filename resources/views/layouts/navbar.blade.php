<div class="container">
    <div class="logo float-left">
        <!--  <h1 class="text-light"><a href="index.html"><span>Mediaprestasi</span></a></h1> -->
        <!-- Uncomment below if you prefer to use an image logo -->
        <a href="/"><img src="/assets/img/eventhub-logo.png" alt="" class="img-fluid"></a>
    </div>

    <nav class="nav-menu float-right d-none d-lg-block">
        <ul>
            <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="/">Home</a></li>
            <li class="{{ Request::is('about-us') ? 'active' : '' }}"><a href="/about-us">About us</a></li>
            <li class="{{ Request::is('event*') ? 'active' : '' }}"><a href="/event/create">Create event</a></li>
            <li class="{{ Request::is('creator-guide') ? 'active' : '' }}"><a href="/creator-guide">Guide</a></li>
            <li class="{{ Request::is('blog*') ? 'active' : '' }}"><a href="/blog">Blog</a></li>
            <li class="{{ Request::is('pricing') ? 'active' : '' }}"><a href="/pricing">Pricing</a></li>

            {{-- <li class="drop-down"><a href="">Layanan</a>
                <ul>
                    <li><a href="#">Layanan</a></li>
                    <li><a href="#">Info kampus</a></li>
                    <li><a href="#">MP Event</a></li>
                    <li><a href="#">Beasiswa</a></li>
                    <li><a href="#">lomba</a></li>
                </ul>
            </li> --}}


            @if (Auth::check())
                <li style="position: relative;top: -7px; padding: 1; margin: 0; "><a href="/dashboard"
                        class=" link-login-register"><button class="btn btn-success w-100 mr-4 py-1"><i
                                class="fas fa-user mr-1"></i> {{ auth()->user()->name }}</button></a>
                </li>
            @else
                <li style="position: relative;top: -7px; padding: 0; margin: 0;"><a href="/login"
                        class=" link-login-register"><button
                            class="btn btn-success btn-large w-100 px-3 mr-4 py-1">Login</button></a>
                </li>
                <li style="position: relative;top: -7px; padding: 0; margin: 0;"><a href="/register"
                        class="link-login-register"><button class="btn btn-large w-100 px-0 py-1">Daftar</button></a>
                </li>
            @endif

        </ul>
    </nav><!-- .nav-menu -->
</div>
