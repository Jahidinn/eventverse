@extends('dashboard.admin-dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="alert alert-dark bg-dashboard text-white mx-1" role="alert">
            <strong id="wd-title">Event pilihan</strong>
        </div>
    </section>

    {{-- Konten withdraw request --}}
    <section class="content mx-1" id="check-event-container">
        <div class="form-group">

        </div>

        {{-- List event yang ada request penarikanya --}}
        <div class="card" id="article-list-container">
            <div class="card-body">
                {{-- Add article button --}}
                <button class="btn btn-info mb-2" id="add-selected-event">
                    <i class="fas fa-plus"></i> Tambah event
                </button>
                {{-- Form pencarian --}}
                <div class="form-group">
                    <input type="text" class="form-control" id="search-selected-event" placeholder="Cari event pilihan">
                </div>
                {{-- Tabel data --}}
                <div class="table-responsive">
                    <table class="table w-100 table-striped" id="table-selected-event">
                        <thead class="bg-secondary">
                            <tr>
                                <th scope="col" style="width: 50px;">#</th>
                                <th scope="col">Event</th>
                                <th scope="col" style="width: 170px;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="addSelectedEventModal" tabindex="-1" aria-labelledby="addSelectedEventModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSelectedEventModalLabel">Tambah event pilihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="search-data-event" placeholder="Cari event pilihan">
                    </div>

                    <div class="table-responsive">
                        <table class="table w-100 table-striped" id="table-data-event">
                            <thead class="bg-secondary">
                                <tr>
                                    <th scope="col">Event</th>
                                    <th scope="col" style="width: 100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Push javascript --}}
    <script>
        var imageUrl = "{{ asset('storage/blog-images') }}";
    </script>

    @push('js-admin-event-management')
        <script src="{{ asset('assets/js/administrator/admin-event-management.js') }}"></script>
    @endpush
@endsection
