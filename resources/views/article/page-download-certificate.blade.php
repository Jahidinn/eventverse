@extends('layouts.main')

@section('content')
    {{-- Form Pencarian --}}

    <div class="header-wave">
        <!--Content before waves-->
        <div class="inner-header-search flex">
            <div class="wave-content w-100">
                <h1>Download Page</h1>
            </div>
        </div>
        <!--Waves end-->
    </div>

    <section class="container mt-0 pt-5 px-3">
        <p class="text-article">
            Download sertifikat <b>Lomba POSTER Nasional 2024</b>
        </p>

        {{-- Yang bisa dilakukan eventconnect.id --}}
        <div>
            <form>
                <div class="form-group">
                    <label for="exampleInputEmail1">Jenis sertifikat</label>
                    <select class="form-control" id="sertifikat-type">
                        <option value="participant">SERTIFIKAT PESERTA</option>
                        <option value="best10">SERTIFIKAT 10 TERBAIK</option>
                        <option value="best5">SERTIFIKAT JUARA</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">ID Pendaftaran</label>
                    <input type="text" required class="form-control" id="sertifikat-id" placeholder="ID">
                </div>

                <button type="submit" id="download-sertifikat" class="btn btn-primary"><i class="fas fa-download"></i>
                    Download
                    Seritikat</button>
        </div>
        </form>

    </section>

    @push('js-download')
        <script src="{{ asset('assets/js/download.js') }}"></script>
    @endpush
@endsection
