{{-- Template header mengamil dari auth --}}
@extends('form.main')

@section('content')
    {{-- Form input --}}
    <form action="javascript:void(0)" method="post" enctype="multipart/form-data" id="form-event-edit">
        @method('put')
        @csrf

        <div class="container pb-3 px-0">
            <div class="row m-1">
                <div class="col-lg-3 col-md-2"></div>

                <div class="col-lg-12 formevent-title mb-2 text-white py-1 mt-4 shadow-sm">
                    <i class="fas fa-pencil-alt"></i> EDIT EVENT
                </div>

                <div class="col-lg-12 col-md-12 formevent-box">
                    <div class="card mb-4">
                        <div class="card-body">

                            <input type="hidden" id="id-event" value="{{ $detailEvent->id }}">

                            {{-- Banner image --}}
                            <div class="tb-container mt-0">
                                <img id="tb-image-edit" src="{{ asset('storage/event-images/' . $detailEvent->image) }}" />
                                <label for="tb-file-upload-edit" class="shadow"><i class="fas fa-image"></i> Edit
                                    gambar</label>
                                <input type="file" id="tb-file-upload-edit" accept="image/*"
                                    onchange="editFileUpload(event);" />
                            </div>
                            <small class="text-danger" id="image-warning" hidden>Max ukuran banner 500KB</small>
                            {{-- End banner / poster image --}}

                            <div class="col-lg-12 event-form style-form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group event-title">
                                            <input type="text" class="form-control" name="titleEvent" required
                                                placeholder="Nama Event" value="{{ $detailEvent->title }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 url">
                                        <div class="form-group input-form-group event-title">
                                            <span class="form-control-feedback url">eventconnect.id/</span>
                                            <input type="text" class="form-control mb-0" name="linkEvent" required
                                                placeholder="contoh-LINK-2023" id="url-event"
                                                value="{{ $detailEvent->slug }}">

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
                                            <label class="form-control-label" for="kategori-event">KATEGORI EVENT <i
                                                    class="fas fa-pencil-alt"></i></label>
                                            <span class="fas fa-list form-control-feedback"></span>
                                            <input type="text" class="form-control kategori-event" inputmode="none"
                                                id="kategori-event" required
                                                value="{{ $detailEvent->category }}, {{ $detailEvent->theme }} ">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group input-form-group">
                                            <label class="form-control-label" for="lokasiEvent">LOKASI <i
                                                    class="fas fa-pencil-alt"></i></label>
                                            <span class="fas fa-map-marker-alt form-control-feedback"></span>
                                            <input type="text" class="form-control lokasi-event" inputmode="none"
                                                id="lokasiEvent" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group input-form-group">
                                            <label class="form-control-label" for="tanggalEvent">TANGGAL EVENT <i
                                                    class="fas fa-pencil-alt"></i></label>
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
                        </div>
                        <!-- container -->
                    </div>
                    <div>
                        {{-- Button submit --}}
                        <button type="submit" class="btn btn-success w-100 mb-3" id="submit"><i
                                class="fas fa-check"></i>
                            Simpan perubahan</button>
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
                                <div class="mb-2">
                                    <div class="form-group input-form-group">
                                        <label for="kategoriEvent" class="form-control-label">KATEGORI EVENT</label>
                                        <select class="form-select js-example-basic-single mt-1" id="kategoriEvent"
                                            name="kategoriEvent" aria-label="Default select example"
                                            style="z-index: 100000000" value="Beasiswa">

                                            @foreach ($category as $category)
                                                <option value="{{ $category->id }}">{{ $category->category }}
                                                </option>
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
                            <h1 class="modal-title fs-5" id="lokasiEventModalLabel"><i class="fas fa-map-marker-alt"></i>
                                Lokasi</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
                                <small class="text-danger">* Tanggal inti acara</small>
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
        </div>

    </form>
    {{-- End form --}}

    @push('edit-scripts')
        @include('events.js.edit-js')
    @endpush
@endsection
