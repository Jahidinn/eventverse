@extends('layouts.main')

@section('content')
    {{-- Form Pencarian --}}

    <div class="header-wave">
        <!--Content before waves-->
        <div class="inner-header-search flex">
            <div class="wave-content w-100">
                <h1>Privacy policy</h1>
            </div>
        </div>
        <!--Waves end-->
    </div>

    <section class="container mt-0 pt-5 px-1">
        <div class="card mb-3 mx-1 shadow">
            <div class="card-body p-4">

                <div class="mt-2">
                    <article class="text-article">
                        {!! $privacy_policy->body !!}
                    </article>
                </div>

            </div>
        </div>
    </section>
@endsection
