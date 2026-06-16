@extends('dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="page-header-modern mb-3">
            <div class="page-header-left">

                <div class="page-header-icon">
                    <i class="ti ti-calendar-clock"></i>
                </div>

                <h2 class="page-header-title">
                    MANAJEMEN EVENT
                </h2>

            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        {{-- <div class="card"> --}}
            {{-- <div class="card-header card-header-custom ">
                <h3 class="card-title manajemen-event-title">Buat event sesukamu! <i class="fas fa-paper-plane"></i></h3>
            </div> --}}

            {{-- <div class="card-body px-2 pt-3 bg-card-blue"> --}}
                <style>
                    .toolbar-modern{
                        display:flex;
                        gap:12px;
                        align-items:center;
                        justify-content:space-between;
                        flex-wrap:wrap;
                        margin-bottom:20px;
                    }

                    .search-modern{
                        height:50px;
                        border:none;
                        border-radius:16px;
                        background:#fff;
                        box-shadow:0 4px 20px rgba(0,0,0,.06);
                        padding-left:18px;
                    }

                    .search-modern:focus{
                        box-shadow:0 0 0 4px rgba(59,130,246,.1);
                    }

                    .event-card-modern{
                        border:none;
                        overflow:hidden;
                        border-radius:22px;
                        background:#fff;
                        box-shadow:0 4px 20px rgba(0,0,0,.06);
                        transition:.25s;
                        margin-bottom:18px;
                    }

                    .event-card-modern:hover{
                        transform:translateY(-3px);
                        box-shadow:0 14px 40px rgba(0,0,0,.10);
                    }

                    .event-cover{
                        width:100%;
                        height:180px;
                        object-fit:cover;
                        display:block;
                    }

                    .event-body{
                        padding:20px;
                    }

                    .event-title{
                        font-size:18px;
                        font-weight:700;
                        color:#0f172a;
                        line-height:1.5;
                    }

                    .event-meta{
                        color:#64748b;
                        font-size:13px;
                    }

                    .event-stats{
                        display:flex;
                        gap:10px;
                        flex-wrap:wrap;
                        margin-top:15px;
                        margin-bottom:18px;
                    }

                    .stat-chip{
                        display:inline-flex;
                        align-items:center;
                        gap:6px;

                        padding:5px 14px;

                        border-radius:999px;

                        font-size:13px;
                        font-weight:600;
                    }

                    .stat-chip-success{
                        background:rgba(16,185,129,.08);
                        border:1px solid rgba(16,185,129,.15);
                        color:#059669;
                    }

                    .stat-chip-active{
                    background:rgba(59,130,246,.08);
                    border:1px solid rgba(59,130,246,.15);
                    color:#2563eb;
                    }

                    .stat-chip-inactive{
                        background:rgba(239,68,68,.08);
                        border:1px solid rgba(239,68,68,.15);
                        color:#dc2626;
                    }

                    .event-actions{
                        display:flex;
                        gap:8px;
                        flex-wrap:wrap;
                    }

                    .action-text{
                        margin-left:4px;
                    }

                    .empty-state{
                        background:#fff;
                        border-radius:20px;
                        padding:30px;
                        text-align:center;
                        box-shadow:0 4px 20px rgba(0,0,0,.05);
                    }

                    @media(max-width:768px){

                        .event-cover{
                            height:140px;
                        }

                        .event-title{
                            font-size:16px;
                        }

                        .event-actions{
                            display:grid;
                            grid-template-columns:repeat(4,1fr);
                            gap:8px;
                        }

                        .event-actions .button-39,
                        .event-actions .button-40{
                            width:100%;
                            display:flex;
                            justify-content:center;
                            align-items:center;
                            padding:10px;
                        }

                        .action-text{
                            display:none;
                        }

                        .event-actions i{
                            margin:0 !important;
                            font-size:18px;
                        }
                    }
                </style>

                <div class="py-0 manajemen-event-box">

                    <div class="toolbar-modern">

                        <a href="/event/create" class="button-40">
                            <i class="ti ti-pencil-plus"></i>
                            Buat Event
                        </a>

                        <form action="" method="GET" class="flex-grow-1">

                            <input
                                class="form-control search-modern shadow-none"
                                name="key"
                                type="text"
                                placeholder="Cari event..."
                                value="{{ request('key') }}"
                                {{ $listEvent->isEmpty() ? 'hidden' : '' }}>

                        </form>

                    </div>

                    @if($listEvent->isEmpty())

                        <div class="empty-state">

                            <h5>Belum ada event 🎉</h5>

                            <p class="text-muted mb-3">
                                Buat event pertamamu sekarang.
                            </p>

                            <a href="/event/create" class="button-40">
                                Buat Event
                            </a>

                        </div>

                    @endif

                    @foreach($listEvent as $event)

                        @php

                            $participant = \App\Models\Transaction::where('event_id',$event->id)
                                ->whereNotIn('status',['Expired','Unpaid','Pending'])
                                ->count();

                            $title = strlen($event->title) > 70
                                ? substr($event->title,0,70).'...'
                                : $event->title;

                        @endphp

                        <div class="card event-card-modern">

                            <img
                                src="{{ asset('storage/event-images/'.$event->image) }}"
                                class="event-cover"
                                alt="{{ $event->title }}">

                            <div class="event-body">

                                <a
                                    href="/event/{{ $event->slug }}"
                                    class="event-title text-decoration-none">

                                    {{ $title }}

                                </a>

                                <div class="event-meta mt-2">

                                    <i class="ti ti-calendar"></i>

                                    Dibuat
                                    {{ $event->created_at->format('d M Y') }}

                                </div>

                                <div class="event-stats">

                                    <div class="stat-chip stat-chip-success">
                                        <i class="ti ti-users"></i>
                                        {{ $participant }} Peserta
                                    </div>

                                    <div class="stat-chip {{ $event->status == 1 ? 'stat-chip-active' : 'stat-chip-inactive' }}">
                                        <i class="ti {{ $event->status == 1 ? 'ti-circle-check' : 'ti-circle-x' }}"></i>
                                        {{ $event->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                    </div>

                                </div>

                                <div class="event-actions">

                                    <a
                                        href="/event/{{ $event->slug }}/edit"
                                        class="button-39"
                                        title="Edit Event">

                                        <i class="ti ti-edit ti-sm"></i>

                                        <span class="action-text">
                                            Edit Event
                                        </span>

                                    </a>

                                    <button
                                        type="button"
                                        class="button-39 edit-ticket-button"
                                        data-id="{{ $event->id }}"
                                        data-event="{{ $event->title }}"
                                        title="Edit Tiket">

                                        <i class="ti ti-ticket ti-sm"></i>

                                        <span class="action-text">
                                            Edit Tiket
                                        </span>

                                    </button>

                                    <button
                                        type="button"
                                        class="button-39 edit-formulir-button"
                                        data-id="{{ $event->id }}"
                                        data-event="{{ $event->title }}"
                                        title="Edit Formulir">

                                        <i class="ti ti-file-description ti-sm"></i>

                                        <span class="action-text">
                                            Edit Formulir
                                        </span>

                                    </button>

                                    <button
                                        type="button"
                                        class="button-39 text-danger delete-event"
                                        data-id="{{ $event->id }}"
                                        title="Hapus Event">

                                        <i class="ti ti-trash ti-sm"></i>

                                    </button>

                                </div>

                            </div>

                        </div>

                    @endforeach

                    <div class="d-flex justify-content-center mt-4">
                        {{ $listEvent->links() }}
                    </div>

                </div>

                {{-- Manajemen ticket  --}}
                <div class="manajemen-ticket-box" hidden>
                    {{-- Title event --}}
                    <div class="text-left mb-2">
                        <strong class="event-title-for-ticket"></strong>
                    </div>
                    <hr>

                    {{-- Button --}}
                    <button class="button-39 rounded" id="back-from-ticket"><i
                            class="fas fa-arrow-left"></i>
                        Kembali</button>
                    <button class="button-39 text-info rounded" id="add-ticket-button"><i class="fas fa-plus"></i>
                        Tambah tiket</button>

                    {{-- Search ticket field --}}
                    <div class="my-2 form-inline mt-3">
                        <input class="form-control col shadow-none" id="search-ticket" type="text"
                            placeholder="Cari tiket ..">
                    </div>

                    <div class="table-responsive">
                        {{-- Tabel ticket --}}
                        <table id="ticket-table" class="table table-striped table-bordered w-100">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="min-width: 120px">Tiket</th>
                                    <th>Harga</th>
                                    <th>Kuota</th>
                                    <th style="min-width: 100px">#</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                {{-- Manajemen formulir --}}
                <div class="manajemen-formulir-box" hidden>

                    <div class="text-left mb-2"><strong class="event-title-for-formulir"></strong></div>
                    <hr>
                    {{-- Button --}}
                    <button class="button-39 rounded" id="back-from-formulir"><i
                            class="fas fa-arrow-left"></i>
                        Kembali</button>
                    <button class="button-39 text-info rounded" id="add-formulir-button"><i class="fas fa-plus"></i>
                        Tambah formulir</button>

                    {{-- FORM search --}}
                    <div class="my-2 mt-3 form-inline">
                        <input class="form-control col shadow-none" id="search-form" type="text"
                            placeholder="Cari formulir ..">
                    </div>

                    {{-- Tabel data formulir --}}
                    <div class="table-responsive">
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
            {{-- </div>
        </div> --}}

        {{-- Modal --}}

        <!-- Modal edit ticket-->
        <div class="modal fade" id="addEditTicketModal" tabindex="-1" aria-labelledby="addEditTicketModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
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
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-2">
                                        <label for="ticket_price" class="form-control-label">HARGA</label>
                                        <input type="text" class="form-control shadow-none rounded-0 mb-0"
                                            id="ticket_price" name="ticket_price" placeholder="Rp 100.000" required>
                                        <div class="form-text text-danger mt-1 pt-0">
                                            <small id="price_notification">isi angka 0 jika gratis.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-2">
                                        <label for="ticket_quota" class="form-control-label">KUOTA PENDAFTAR</label>
                                        <input type="number" class="form-control shadow-none rounded-0"
                                            id="ticket_quota" name="ticket_quota" placeholder="100" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-2">
                                        <label for="ticket_start" class="form-control-label">BERLAKU DARI</label>
                                        <div id="datepicker" class="input-group date mt-1 mb-3"
                                            data-date-format="yyyy-mm-dd">
                                            <input class="form-control shadow-none rounded-0" id="ticket_start"
                                                name="ticket_start" type="text" required>
                                            <span class="input-group-addon"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-2">
                                        <label for="ticket_deadline" class="form-control-label">BERLAKU SAMPAI</label>
                                        <div id="datepicker" class="input-group date mt-1 mb-3"
                                            data-date-format="yyyy-mm-dd">
                                            <input class="form-control shadow-none rounded-0" id="ticket_deadline"
                                                name="ticket_deadline" type="text" required>
                                            <span class="input-group-addon"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-2">
                                        <label for="ticket_deadline" class="form-control-label">LABEL</label>
                                        <select class="form-control" id="ticket_button" name="ticket_button">
                                            <option value="DAFTAR">DAFTAR</option>
                                            <option value="BELI TIKET">BELI TIKET</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="ticket_more_qty"
                                            name="ticket_more_qty" value="1">

                                        <label class="form-check-label" for="ticket_more_qty">
                                            Bisa registrasi <b>lebih dari 1X</b>
                                        </label>
                                    </div>
                                </div>
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
                    <div class="text-center mb-0">
                        <small class="text-success">Tambahkan <b>*</b> di akhir jika
                            form wajib diisi</small>
                    </div>
                    <form action="javascript:void(0)" class="addEditForm" id="">
                        @csrf
                        <div class="modal-body">

                            <input type="hidden" name="id_form" id="id_form">
                            <input type="hidden" class="event_id" name="event_id" id="event_id">

                            <div class="form-group mb-2">
                                <label for="form_name" class="font-weight-normal">Nama formulir</label>
                                <input type="text" class="form-control shadow-none rounded-0" id="form_name"
                                    name="form_name" placeholder="Nama formulir *">
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
