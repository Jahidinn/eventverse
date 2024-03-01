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
                <form action="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="blog-title">Title</label>
                            <input type="email" class="form-control" id="blog-title" name="blog-title"
                                placeholder="Example title">
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="blog-category" name="blog-category">
                                <option>Pilih kategori</option>
                                <option>Panduan</option>
                                <option>Teknologi</option>
                                <option>Event</option>
                                <option>Umum</option>
                                <option>Tips & Trik</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="blog-image">Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="blog-image" name="blog-image">
                                    <label class="custom-file-label" for="blog-image">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group p-0">
                            <label for="blog-title">Body</label>
                            <input id="blog-body" type="hidden" name="blog-body" required>
                            <trix-editor input="blog-body"></trix-editor>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="blog-article-id" name="blog-article-id">
                                <option>Pilih jenis artikel</option>
                                <option value="1">Umum</option>
                                <option value="2">Panduan eventconnect.id</option>
                                <option value="3">Bantuan teknis</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="blog-tag" name="blog-tag" placeholder="#Tag">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> Publish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Push javascript --}}
    @push('js-admin-transaction-check')
        {{-- Tambahkan javascript --}}
    @endpush
@endsection
