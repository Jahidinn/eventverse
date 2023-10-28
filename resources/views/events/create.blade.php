{{-- Template header mengamil dari auth --}}
@extends('auth.main')

@section('content')
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
                            <input type="file" id="tb-file-upload" accept="image/*" onchange="fileUpload(event);" />
                        </div>

                        <div class="col-lg-12 event-form style-form">
                            <form>
                                <div class="form-group event-title">
                                    <input type="text" class="form-control" placeholder="Nama Event">
                                </div>
                                <div class="row event-heading">
                                    <div class="col-md-3 pr-2">

                                        <div class="form-group blocked  input-form-group">
                                            <label class="form-control-label">PENYELENGGARA</label>
                                            <span class="fas fa-users form-control-feedback"></span>
                                            <input type="text" readonly class="form-control" value="">
                                            <div class="form-text text-danger mt-0 pt-0">
                                                Form otomatis
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group input-form-group">
                                            <label class="form-control-label">KATEGORI EVENT</label>
                                            <span class="fas fa-list form-control-feedback"></span>
                                            <input type="text" readonly class="form-control kategori-event">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group input-form-group">
                                            <label class="form-control-label">LOKASI</label>
                                            <span class="fas fa-map-marker-alt form-control-feedback"></span>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group input-form-group">
                                            <label class="form-control-label">TANGGAL EVENT</label>
                                            <span class="far fa-calendar-alt form-control-feedback"></span>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>

                    </div>
                </div>


                <div class="col-md-12 py-4">
                    <div class="container p-0">
                        <div class="col-md-12 row tabs">
                            <div class="col px-0">
                                <button class="tab-link current w-100 m-0 py-1" data-tab="tab-1">Deskripsi Event</button>
                            </div>
                            <div class="col p-0">
                                <button class="tab-link w-100 py-1" data-tab="tab-2">Tiket</button>
                            </div>
                        </div>
                        <hr>
                        <div id="tab-1" class="tab-content current p-0">
                            <div class="bg-secondary text-white text-center py-1 mb-2">
                                <strong><small>DESKRIPSI</small></strong>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group p-0">
                                        <input id="body" type="hidden" name="body">
                                        <trix-editor input="body"></trix-editor>
                                        {{-- @error('body')
											<div class="invalid-veedback text-danger">{{ $message }}</div>
										@enderror --}}
                                    </div>
                                </div>
                            </div>
                            <div class="bg-secondary text-white text-center py-1 mb-2">
                                <strong><small>SYARAT & KETENTUAN</small></strong>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group p-0">
                                        <input id="body" type="hidden" name="body">
                                        <trix-editor input="body"></trix-editor>
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
                                    <button class="btn btn-success mb-2 icon-class" data-bs-toggle="modal"
                                        data-bs-target="#ticketModal" id="add-ticket-modal"><i
                                            class="fas fa-plus"></i>Tambah tiket</button>
                                </div>
                                <div class="card shadow-sm ticket-card mt-3" id="ticket-example">
                                    <div class="card-body">
                                        <div class="alert alert-success w-100 py-2">
                                            <strong>CONTOH TIKET</strong>
                                        </div>
                                        <hr class="dashed">
                                        <p class="card-text">Contoh deskripsi tiket</p>
                                        <p class="card-text pt-0">
                                            <small class="text-muted icon-class">
                                                <i class="fas fa-hourglass-end pr-4"></i>
                                                Berakhir : <strong>12-20-2023</strong>
                                                <span class="alert alert-secondary rounded-0 py-1 ms-2">
                                                    <strong>Kuota : 100</strong>
                                                    <input type="hidden" name="ticket-quota[]">
                                                </span>
                                            </small>
                                        </p>
                                        <hr class="dashed">
                                        <div class="d-inline">
                                            <span class="alert alert-primary py-2 rounded-0">
                                                <strong>Rp 100.000</strong>
                                            </span>
                                            <div class="float-end">
                                                <button class="btn btn-success px-3">BELI TIKET</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="input_fields_wrap mt-3">
                                </div>

                            </div>
                            <hr>
                            <div>
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
                                                            placeholder="Nama Lengkap" readonly>
                                                    </div>
                                                    <div class="input-group mb-3 icon-class">
                                                        <input type="text" class="form-control" placeholder="Email"
                                                            readonly>
                                                    </div>
                                                    <div class="input-group mb-3 icon-class">
                                                        <input type="text" class="form-control" placeholder="No HP"
                                                            readonly>
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

                <div class="col-lg-3 col-md-2"></div>
                <div>
                    <button class="btn btn-success float-start mb-3"><i class="fas fa-check-square"></i> Posting
                        event</button>
                </div>
            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <div class="mb-2">
                                <div class="form-group input-form-group">
                                    <label for="ticketDescription" class="form-control-label">DESKRIPSI TIKET</label>
                                    <span class="fas fa-file-alt form-control-feedback pt-1"></span>
                                    <input type="text" class="form-control mt-1" id="ticketDescription"
                                        placeholder="Deskripsi" required>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="form-group input-form-group">
                                    <label for="ticketPrice" class="form-control-label">HARGA TIKET</label>
                                    <span class="fas fa-tags form-control-feedback pt-1"></span>
                                    <input type="text" class="form-control mt-1" id="ticketPrice"
                                        placeholder="100.000" required>
                                    <div class="form-text text-danger mt-1 pt-0">
                                        *Kosongkan jika gratis.
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="form-group input-form-group">
                                    <label for="ticketQuota" class="form-control-label">KUOTA PENDAFTAR</label>
                                    <span class="fas fa-users form-control-feedback pt-1"></span>
                                    <input type="number" class="form-control mt-1" id="ticketQuota" placeholder="500"
                                        required>
                                </div>
                            </div>
                            <label for="ticketDate" class="form-control-label">DEADLINE EVENT</label>
                            <div id="datepicker" class="input-group date mt-1 mb-3" data-date-format="dd-mm-yyyy">
                                <input class="form-control" id="ticketDate" name="ticketDate" type="text" required>
                                <span class="input-group-addon"></span>
                            </div>
                            <div class="mb-2">
                                <div class="form-group input-form-group">
                                    <label for="ticketButton" class="form-control-label">TICKET BUTTON TEXT</label>
                                    <select class="form-select mt-1" id="ticketButton" name="ticketButton"
                                        aria-label="Default select example">
                                        <option value="beli-tiket" selected>BELI TIKET</option>
                                        <option value="daftar">DAFTAR</option>
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
    @endsection
