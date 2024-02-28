@extends('dashboard.admin-dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="alert alert-dark bg-dashboard text-white mx-1" role="alert">
            <strong id="wd-title">Manajemen blog</strong>
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
                    <input type="text" class="form-control" id="check-search-article" placeholder="Cari artikel">
                </div>
                {{-- Tabel data --}}
                <div class="table-responsive">
                    <table class="table w-100 table-striped" id="table-article">
                        <thead class="bg-secondary">
                            <tr>
                                <th scope="col">Article</th>
                                <th scope="col" style="width: 170px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non nostrum amet maiores.
                                    Facilis doloribus nam aliquam repudiandae</td>
                                <td>
                                    <button class="btn btn-info"><i class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non nostrum amet maiores.
                                    Facilis doloribus nam aliquam repudiandae</td>
                                <td>
                                    <button class="btn btn-info"><i class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal tambah artikel -->
    <div class="modal fade" id="articleModal" tabindex="-1" aria-labelledby="articleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="articleModalLabel">Tulis artikel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="blog-title">Title</label>
                        <input type="email" class="form-control" id="blog-title" placeholder="Example title">
                    </div>
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary"><i class="fas fa-check-circle"></i> Publish</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Push javascript --}}
    @push('js-admin-transaction-check')
        @include('dashboard.admin-dashboard.admin-js.js-transaction-check')
    @endpush
@endsection
