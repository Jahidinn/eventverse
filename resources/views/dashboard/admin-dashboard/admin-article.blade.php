@extends('dashboard.layouts.modern')

@section('title', 'Articles')

@section('content')
    @include('dashboard.components.article-manager', [
        'isAdminPage' => true,
        'articles' => $articles,
        'categories' => $categories,
        'types' => $types,
    ])
@endsection
