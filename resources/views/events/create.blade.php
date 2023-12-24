{{-- Template header mengamil dari auth --}}
@extends('form.main')

@section('content')
    {{-- Form input --}}
    <form action="javascript:void(0)" method="post" id="form-event">
        @csrf

        <div class="container pb-3 px-0">
            <div class="row m-1">
                <div class="col-lg-3 col-md-2"></div>

                <div class="col-lg-12 formevent-title mb-2 text-white py-1 mt-4 shadow-sm">
                    BUAT EVENT
                </div>

                <div class="col-lg-12 col-md-12 formevent-box">
                    <div class="card mb-4">
                        <div class="card-body">

                            <div class="tb-container mt-0">
                                <img id="tb-image" />
                                <label for="tb-file-upload" class="shadow"><i class="fas fa-image"></i> Poster atau
                                    banner</label>
                                <input type="file" name="bannerEvent" id="tb-file-upload" accept="image/*"
                                    onchange="fileUpload(event);">
                            </div>
                            <small class="text-danger" id="image-warning" hidden>Max ukuran banner 500KB</small>

                            <div class="col-lg-12 event-form style-form">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group event-title">
                                            <input type="text" class="form-control" name="titleEvent" required
                                                placeholder="Nama Event">
                                        </div>
                                    </div>
                                    <div class="col-md-6 url">
                                        <div class="form-group input-form-group event-title">
                                            <span class="form-control-feedback url">eventconnect.id/</span>
                                            <input type="text" class="form-control mb-0" name="linkEvent" required
                                                placeholder="contoh-LINK-2023" id="url-event">

                                            {{-- Peringatan link url / slug --}}
                                            <small class="text-success" id="url-notif-success" hidden><i
                                                    class="fas fa-check"></i>
                                                Link tersedia!</small>
                                            <small class="text-danger" id="url-notif-danger" hidden><i
                                                    class="fas fa-times-circle"></i> Link sudah
                                                dipakai!</small>
                                            {{-- Peringatan link url / slug --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row event-heading">
                                    <div class="col-md-3 pr-2">

                                        <div class="form-group blocked  input-form-group">
                                            <label class="form-control-label" for="userName">PENYELENGGARA</label>
                                            <span class="fas fa-users form-control-feedback"></span>
                                            <input type="text" readonly class="form-control"
                                                value="{{ auth()->user()->name }}" id="userName" name="username_id"
                                                autocomplete="off">
                                            <input type="hidden" name="userId" value="{{ auth()->user()->id }}">
                                            <div class="form-text text-danger mt-0 pt-0">
                                                Form otomatis
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group input-form-group">
                                            <label class="form-control-label" for="kategori-event">KATEGORI EVENT</label>
                                            <span class="fas fa-list form-control-feedback"></span>
                                            <input type="text" class="form-control kategori-event" inputmode="none"
                                                id="kategori-event" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group input-form-group">
                                            <label class="form-control-label" for="lokasiEvent">LOKASI</label>
                                            <span class="fas fa-map-marker-alt form-control-feedback"></span>
                                            <input type="text" class="form-control lokasi-event" inputmode="none"
                                                id="lokasiEvent" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group input-form-group">
                                            <label class="form-control-label" for="tanggalEvent">TANGGAL EVENT</label>
                                            <span class="far fa-calendar-alt form-control-feedback"></span>
                                            <input type="text" class="form-control tanggal-event" inputmode="none"
                                                id="tanggalEvent" required>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>


                    <div class="col-md-12 py-4">
                        <div class="container p-0">
                            <div class="col-md-12 row tabs">
                                <div class="col px-0">
                                    <button class="tab-link current w-100 m-0 py-2" type="button"
                                        data-tab="tab-1">Deskripsi</button>
                                </div>
                                <div class="col p-0">
                                    <button class="tab-link w-100 py-2" type="button" data-tab="tab-2">Tiket
                                        Pendaftaran</button>
                                </div>
                            </div>
                            <hr>
                            <div id="tab-1" class="tab-content current p-0">
                                <div class="bg-secondary text-white text-center py-1 mb-2 mt-2">
                                    <strong><small>DESKRIPSI</small></strong>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group p-0">
                                            <input id="description-event" type="hidden" name="descriptionEvent"
                                                required>
                                            <trix-editor input="description-event"></trix-editor>
                                            {{-- @error('body')
											<div class="invalid-veedback text-danger">{{ $message }}</div>
										@enderror --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-secondary text-white text-center py-1 mb-2 mt-4">
                                    <strong><small>SYARAT & KETENTUAN</small></strong>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group p-0">
                                            <input id="terms" type="hidden" name="terms" required>
                                            <trix-editor input="terms" required></trix-editor>
                                            {{-- @error('body')
											<div class="invalid-veedback text-danger">{{ $message }}</div>
										@enderror --}}
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="tab-2" class="tab-content p-0">
                                <div>
                                    <div>
                                        <button type="button" class="btn btn-success mb-2 icon-class"
                                            data-bs-toggle="modal" data-bs-target="#ticketModal" id="add-ticket-modal"><i
                                                class="fas fa-plus"></i>Tambah tiket</button>
                                    </div>
                                    <div class="card  ticket-card mt-3" id="ticket-example">

                                        <div class="card-body">
                                            <small>
                                                <div class="alert alert-info w-100 py-2">
                                                    <strong>Contoh Tiket Pendaftaran</strong>
                                                </div>
                                            </small>
                                            <hr class="dashed">
                                            <p class="card-text pt-0">
                                                <small class="text-muted icon-class">
                                                    <span class="text-white">
                                                        <i class="fas fa-hourglass-end pr-4"></i>
                                                        Berakhir : <strong>12-20-2023</strong>
                                                    </span>
                                                    <span class="alert alert-info py-1 px-2 ms-2">
                                                        <strong>Kuota : 100</strong>
                                                        <input type="hidden">
                                                    </span>
                                                </small>
                                            </p>
                                            <hr class="dashed">
                                            <div class="row">
                                                <div class="col">
                                                    <span class="badge bg-secondary py-2 rounded-0">
                                                        <strong><i class="fas fa-tag"></i> Rp 100.000</strong>
                                                    </span>
                                                </div>
                                                <div class="col text-end">
                                                    <button type="button"
                                                        class="btn btn-success btn-sm px-3"><strong>DAFTAR</strong>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input_fields_wrap mt-3">
                                    </div>

                                </div>
                                <hr>
                                <div class="mt-4">
                                    <div class="bg-dark text-white text-center py-1"><strong>FORMULIR</strong></div>
                                    <div class="text-center py-1 text-danger"><small>* Form data yang harus di isi oleh
                                            peserta</small></div>
                                    <div class="card mt-2 shadow-sm">
                                        <div class="card-body form-registration-set">
                                            <div class="col-lg-8 col-md-8 mx-auto">
                                                <div class="card mt-2 shadow-sm">
                                                    <div class="card-body">
                                                        <div class="input-group mb-3 icon-class pr-4">
                                                            <input type="text" class="form-control"
                                                                placeholder="Nama Lengkap *" readonly id="namalengkap">
                                                        </div>
                                                        <div class="input-group mb-3 icon-class">
                                                            <input type="text" class="form-control"
                                                                placeholder="Email *" readonly id="alamat-email">
                                                        </div>
                                                        <div class="input-group mb-1 icon-class">
                                                            <input type="text" class="form-control"
                                                                placeholder="No HP *" readonly id="no-hp">
                                                        </div>
                                                        <div class="text-center mb-3">
                                                            <small class="text-success">Tambahkan <b>*</b> di akhir <b>jika
                                                                    form wajib</b>
                                                                diisi</small>
                                                        </div>
                                                        <div class="form-wrap">
                                                        </div>

                                                        <button class="btn btn-success" type="button" id="add-form"><i
                                                                class="fas fa-plus me-2"></i>add form</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- container -->
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success w-50 mb-3" id="submit"><i
                                class="fas fa-check-square"></i>
                            Posting
                            event</button>
                    </div>
                </div>



            </div>

            <!-- Modal kategori event-->
            <div class="modal fade" id="kategoriEventModal" tabindex="-1" aria-labelledby="kategoriEventModalLabel"
                aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="kategoriEventModalLabel"><i class="fas fa-list"></i>
                                Kategori
                                event</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="">
                                <div class="row px-2">
                                    <div class="col form-check">
                                        <input class="form-check-input" type="radio" name="priceCategory"
                                            id="berbayar" value="1" checked>
                                        <label class="form-check-label" for="berbayar">
                                            Berbayar
                                        </label>
                                    </div>
                                    <div class="col form-check">
                                        <input class="form-check-input" type="radio" name="priceCategory"
                                            id="free" value="0">
                                        <label class="form-check-label" for="free">
                                            Gratis
                                        </label>
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-2">
                                    <div class="form-group input-form-group">
                                        <label for="kategoriEvent" class="form-control-label">KATEGORI EVENT</label>
                                        <select class="form-select js-example-basic-single mt-1" id="kategoriEvent"
                                            name="kategoriEvent" aria-label="Default select example"
                                            style="z-index: 100000000">
                                            @foreach ($category as $category)
                                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="form-group input-form-group">
                                        <label for="temaEvent" class="form-control-label">TEMA</label>
                                        <select class="form-select js-example-basic-single-2 mt-1" id="temaEvent"
                                            name="temaEvent" aria-label="Default select example">
                                            @foreach ($theme as $theme)
                                                <option value="{{ $theme->id }}">{{ $theme->theme }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="simpan-kategori"><i
                                    class="fas fa-check-square"></i>
                                Simpan</button>
                        </div>

                    </div>
                </div>
            </div>


            <!-- Lokasi modal-->
            <div class="modal fade" id="lokasiEventModal" tabindex="-1" aria-labelledby="lokasiEventModalLabel"
                aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5"><i class="fas fa-map-marker-alt"></i>
                                Lokasi Event</h1>
                            {{-- Tombol close dihilangkan --}}
                        </div>
                        <div class="modal-body">

                            <div class="mb-2">

                                <div class="form-group input-form-group jenis-event">
                                    <label for="provinces" class="form-control-label">EVENT</label>
                                    <select class="form-select mt-1" id="jenis-event" name="jenisEvent"
                                        aria-label="Default select example" style="z-index: 100000000">
                                        <option value="Offline">Offline</option>
                                        <option value="Online">Online</option>
                                    </select>
                                </div>

                            </div>
                            <div id="lokasi-event-container">
                                <div class="mb-2">
                                    <div class="form-group input-form-group">
                                        <label for="provinces" class="form-control-label">PROVINSI</label>
                                        <select class="form-select mt-1" id="provinces" name="provinces"
                                            aria-label="Default select example" style="z-index: 100000000">
                                            <option value="" selected>Pilih Provinsi</option>
                                            @foreach ($data_provinces as $provinces)
                                                <option value="{{ $provinces->code }}">{{ $provinces->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                </div>
                                <div class="mb-2">
                                    <div class="form-group input-form-group">
                                        <label for="cities" class="form-control-label">KOTA</label>
                                        <select class="form-select mt-1" id="cities" name="cities"
                                            aria-label="Default select example" disabled>
                                            <option value="" selected>Pilih Kota</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="detailAlamat" class="form-control-label">DETAIL LOKASI EVENT</label>
                                    <textarea class="form-control" id="detailAlamat" name="detailAlamat" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            {{-- Tombol close dihilangkan --}}
                            <button type="button" class="btn btn-primary" id="simpan-lokasi"><i
                                    class="fas fa-check-square"></i>
                                Simpan lokasi</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Tanggal event-->
            <div class="modal fade" id="tanggalEventModal" tabindex="-1" aria-labelledby="tanggalEventModalLabel"
                aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="tanggalEventModalLabel"><i class="fas fa-calendar-alt"></i>
                                Tanggal Event</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-2">
                                {{-- <small class="text-danger">Tanggal inti acara</small> --}}
                                <div class="form-group input-form-group">
                                    <label for="startDate" class="form-control-label">TANGGAL MULAI</label>
                                    <div id="eventStartDate" class="input-group date mt-1 mb-3"
                                        data-date-format="yyyy-mm-dd">
                                        <input class="form-control ps-2" id="startDate" name="startDate" type="text"
                                            required>
                                        <span class="input-group-addon"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="form-group input-form-group">
                                    <label for="endDate" class="form-control-label">TANGGAL SELESAI</label>
                                    <div id="eventEndDate" class="input-group date mt-1 mb-3"
                                        data-date-format="yyyy-mm-dd">
                                        <input class="form-control ps-2" id="endDate" name="endDate" type="text"
                                            required>
                                        <span class="input-group-addon"></span>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="simpan-tanggal"><i
                                    class="fas fa-check-square"></i>
                                Simpan tanggal</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Ticket-->
            <div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModal" aria-hidden="true"
                data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="ticketModal">Tambah tiket registrassi</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form name="form-ticket" id="form-ticket">


                                <div class="mb-2">
                                    <div class="form-group input-form-group">
                                        <label for="ticketName" class="form-control-label">NAMA TIKET</label>
                                        <span class="fas fa-ticket-alt form-control-feedback pt-1"></span>
                                        <input type="text" class="form-control mt-1" id="ticketName"
                                            placeholder="Presale 1, 2, etc ..." required>
                                    </div>
                                </div>
                                <div class="mb-2" hidden>
                                    <div class="form-group input-form-group">
                                        <label for="ticketDescription" class="form-control-label">DESKRIPSI TIKET</label>
                                        <span class="fas fa-file-alt form-control-feedback pt-1"></span>
                                        <input type="text" class="form-control mt-1" id="ticketDescription"
                                            placeholder="Deskripsi" name="ticketDescription">
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="form-group input-form-group">
                                        <label for="ticketPrice" class="form-control-label">HARGA TIKET</label>
                                        <span class="fas fa-tags form-control-feedback pt-1"></span>
                                        <input type="text" class="form-control mt-1" id="ticketPrice"
                                            placeholder="100.000" required>
                                        <div class="form-text text-danger mt-1 pt-0">
                                            *isi 0 jika gratis.
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="form-group input-form-group">
                                        <label for="ticketQuota" class="form-control-label">KUOTA PENDAFTAR</label>
                                        <span class="fas fa-users form-control-feedback pt-1"></span>
                                        <input type="number" class="form-control mt-1" id="ticketQuota"
                                            placeholder="500" required>
                                    </div>
                                </div>
                                <label for="ticketDate" class="form-control-label">START REGISTRASI</label>
                                <div class="form-inline">

                                    <div id="datepicker" class="input-group date mt-1 mb-3"
                                        data-date-format="yyyy-mm-dd">
                                        <input class="form-control" id="ticketDate" name="ticketDate" type="text"
                                            required>
                                        <span class="input-group-addon"></span>
                                    </div>

                                    <label for="ticketEndDate" class="form-control-label">END REGISTRASI</label>
                                    <div id="datepicker" class="input-group date mt-1 mb-3"
                                        data-date-format="yyyy-mm-dd">
                                        <input class="form-control" id="ticketEndDate" name="ticketEndDate"
                                            type="text" required>
                                        <span class="input-group-addon"></span>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="form-group input-form-group">
                                        <label for="ticketButton" class="form-control-label">LABEL</label>
                                        <select class="form-select mt-1" id="ticketButton" name="ticketButton"
                                            aria-label="Default select example">
                                            <option value="BELI TIKET" selected>BELI TIKET</option>
                                            <option value="DAFTAR">DAFTAR</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer icon-class">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" id="add-ticket" class="btn btn-primary"><i
                                    class="fas fa-check-square"></i>Tambah
                                tiket</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
    {{-- End form --}}

    @push('create-scripts')
        @include('events.js.create-js')
    @endpush
@endsection
