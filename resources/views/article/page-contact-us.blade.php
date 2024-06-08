@extends('layouts.main')

@section('content')
    {{-- Form Pencarian --}}

    <div class="header-wave">
        <!--Content before waves-->
        <div class="inner-header-search flex">
            <div class="wave-content w-100">
                <h1>Hubungi kami</h1>
            </div>
        </div>
        <!--Waves end-->
    </div>

    <section class="container mt-0 pt-5 px-1">
        <div class="card mb-3 mx-1 shadow">
            <div class="card-body p-4">

                <div class="mt-2">
                    <article class="text-article">
                        Kami senang mendengar dari kamu. Apakah kamu memiliki pertanyaan, masukan, atau hanya ingin menyapa
                        kami? Jangan ragu untuk mengirim pesan kepada tim kami menggunakan formulir di bawah ini. Kami
                        berusaha untuk merespons setiap pesan secepat mungkin. Terima kasih atas dukungan Anda!
                    </article>
                </div>
                <hr>
                <div>
                    <form id="form-contact-us" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="email@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama kamu</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Masukan nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="subjek" class="form-label">subjek</label>
                            <input type="text" class="form-control" id="subjek" name="subjek" placeholder=""
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan</label>
                            <textarea class="form-control" id="message" name="message" required rows="3"></textarea>
                        </div>
                        <button type="submit" id="btn-send-msg" class="btn btn-success w-100">Kirim pesan</button>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
