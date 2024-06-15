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

            {{-- Form tambah artikel --}}
            <form method="POST" id="form-add-article">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="blog-title">Title</label>
                        <input type="text" class="form-control" id="blog-title" name="blog_title"
                            placeholder="Example title" required>
                        <input type="hidden" class="form-control" id="slug" name="slug" placeholder="Slug">
                    </div>
                    {{-- Form kategori artikel --}}
                    <div class="form-group">
                        <select class="form-control" id="blog-category" name="blog_category" required>
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Form image --}}
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
                        <label>Body</label>
                        <input id="blog-body" type="hidden" name="blog_body" required>
                        <trix-editor input="blog-body"></trix-editor>
                    </div>

                    {{-- Jenis artikel --}}
                    @php
                        $user_category = auth()->user()->category_id;
                    @endphp
                    @if ($user_category == 2)
                        {{-- Form jenis arrtikel --}}
                        <div class="form-group">
                            <label for="blog-title">Jenis artiikel</label>
                            <select class="form-control" id="blog-article-id" name="blog_article_id" required>
                                <option value="">Pilih jenis artikel</option>
                                @foreach ($type as $tipe)
                                    <option value="{{ $tipe->id }}">{{ $tipe->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" value="3" id="blog-article-id" name="blog_article_id">
                    @endif

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
            {{-- Form tambah artikel --}}
        </div>
    </div>
</div>

<!-- Modal edit artikel -->
<div class="modal fade" id="editArticleModal" tabindex="-1" aria-labelledby="editArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editArticleModalLabel">Edit artikel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- Form edit artikel --}}
            <form method="POST" id="form-edit-article" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="blog-title-edit">Title</label>
                        <input type="text" class="form-control" id="blog-title-edit" name="blog_title_edit"
                            placeholder="Example title" required>
                        <input type="hidden" id="blog-id-edit" name="blog_id_edit">
                        <input type="hidden" id="slug-edit" name="slug_edit">
                    </div>

                    {{-- Kategori --}}
                    <div class="form-group">
                        <select class="form-control" id="blog-category-edit" name="blog_category_edit" required>
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach

                        </select>
                    </div>

                    {{-- Tampilkan image --}}
                    <div id="image-edit-container" class="text-center">
                        <img id="article-image-edit" alt="" style="width: 150px">
                    </div>
                    {{-- Tampilkan image --}}

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
                    {{-- Body --}}
                    <div class="form-group p-0" id="edit-body-container">
                        <label>Body</label>
                        <input id="blog-body-edit" type="hidden" name="blog_body_edit" required>
                        <trix-editor input="blog-body-edit"></trix-editor>
                    </div>

                    {{-- CEK USER --}}
                    @php
                        $user_category = auth()->user()->category_id;
                    @endphp

                    @if ($user_category == 2)
                        <div class="form-group">
                            <label for="blog-article-id-edit">Jenis artiikel {{ $user_category }}</label>
                            <select class="form-control" id="blog-article-id-edit" name="blog_article_id_edit"
                                required>
                                <option value="">Pilih jenis artikel</option>
                                @foreach ($type as $tipe)
                                    <option value="{{ $tipe->id }}">{{ $tipe->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" value="3" id="blog-article-id-edit" name="blog_article_id_edit">
                    @endif

                    <div class="form-group">
                        <input type="text" class="form-control" id="blog-tag-edit" name="blog_tag_edit"
                            placeholder="#Tag" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submit-edit-article"><i
                            class="fas fa-check-circle"></i>
                        Edit artikel</button>
                </div>
            </form>
            {{-- Form edit artikel --}}
        </div>
    </div>
</div>
