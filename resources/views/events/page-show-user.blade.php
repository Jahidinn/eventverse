{{-- Template header mengamil dari auth --}}
@extends('layouts.main')

@section('content')
    <div class="bg-eventconnect header-hight">
    </div>

    <div class="container pt-4 pb-3 px-0">
        <!-- Stack the columns on mobile by making one full-width and the other half-width -->
        <div class="row m-0 p-0">
            <div class="col-md-12 m-0 p-2">
                <div class="card mb-3 border-0 my-shadow">
                    <div class="row no-gutters">
                        <div class="col-md-3">

                            @php
                                $detailProfile->profile_picture ? ($profileImg = $detailProfile->profile_picture) : ($profileImg = 'default-user.jpg');
                            @endphp

                            <div class="org-detail-logo-container">
                                <img src="{{ asset('storage/profile-images') . '/' . $profileImg }}" class="img-circle"
                                    alt="User Image">
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title">{{ $detailProfile->name }}</h5>
                                <p class="card-text mb-0">{{ '@' . $detailProfile->username }}</p>
                                <p class="card-text mb-0">{{ $detailProfile->email }}</p>
                                <p class="card-text mt-3"><small class="text-muted">Member since
                                        {{ $detailProfile->created_at->diffForHumans() }}</small></p>
                            </div>
                        </div>
                    </div>
                    <hr class="mx-3">
                    <div>
                        <div class="col-md-12 row tabs mb-2">
                            <div class="col px-0">
                                <button class="tab-link current w-100 m-0 py-2" data-tab="org-event">Event</button>
                            </div>
                            <div class="col p-0">
                                <button class="tab-link w-100 py-2" data-tab="org-member">Organisasi</button>
                            </div>
                        </div>
                        <div id="org-event" class="tab-content current p-2 mt-3">
                            <table class="table table-striped">
                                <tbody>

                                    @if (count($listEvent) <= 0)
                                        <div class="alert alert-warning" role="alert">
                                            Belum ada event!
                                        </div>
                                    @endif

                                    @foreach ($listEvent as $event)
                                        <tr>
                                            <td style="width: 50px;">
                                                <div class="org-list-logo-container">
                                                    @php
                                                        $event->image ? ($eventImg = $event->image) : ($eventImg = 'logo.png');
                                                    @endphp
                                                    <img src="{{ asset('storage/event-images') . '/' . $eventImg }}"
                                                        class="img-circle" alt="User Image">
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <a href="/{{ $event->slug }}">{{ $event->title }}</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div id="org-member" class="tab-content p-2 mt-3">
                            <table class="table table-striped">
                                <tbody>

                                    @if (count($listOrg) <= 0)
                                        <div class="alert alert-warning" role="alert">
                                            Belum ada organisasi apapun!
                                        </div>
                                    @endif

                                    @foreach ($listOrg as $organisasi)
                                        <tr>
                                            <td style="width: 50px;">
                                                <div class="org-list-logo-container">
                                                    @php
                                                        $organisasi->org->org_image ? ($organisasiImg = $organisasi->org->org_image) : ($organisasiImg = 'logo.png');
                                                    @endphp
                                                    <img src="{{ asset('storage/organization-images') . '/' . $organisasiImg }}"
                                                        class="img-circle" alt="User Image">
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <a
                                                    href="/organisasi/{{ $organisasi->org->org_id }}">{{ $organisasi->org->org_name }}</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>


        </div>
    </div>
@endsection
