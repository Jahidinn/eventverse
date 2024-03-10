@extends('dashboard.admin-dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="alert alert-dark bg-dashboard text-white mx-1" role="alert">
            <strong id="wd-title">Blog Categori</strong>
        </div>
    </section>

    {{-- Konten withdraw request --}}
    <section class="content mx-1">
        <div class="form-group">
        </div>

        {{-- List kategori --}}
        <div class="card" id="article-category-container">
            <div class="card-body">
                {{-- Add kategori button --}}
                <button class="btn btn-success mb-2" id="add-kategori">
                    <i class="fas fa-plus"></i> Buat kategori
                </button>
                {{-- Form pencarian --}}
                <div class="form-group">
                    <input type="text" class="form-control" id="search-category" placeholder="Cari kategori artikel">
                </div>
                {{-- Tabel data --}}
                <div class="table-responsive">
                    <table class="table w-100 table-striped" id="table-article-category">
                        <thead class="bg-secondary">
                            <tr>
                                <th scope="col">Kategori artikel</th>
                                <th scope="col" style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- List jenis artikel --}}
        <div class="card" id="article-type-container">
            <div class="card-body">
                {{-- Add kategori button --}}
                <button class="btn btn-info mb-2" id="add-type-article">
                    <i class="fas fa-plus"></i> Jenis artikel
                </button>
                {{-- Form pencarian --}}
                <div class="form-group">
                    <input type="text" class="form-control" id="search-article-type" placeholder="Cari jenis artikel">
                </div>
                {{-- Tabel data --}}
                <div class="table-responsive">
                    <table class="table w-100 table-striped" id="table-article-type">
                        <thead class="bg-secondary">
                            <tr>
                                <th scope="col">Jenis artikel</th>
                                <th scope="col" style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal tambah kategori artikel -->
    <div class="modal fade" id="articleCategoryModal" tabindex="-1" aria-labelledby="articleCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="articleCategoryModalLabel">Buat kategori artikel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="form-kategori-artikel">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category-name">Nama ketegori</label>
                            <input type="text" class="form-control" id="category-name" name="category_name"
                                placeholder="Example title" required>

                            <input type="hidden" class="form-control" id="category-id" name="category_id">
                            <input type="hidden" class="form-control" id="category-key" name="category_key">
                            <input type="hidden" class="form-control" id="category-edit" name="category_edit">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btn-submit-kategori"><i
                                class="fas fa-check-circle"></i>
                            Buat kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal tambah jenis artikel -->
    <div class="modal fade" id="articleTypeModal" tabindex="-1" aria-labelledby="articleTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="articleTypeModalLabel">Tambah jenis artikel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="form-jenis-artikel">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="article-type">Jenis artikel</label>
                            <input type="text" class="form-control" id="article-type" name="article_type"
                                placeholder="Example type" required>

                            <input type="hidden" class="form-control" id="type-slug" name="type_slug">
                            <input type="hidden" class="form-control" id="type-id" name="type_id">
                            <input type="hidden" class="form-control" id="type-edit" name="type_edit">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="submit-jenis-artikel"><i
                                class="fas fa-check-circle"></i> Tambahkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Push javascript --}}
    <script>
        var imageUrl = "{{ asset('storage/blog-images') }}";
    </script>

    @push('js-admin-transaction-check')
        <script src="{{ asset('assets/js/administrator/admin-article.js') }}"></script>
    @endpush
@endsection
