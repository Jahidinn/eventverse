@extends('layouts.main')

@section('content')
    {{-- Form Pencarian --}}

    <div class="header-wave">
        <!--Content before waves-->
        <div class="inner-header-search flex">
            <div class="wave-content w-100">
                <h1>Welcome to eventhub ARTICLE!</h1>
            </div>
        </div>
        <!--Waves end-->
    </div>

    <div class="container mt-3">
        <!-- Blog entries-->
        <div class="col-lg-12 blog-index">

            <form action="/blog/search" method="GET">
                <div class="input-group mb-3">
                    <input type="search" class="form-control rounded-0" placeholder="Cari artikel ..."
                        aria-label="Cari artikel" name="key">
                    <button class="btn btn-secondary ml-1 rounded-0" type="submit" id="button-addon2"><i
                            class="fas fa-search"></i> Search</button>
                </div>
            </form>

            <!-- Blog latest-->
            @if (request()->query('page') == 1 || request()->query('page') == '')
                <div class="card mb-4">
                    <a href="#!">
                        <div class="jumbotron p-0">
                            @php
                                if ($latestArticle->input_image == '' || $latestArticle->input_image == null) {
                                    //Jika gambar kosong
                                    $img = 'assets/default-img/blog-images/default-img.png';
                                } else {
                                    $imgPath = 'storage/blog-images/' . $latestArticle->input_image;

                                    // Memeriksa apakah file ada
                                    if (file_exists(public_path($imgPath))) {
                                        $img = 'storage/blog-images/' . $latestArticle->input_image;
                                    } else {
                                        // Jika file tidak ada, ganti dengan default
                                        $img = 'assets/default-img/blog-images/default-img.png';
                                    }
                                }
                            @endphp

                            <img class="card-img-top" src="{{ asset($img) }}" alt="..." />
                        </div>
                    </a>
                    <div class="card-body">
                        <div class="small text-muted">{{ $latestArticle->created_at->format('F j, Y') }}</div>
                        <p class="card-text text-info">
                            <a href="/blog/{{ $latestArticle->slug }}">{{ $latestArticle->title }}</a>
                        </p>
                        <a class="btn btn-primary" href="/blog/{{ $latestArticle->slug }}">Read more →</a>
                    </div>
                </div>
            @endif


            <!-- Nested row for non-featured blog posts-->
            <div class="row">
                <!-- Looping artikel-->
                @foreach ($articles as $article)
                    <div class="col-lg-4">
                        <!-- Blog post-->
                        <div class="card mb-4">
                            <a href="#!">
                                <div class="list-article">
                                    @php
                                        if ($article->input_image == '' || $article->input_image == null) {
                                            //Jika gambar kosong
                                            $img_article = 'assets/default-img/blog-images/default-img.png';
                                        } else {
                                            $img_articlePath = 'storage/blog-images/' . $article->input_image;

                                            // Memeriksa apakah file ada
                                            if (file_exists(public_path($img_articlePath))) {
                                                $img_article = 'storage/blog-images/' . $article->input_image;
                                            } else {
                                                // Jika file tidak ada, ganti dengan default
                                                $img_article = 'assets/default-img/blog-images/default-img.png';
                                            }
                                        }
                                    @endphp
                                    <img class="card-img-top" src="{{ asset($img_article) }}" alt="..." />
                                </div>
                            </a>
                            <div class="card-body" style="height: 165px">
                                <div class="small text-muted">{{ $article->created_at->format('F j, Y') }}</div>
                                <p class="card-text text-info">
                                    <a
                                        href="/blog/{{ $article->slug }}">{{ strlen($article->title) > 62 ? substr($article->title, 0, 62) . ' ...' : $article->title }}</a>
                                </p>
                                <a class="btn btn-primary" href="/blog/{{ $article->slug }}">Read more →</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination-->
            <div class="d-flex justify-content-center">
                {{ $articles->links() }}
            </div>
            <!-- Side widgets-->

        </div>
    </div>
@endsection
