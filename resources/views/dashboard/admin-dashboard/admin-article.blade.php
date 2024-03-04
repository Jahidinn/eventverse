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
                        <tbody></tbody>
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
                <form method="POST" id="form-add-article">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="blog-title">Title</label>
                            <input type="text" class="form-control" id="blog-title" name="blog_title"
                                placeholder="Example title" required>
                            <input type="hidden" class="form-control" id="slug" name="slug" placeholder="Slug">
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="blog-category" name="blog_category" required>
                                <option value="">Pilih kategori</option>
                                <option value="1">Panduan</option>
                                <option value="2">Teknologi</option>
                                <option value="3">Event</option>
                                <option value="4">Umum</option>
                                <option value="5">Tips & Trik</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="blog-image">Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="blog-image" name="blog_image">
                                    <label class="custom-file-label" for="blog-image">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group p-0">
                            <label for="blog-body">Body</label>
                            <input id="blog-body" type="hidden" name="blog_body" required>
                            <trix-editor input="blog-body"></trix-editor>
                        </div>
                        <div class="form-group">
                            <label for="blog-title">Jenis artiikel</label>
                            <select class="form-control" id="blog-article-id" name="blog_article_id" required>
                                <option value="">Pilih jenis artikel</option>
                                <option value="1">Umum</option>
                                <option value="2">Panduan eventconnect.id</option>
                                <option value="3">Bantuan teknis</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="blog-tag" name="blog_tag" placeholder="#Tag"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btn-submit-article"><i
                                class="fas fa-check-circle"></i>
                            Publish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal edit artikel -->
    <div class="modal fade" id="editArticleModal" tabindex="-1" aria-labelledby="editArticleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editArticleModalLabel">Edit artikel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="form-edit-article">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="blog-title-edit">Title</label>
                            <input type="text" class="form-control" id="blog-title-edit" name="blog_title_edit"
                                placeholder="Example title" required>
                            <input type="hidden" id="slug-edit" name="slug_edit">
                            <input type="hidden" id="img-edit" name="img_edit">
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="blog-category-edit" name="blog_category_edit" required>
                                <option value="">Pilih kategori</option>
                                <option value="1">Panduan</option>
                                <option value="2">Teknologi</option>
                                <option value="3">Event</option>
                                <option value="4">Umum</option>
                                <option value="5">Tips & Trik</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="blog-image-edit">Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="blog-image-edit"
                                        name="blog_image_edit">
                                    <label class="custom-file-label" for="blog-image-edit">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group p-0" id="edit-body-container">
                            <label for="blog-body-edit">Body</label>
                            <input id="blog-body-edit" type="hidden" name="blog_body_edit" required>
                            <trix-editor input="blog-body-edit"></trix-editor>
                        </div>
                        <div class="form-group">
                            <label for="blog-article-id-edit">Jenis artiikel</label>
                            <select class="form-control" id="blog-article-id-edit" name="blog_article_id_edit" required>
                                <option value="">Pilih jenis artikel</option>
                                <option value="1">Umum</option>
                                <option value="2">Panduan eventconnect.id</option>
                                <option value="3">Bantuan teknis</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="blog-tag-edit" name="blog_tag_edit"
                                placeholder="#Tag" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="submit-edit-article"><i
                                class="fas fa-check-circle"></i>
                            Publish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Push javascript --}}
    @push('js-admin-transaction-check')
        <script src="{{ asset('assets/js/administrator/admin-article.js') }}"></script>
    @endpush
@endsection
