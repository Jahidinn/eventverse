{{-- Template header mengamil dari auth --}}
@extends('layouts.main')

@section('content')
    <div class="bg-eventconnect header-hight"></div>

    <div class="container pt-4 pb-3 px-0 ">
        <!-- Stack the columns on mobile by making one full-width and the other half-width -->
        <div class="row m-0 p-0">
            <div class="col-md-8 m-0 p-1">

                <div class="card shadow mb-3 mx-1">

                    <div class="view-image-event position-relative">
                        <img src="{{ asset('storage/blog-images/' . $article->input_image) }}" class="card-img-top"
                            alt="...">
                        <button class="btn btn-dark rounded-0 position-absolute" data-toggle="modal"
                            data-target="#fullImageModal"><i class="fas fa-expand"></i></button>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title mt-3 mb-0">{{ $article->title }}</h5>


                        <a href="" class=" mt-2 badge badge-secondary p-1">
                            <i class="fas fa-edit"></i>
                            {{ strlen($article->user->name) > 40 ? substr($article->user->name, 0, 40) . ' ...' : $article->user->name }}
                        </a>
                        <hr>
                        <p class="card-text"><small class="text-muted">Posted
                                {{ $article->created_at->diffForHumans() }}</small></p>
                        <hr>
                        <div>
                            {!! $article->body !!}
                        </div>
                        <hr>

                        {{-- Fungsi share artikel --}}
                        <div>
                            <span class="mb-3">Share on</span><br><br>
                            <!-- Tombol Facebook -->
                            <a href="" id="copyButton" class="btn btn-outline-info"><i class="fas fa-link"></i></a>

                            <!-- Tombol WhatsApp -->
                            <a href="https://api.whatsapp.com/send?text={{ urlencode(url()->current()) }}"
                                class="btn btn-outline-primary" class="btn btn-outline-success"><i
                                    class="fab fa-whatsapp"></i></a>

                            <!-- Tombol LinkedIn -->
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                                class="btn btn-outline-primary"><i class="fab fa-linkedin-in"></i></a>
                        </div>

                    </div>
                </div>


            </div>

            <div class="col-12 col-md-4 m-0 p-1 ">

                <div class="card mx-1 shadow">
                    <div class="card-body text-left">
                        <h5>Artikel lain!</h5>
                        <hr />
                        {{-- Artikel lain --}}
                        @foreach ($more_articles as $more_article)
                            <div class="alert alert-secondary" role="alert">
                                <a
                                    href="/blog/{{ $more_article->slug }}">{{ strlen($more_article->title) > 62 ? substr($more_article->title, 0, 62) . ' ...' : $more_article->title }}</a>
                            </div>
                        @endforeach

                    </div>
                </div>

                <br />

                <div class="card mx-1 shadow">
                    <div class="card-body">
                        <h6>Buat eventmu sekarang!</h6>
                        <hr />
                        <a type="button" href="/login" class="btn btn-light">Login</a>
                        <a type="button" href="/event/create" class="btn btn-dark">Buat event!</a>
                    </div>
                </div>
                <br />

            </div>
        </div>
    </div>


    <!-- Full Image Modal -->
    <div class="modal fade" id="fullImageModal" style="z-index: 99999" aria-labelledby="fullImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <h4>Full Image</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-1" style="width: 100%; height:100%">
                    <img src="{{ asset('storage/blog-images/' . $article->input_image) }}" class="card-img-top"
                        alt="...">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Skrip copy link --}}
    <script>
        document.getElementById("copyButton").addEventListener("click", function() {
            var dummy = document.createElement('input'),
                text = window.location.href;

            document.body.appendChild(dummy);
            dummy.value = text;
            dummy.select();
            document.execCommand('copy');
            document.body.removeChild(dummy);

            alert("Link has been copied to clipboard: " + text);
        });
    </script>
@endsection
