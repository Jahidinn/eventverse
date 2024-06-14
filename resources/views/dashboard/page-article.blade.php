@extends('dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="alert alert-dark bg-dashboard text-white mx-1" role="alert">
            <strong id="wd-title">Manajemen Artikel</strong>
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
                <button class="btn btn-success mb-2"data-toggle="modal" data-target="#articleModal">
                    <i class="fas fa-plus"></i> Buat artikel
                </button>
                {{-- Form pencarian --}}
                <div class="form-group">
                    <input type="text" class="form-control" id="user-search-article" placeholder="Cari artikel">
                </div>
                {{-- Tabel data --}}
                <div class="table-responsive">
                    <table class="table w-100 table-striped" id="table-user-article">
                        <thead class="bg-secondary">
                            <tr>
                                <th scope="col">Article</th>
                                <th scope="col" style="width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal article --}}
    @include('dashboard.admin-dashboard.components.modal-article')


    {{-- Push javascript --}}
    <script>
        var imageUrl = "{{ asset('storage/blog-images') }}";
    </script>

    @push('js-article')
        <script src="{{ asset('assets/js/dashboard/dash-article.js') }}"></script>
    @endpush

    @push('js-admin-article')
        <script src="{{ asset('assets/js/administrator/admin-article.js') }}"></script>
    @endpush
@endsection
