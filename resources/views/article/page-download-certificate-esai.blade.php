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
            Download sertifikat <b>Lomba ESAI Nasional 2024</b>
        </p>

        {{-- Yang bisa dilakukan eventconnect.id --}}
        <div>
            <form>
                <div class="form-group">
                    <label for="exampleInputEmail1">Jenis sertifikat</label>
                    <select class="form-control" id="sertifikat-type">
                        <option value="participant1">SERTIFIKAT PESERTA 1</option>
                        <option value="participant2">SERTIFIKAT PESERTA 2</option>
                        <option value="participant3">SERTIFIKAT PESERTA 3</option>
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
        <script>
            $(document).ready(function() {
                $('#download-sertifikat').click(function(e) {
                    e.preventDefault()
                    var jenis = $('#sertifikat-type').val();
                    var id = $('#sertifikat-id').val();
                    $.ajax({
                        url: '/essay-announcement-2024/check-file',
                        method: 'GET',
                        data: {
                            jenis: jenis,
                            id: id
                        },
                        success: function(response) {
                            if (response.exists) {
                                window.location.href = '/essay-announcement-2024/download?jenis=' +
                                    response
                                    .jenis + '&id=' + response.id;
                                alertify.success('<i class="fas fa-check"></i> Download sukes!');
                            } else {
                                Swal.fire('Ooopss', 'ID peserta tidak ditemukan!!', 'error');
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
