@extends('layouts.main')

@section('content')
    {{-- Form Pencarian --}}

    <div class="header-wave">
        <!--Content before waves-->
        <div class="inner-header-search flex">
            <div class="wave-content w-100">
                <h1>Welcome to eventconnect.id BLOG!</h1>
            </div>
        </div>
        <!--Waves end-->
    </div>

    <div class="container mt-3">
        <!-- Blog entries-->
        <div class="col-lg-12 blog-index">

            @php

            @endphp

            <!-- Blog pfirs ost-->
            @if (request()->query('page') == 1 || request()->query('page') == '')
                <div class="card mb-4">
                    <a href="#!">
                        <div class="jumbotron p-0">
                            <img class="card-img-top"
                                src="{{ asset('storage/blog-images') . '/' . $latestArticle->input_image }}"
                                alt="..." />
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
                                    <img class="card-img-top"
                                        src="{{ asset('storage/blog-images') . '/' . $article->input_image }}"
                                        alt="..." />
                                </div>
                            </a>
                            <div class="card-body" style="height: 165px">
                                <div class="small text-muted">{{ $article->created_at->format('F j, Y') }}</div>
                                <p class="card-text text-info">
                                    <a
                                        href="/blog/{{ $latestArticle->slug }}">{{ strlen($article->title) > 62 ? substr($article->title, 0, 62) . ' ...' : $article->title }}</a>
                                </p>
                                <a class="btn btn-primary" href="/blog/{{ $latestArticle->slug }}">Read more →</a>
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
