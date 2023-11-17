@extends('dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen event</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data event yang kamu buat!</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Event</th>
                            <th scope="col">Tgl Post</th>
                            <th scope="col">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listEvent as $event)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{ $event->title }}</td>
                                <td>{{ $event->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <a class="btn btn-sm btn-info" href="/event/{{ $event->slug }}">
                                        <i class="fas fa-list-alt mr-1"></i>View
                                    </a>
                                    <a class="btn btn-sm btn-success" href="/event/{{ $event->slug }}/edit">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <button class="btn btn-sm btn-danger delete-event" data-id="{{ $event->id }}"><i
                                            class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">

            </div>
        </div>

    </section>

    @if (Session::has('popup'))
        <script type="text/javascript">
            alertify.alert("Sukses!", "{{ session()->get('popup') }}");
        </script>
    @endif
@endsection
