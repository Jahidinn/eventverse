{{-- Template header mengamil dari auth --}}
@extends('layouts.main')

@section('content')
    <div class="container pt-4 pb-3 px-0">
        <!-- Stack the columns on mobile by making one full-width and the other half-width -->
        <div class="row m-0 p-0">
            <div class="col-md-12 m-0 p-2">
                <div class="card mb-3 shadow border-0">
                    <div class="row no-gutters">
                        <div class="col-md-3">

                            @php
                                $detailOrganisasi->org_image ? ($image = $detailOrganisasi->org_image) : ($image = 'logo.png');
                            @endphp

                            <div class="org-detail-logo-container">
                                <img src="{{ asset('storage/organization-images') . '/' . $image }}" class="img-circle"
                                    alt="User Image">
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title">{{ $detailOrganisasi->org_name }}</h5>
                                <p class="card-text mb-0">{{ $detailOrganisasi->org_contact }}</p>
                                <p class="card-text mb-0">{{ $detailOrganisasi->org_institution }}</p>
                                <p class="card-text mt-3"><small class="text-muted">Last updated
                                        {{ $detailOrganisasi->updated_at->diffForHumans() }}</small></p>
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
                                <button class="tab-link w-100 py-2" data-tab="org-member">Member</button>
                            </div>
                        </div>
                        <div id="org-event" class="tab-content current p-2 px-3 ">
                            <div class="card mt-2 bg-soft-blue">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr class="">
                                            <th scope="row">
                                                <div class="org-list-logo-container">
                                                    <img src="{{ asset('storage/organization-images') . '/' . $image }}"
                                                        class="img-circle" alt="User Image">
                                                </div>
                                            </th>
                                            <td class="">
                                                <a href="">Mark ggsgds ggsgdsd sgdgsdgs hsgdgsdgs hsdgsgd sgdgsgdsg
                                                    gsgdgsdg gsgdgsd
                                                    sydysd gsgdgs hsdd ydysd hsdgsd hsgdgsd hhsds hsdgd gsgdg</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card mt-2 bg-soft-blue">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr class="">
                                            <th scope="row">
                                                <div class="org-list-logo-container">
                                                    <img src="{{ asset('storage/organization-images') . '/' . $image }}"
                                                        class="img-circle" alt="User Image">
                                                </div>
                                            </th>
                                            <td class="">
                                                <a href="">Mark ggsgds ggsgdsd sgdgsdgs hsgdgsdgs hsdgsgd sgdgsgdsg
                                                    gsgdgsdg gsgdgsd
                                                    sydysd gsgdgs hsdd ydysd hsdgsd hsgdgsd hhsds hsdgd gsgdg</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="org-member" class="tab-content p-2">
                            Member
                        </div>
                    </div>

                </div>

            </div>


        </div>
    </div>
@endsection
