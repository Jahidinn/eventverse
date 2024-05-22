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
            <div class="card-body p-3">

                {{-- Pilihan TAB --}}
                <div class="col-md-12 row tabs mb-4">
                    <div class="col px-0">
                        <button class="tab-link current w-100 m-0 py-2" data-tab="show-tiket">Penyelenggara</button>
                    </div>
                    <div class="col p-0">
                        <button class="tab-link w-100 py-2" data-tab="show-deskripsi">Peserta</button>
                    </div>
                </div>

                {{-- Tab ticket event --}}
                <div id="show-tiket" class="tab-content current p-0">
                    <h6 class="card-title"><b>Syarat & ketentuan untuk penyelenggara</b></h6>


                    {{-- Dari database --}}

                    <p>
                    <article>
                        hggftf
                    </article>
                    </p>
                    <p class="card-text"><small class="text-muted"></small></p>
                </div>

                {{-- Tab deskripsi --}}
                <div id="show-deskripsi" class="tab-content p-0">

                    {{-- Dari database --}}


                    <h6 class="card-title"><b>Syarat & ketentuan untuk peserta</b></h6>
                    <p class="card-text">
                    <article>
                        hggftft
                    </article>
                    </p>

                </div>

            </div>
        </div>
    </section>
@endsection
