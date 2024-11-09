@extends('layouts.main')

@section('content')
    {{-- Form Pencarian --}}

    <div class="header-wave">
        <!--Content before waves-->
        <div class="inner-header-search flex">
            <div class="wave-content w-100">
                <h1>Pengumuman Lomba Esai 2024</h1>
            </div>
        </div>
        <!--Waves end-->
    </div>

    <section class="container mt-0 pt-5 px-3">
        <p class="text-article">
            Dengan penuh kebanggaan, kami mengumumkan para pemenang <b>Lomba Esai Nasional 2024</b> yang telah berhasil
            menunjukkan
            kemampuan luar biasa dalam menuangkan ide, pemikiran, dan visi mereka melalui setiap kata yang ditulis. Setiap
            karya yang diterima menginspirasi dan membuka wawasan baru, menjadikan lomba ini lebih dari sekadar kompetisi,
            tetapi sebuah perjalanan pengetahuan dan kreativitas.
        </p>
        <p class="text-article">
            Setelah melalui proses penjurian yang sangat ketat dan penuh pertimbangan, kami dengan bangga mengumumkan para
            pemenang untuk kategori Juara 1, 2, 3, Juara harapan 1, Juara harapan 2 serta daftar 10 Esai Terbaik.
        </p>

        <div class="mt-2">
            <h5>Daftar Juara</h5>
        </div>
        <div class="table-responsive text-article">
            <table class="table table-bordered table-striped">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th scope="col" style="min-width: 120px">Juara</th>
                        <th scope="col" style="min-width: 180px">Nama</th>
                        <th scope="col" style="min-width: 220px">Asal Instansi</th>
                        <th scope="col" style="min-width: 150px">Total Point</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($juara as $data_juara)
                        <tr>
                            <th scope="row" class="text-success">{{ $data_juara['Rank'] }}</th>
                            <td>{{ $data_juara['Column5'] }}</td>
                            <td>{{ $data_juara['Column8'] }}</td>
                            <td>{{ $data_juara['Column17'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <h5>Daftar 10 esai terbaik</h5>
        </div>
        <div class="table-responsive text-article">
            <table class="table table-bordered table-striped">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th scope="col" style="min-width: 180px">Nama</th>
                        <th scope="col" style="min-width: 220px">Asal Instansi</th>
                        <th scope="col" style="min-width: 150px">Total Point</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($terbaik as $esaiterbaik)
                        <tr>
                            <td>{{ $esaiterbaik['Column5'] }}</td>
                            <td>{{ $esaiterbaik['Column8'] }}</td>
                            <td>{{ $esaiterbaik['Column17'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mb-2 mt-3">
            <small><i class="text-danger">* Peserta akan mendapatkan sertifikat penghargaan untuk kategori 10 esai
                    terbaik</i></small>
        </div>

        {{-- Yang bisa dilakukan eventconnect.id --}}
        <p class="text-article">
            Kami ingin mengucapkan selamat kepada seluruh pemenang yang telah berhasil menunjukkan kualitas pemikiran yang
            luar biasa. Untuk para peserta lainnya, kami sangat menghargai setiap usaha dan kreativitas yang telah
            diberikan. <i>Karya Anda semua membuka jalan untuk perubahan dan kemajuan, dan kami yakin potensi besar Anda
                akan
                terus berkembang</i>.
        </p>
        <p class="text-article">
            Teruslah berkarya, teruslah menulis, dan jangan pernah berhenti berbagi ide! Terima kasih atas partisipasi kamu
            dalam Lomba Esai Nasional Eventconnect 2024. Sampai jumpa di lomba berikutnya!
        </p>
        <p>Sebagai bahan motivasi yuk cek nilai kamu!! <button class="btn btn-success" id="redirect-score">Cek
                point disini</button></p>

        <div class="mb-2">
            <small><i class="text-danger">* Note : Untuk seluruh peserta, sertifikat akan tersedia mulai 10 November 2024,
                    terimakasih.</i></small>
        </div>
        <p class="mb-0 mt-4">
            Salam,
        </p>
        <h5 class="m-0 p-0">Tim Eventconnect</h5>

    </section>


    @push('js-download')
        <script>
            $(document).ready(function() {
                $('#redirect-score').click(function() {
                    window.location.href = '/essay-announcement-2024/score';
                });
            });
        </script>
    @endpush
@endsection
