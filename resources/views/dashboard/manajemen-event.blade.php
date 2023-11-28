@extends('dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen event</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title manajemen-event-title">Data event yang kamu buat!</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive manajemen-event-box">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Event</th>
                                <th scope="col">Tgl Post</th>
                                <th scope="col">#</th>
                                <th scope="col">Ticket</th>
                                <th scope="col">Formulir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listEvent as $event)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{ $event->title }}</td>
                                    <td>{{ $event->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-info" href="/event/{{ $event->slug }}">
                                            <i class="fas fa-list-alt mr-1"></i>View
                                        </a>
                                        <a class="btn btn-sm btn-success" href="/event/{{ $event->slug }}/edit">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </a>
                                        <button class="btn btn-sm btn-danger delete-event" data-id="{{ $event->id }}"><i
                                                class="fas fa-trash-alt"></i></button>
                                    </td>
                                    <th scope="row">
                                        <a class="btn btn-sm btn-success edit-ticket-button" data-id="{{ $event->id }}"
                                            data-event="{{ $event->title }}">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </a>
                                    </th>
                                    <th scope="row">
                                        <a class="btn btn-sm btn-success edit-formulir-button" data-id="{{ $event->id }}"
                                            data-event="{{ $event->title }}">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </a>
                                    </th>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="manajemen-ticket-box" hidden>
                    <div class="text-center mb-2"><strong class="event-title-for-ticket"></strong></div>
                    <div class="table-responsive">
                        <button class="btn btn-info btn-sm shadow-none" id="add-ticket-button"><i class="fas fa-plus"></i>
                            Tambah tiket</button>
                        <div class="my-2 form-inline">
                            <button class="btn btn-secondary btn-sm w-25 shadow-none" id="back-from-ticket"><i
                                    class="fas fa-arrow-left"></i>
                                Back</button>
                            <input class="form-control form-control-sm col ml-2 shadow-none" id="search-ticket"
                                type="text" placeholder="Cari tiket ..">
                        </div>

                        <table id="ticket-table" class="table table-striped table-bordered" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tiket</th>
                                    <th>Harga</th>
                                    <th>Kuota</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="manajemen-formulir-box" hidden>
                    <div class="text-center mb-2"><strong class="event-title-for-formulir"></strong></div>
                    <div class="table-responsive">
                        <button class="btn btn-info btn-sm shadow-none" id="add-formulir-button"><i class="fas fa-plus"></i>
                            Tambah formulir</button>
                        <div class="my-2 form-inline">
                            <button class="btn btn-secondary btn-sm w-25 shadow-none" id="back-from-formulir"><i
                                    class="fas fa-arrow-left"></i>
                                Back</button>
                            <input class="form-control form-control-sm col ml-2 shadow-none" id="search-form" type="text"
                                placeholder="Cari formulir ..">
                        </div>
                        <table id="form-table" class="table table-striped table-bordered" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tiket</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal --}}

        <!-- Modal edit ticket-->
        <div class="modal fade" id="addEditTicketModal" tabindex="-1" aria-labelledby="addEditTicketModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEditTicketModalLabel">Edit ticket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:void(0)" class="addEditTicket" id="">
                        @csrf

                        <div class="modal-body">
                            <input type="hidden" name="id_ticket" id="id_ticket">
                            <input type="hidden" class="event_id" name="event_id" id="event_id">
                            <div class="form-group mb-2">
                                <label for="ticket_name" class="form-control-label">NAMA TIKET</label>
                                <input type="text" class="form-control shadow-none rounded-0" id="ticket_name"
                                    name="ticket_name" placeholder="Nama tiket pendaftaran" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="ticket_price" class="form-control-label">HARGA</label>
                                <input type="text" class="form-control shadow-none rounded-0 mb-0" id="ticket_price"
                                    name="ticket_price" placeholder="Rp 100.000" required>
                                <div class="form-text text-danger mt-1 pt-0">
                                    <small>*isi angka 0 jika gratis.</small>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="ticket_quota" class="form-control-label">KUOTA PENDAFTAR</label>
                                <input type="number" class="form-control shadow-none rounded-0" id="ticket_quota"
                                    name="ticket_quota" placeholder="100" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="ticket_start" class="form-control-label">BERLAKU DARI</label>
                                <div id="datepicker" class="input-group date mt-1 mb-3" data-date-format="yyyy-mm-dd">
                                    <input class="form-control shadow-none rounded-0" id="ticket_start"
                                        name="ticket_start" type="text" required>
                                    <span class="input-group-addon"></span>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="ticket_deadline" class="form-control-label">BERLAKU SAMPAI</label>
                                <div id="datepicker" class="input-group date mt-1 mb-3" data-date-format="yyyy-mm-dd">
                                    <input class="form-control shadow-none rounded-0" id="ticket_deadline"
                                        name="ticket_deadline" type="text" required>
                                    <span class="input-group-addon"></span>
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="ticket_deadline" class="form-control-label">LABEL</label>
                                <select class="form-control" id="ticket_button" name="ticket_button">
                                    <option value="DAFTAR">DAFTAR</option>
                                    <option value="BELI TIKET">BELI TIKET</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-ticket-submit"><i class="fas fa-check"></i>
                                Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal edit formulir-->
        <div class="modal fade" id="addEditFormModal" tabindex="-1" aria-labelledby="addEditFormModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEditFormModalLabel">Edit formulir</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:void(0)" class="addEditForm" id="">
                        @csrf
                        <div class="modal-body">

                            <input type="hidden" name="id_form" id="id_form">
                            <input type="hidden" class="event_id" name="event_id" id="event_id">

                            <div class="form-group mb-2">
                                <label for="form_name" class="font-weight-normal">Nama formulir</label>
                                <input type="text" class="form-control shadow-none rounded-0" id="form_name"
                                    name="form_name" placeholder="Nama formulir">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-form-submit"><i class="fas fa-check"></i>
                                Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>

    @if (Session::has('popup'))
        <script type="text/javascript">
            alertify.alert("Sukses!", "{{ session()->get('popup') }}");
        </script>
    @endif
@endsection
