@extends('layouts.main')

@section('content')
    {{-- Form Pencarian --}}

    <div class="header-wave">
        <!--Content before waves-->
        <div class="inner-header-search flex">
            <div class="wave-content w-100">
                <h1>Chek your score here!</h1>
            </div>
        </div>
        <!--Waves end-->
    </div>

    <section class="container mt-0 pt-5 px-3">
        <p class="text-article">
            <b>Masukan ID pendaftaran kamu ya!</b>
        </p>
        <form id="search-score-form">
            <div class="form-group">
                <label for="id-pendaftaran">ID Pendaftaran</label>
                <input type="text" required class="form-control" id="id-pendaftaran" placeholder="ID">
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>
                Lihat data</button>
        </form>

        <div class="alert alert-warning mt-2" id="alert-nodata" role="alert" style="display: none">
            Tidak ada data!
        </div>

        <div class="table-responsive mt-3" style="display: none">
            <table class="table table-bordered table-striped">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th scope="col">FORM</th>
                        <th scope="col">DATA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">ID</th>
                        <td id="score-id">-</td>
                    </tr>
                    <tr>
                        <th scope="row">Nama</th>
                        <td id="score-name">-</td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td id="score-email">-</td>
                    </tr>
                    <tr>
                        <th scope="row">Instansi</th>
                        <td id="score-instansi">-</td>
                    </tr>
                    <tr>
                        <th scope="row">Score 1</th>
                        <td id="score-1">-</td>
                    </tr>
                    <tr>
                        <th scope="row">Score 2</th>
                        <td id="score-2">-</td>
                    </tr>
                    <tr>
                        <th scope="row">Score 3</th>
                        <td id="score-3">-</td>
                    </tr>
                    <tr>
                        <th scope="row">Score 4</th>
                        <td id="score-4">-</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-success">TOTAL SCORE</th>
                        <th scope="row" class="text-success" id="score-total">-</th>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Yang bisa dilakukan eventconnect.id --}}
        <div class="alert alert-primary mt-3" role="alert">
            Informasi score!
        </div>
        <ul>
            <li><b>Score 1</b> (Kreativitas gagasan)</li>
            <li><b>Score 2</b> (Kesesuaian dengan tema)</li>
            <li><b>Score 3</b> (Orisinalitas dan kebermanfaatan gagasan)</li>
            <li><b>Score 4</b> (Teknik penulisan dan penyajian data)</li>
        </ul>

    </section>

    @push('js-download')
        <script>
            $(document).ready(function() {
                $('#redirect-score').click(function() {
                    window.location.href = '/essay-announcement-2024/score';
                });
                $('.table-responsive').hide();
                $('#alert-nodata').hide();

                // search ajax 
                $('#search-score-form').submit(function(e) {
                    // Mencegah form disubmit secara biasa
                    e.preventDefault();
                    const query = $('#id-pendaftaran').val();

                    // Lakukan request AJAX
                    $.ajax({
                        url: '/essay-announcement-2024/check-score', // Ganti dengan URL tujuan
                        type: 'GET', // Metode request POST untuk mengirim data
                        data: {
                            query: query // Kirim data ke server dengan key "pendaftaran_id"
                        },
                        dataType: 'json', // Menyatakan tipe data yang diterima adalah JSON
                        success: function(response) {
                            // Menampilkan response jika request berhasil
                            $('#responseMessage').html('<p>Data berhasil dikirim!</p>');
                            console.log(response); // Mencetak response di konsol
                            if (response) {
                                $('.table-responsive').show();
                                $('#alert-nodata').hide();

                                $('#score-id').html(response.Column4);
                                $('#score-name').html(response.Column5);
                                $('#score-email').html(response.Column6);
                                $('#score-instansi').html(response.Column8);
                                $('#score-1').html(response.SCORE);
                                $('#score-2').html(response.Column14);
                                $('#score-3').html(response.Column15);
                                $('#score-4').html(response.Column16);
                                $('#score-total').html(response.Column17);
                            } else {
                                $('.table-responsive').hide();
                                $('#alert-nodata').show();
                            }
                        },
                        error: function(xhr, status, error) {
                            // Menampilkan pesan kesalahan jika request gagal
                            $('#responseMessage').html(
                                '<p>Terjadi kesalahan, data gagal dikirim.</p>');
                            console.log('Error: ' + error);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
