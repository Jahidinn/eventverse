@extends('dashboard.layouts.main')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header pb-0">
    <div class="alert alert-dark bg-dashboard text-white" role="alert">
        <strong>MY PROFILE</strong>
    </div>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card mb-3" style="max-width: 100%;">
        <div class="row no-gutters">
            <div class="col-md-2 py-3 tb-container">
                <div class="mb-2 img-container">
                    @php
                        if (!auth()->user()->profile_picture || auth()->user()->profile_picture == '') {
                            $photo = 'default-user.jpg';
                        } else {
                            $photo = auth()->user()->profile_picture;
                        }

                    @endphp
                    <img src="{{ asset('storage/profile-images') . '/' . $photo }}" alt="..."
                        id="profile-image-edit">
                </div>

                <label for="profile-file-upload-edit" class="shadow">
                    <i class="fas fa-edit mr-1"></i> Edit foto
                </label>
                <input type="hidden" name="id-user" id="id-user" value="{{ auth()->user()->id }}">
                <input type="hidden" name="profile_picture" id="profile_picture"
                    value="{{ auth()->user()->profile_picture }}">
                <input type="file" name="imageProfileEdit" id="profile-file-upload-edit" accept="image/*"
                    onchange="profileFileUpload(event);" />
            </div>

            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><b>{{ auth()->user()->name }}</b></h5>
                    <p class="card-text mb-0">{{ auth()->user()->email }}</p>
                    <p class="card-text">{{ auth()->user()->no_tlp }}</p>
                    <div>
                        <button class="btn btn-success btn-sm edit-my-profile">
                            <i class="fas fa-edit"></i> Edit profil
                        </button>
                        <button class="btn btn-success btn-sm edit-my-password">
                            <i class="fas fa-cog"></i> Password
                        </button>
                    </div>
                    <p class="card-text"><small class="text-muted">Last updated
                            {{ auth()->user()->updated_at->diffForHumans() }}</small></p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row col-md-8">
                <div class="col-6">Username</div>
                <div class="col-6"><b>@</b><b>{{ auth()->user()->username }}</b></div>
            </div>
            <div class="row col-md-8 mt-2">
                <div class="col-6">Rekening</div>
                <div class="col-6">{{ auth()->user()->no_rekening }}</div>
            </div>
            <div class="row col-md-8 mt-2">
                <div class="col-6">Bank</div>
                <div class="col-6">{{ auth()->user()->bank }}</div>
            </div>
            <div class="row col-md-8 mt-2">
                <div class="col-6">Organisasi</div>
                <div class="col-6">UKM rekayasa ilminpengetahuan dan teknologi</div>
            </div>
            <div class="row col-md-8 mt-2">
                <div class="col-6"></div>
                <div class="col-6"><button class="btn btn-info btn-sm">Edit organisasi</button></div>
            </div>
        </div>
    </div>
</section>

<!-- Modal edit profile-->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit profil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="edit-my-profile">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <span class="text-secondary">Username</span>
                        <input type="text" class="form-control shadow-none mt-1" id="p_username" name="p_username"
                            readonly required>
                    </div>
                    <div class="form-group">
                        <span class="text-secondary">Nama lengkap</span>
                        <input type="text" class="form-control shadow-none mt-1" id="p_name" required
                            name="p_name">
                    </div>
                    <div class="form-group">
                        <span class="text-secondary">Email</span>
                        <input type="text" class="form-control shadow-none mt-1" id="p_email" required
                            name="p_email">
                    </div>
                    <div class="form-group">
                        <span class="text-secondary">Nomer hp</span>
                        <input type="text" class="form-control shadow-none mt-1" id="p_no_tlp" required
                            name="p_no_tlp" minlength="9">
                    </div>
                    <div class="form-group">
                        <span class="text-secondary">Nomer rekening</span>
                        <input type="text" class="form-control shadow-none mt-1" id="p_no_rekening" required
                            name="p_no_rekening">
                    </div>
                    <div class="form-group">
                        <span class="text-secondary">Bank</span>
                        <input type="text" class="form-control shadow-none mt-1" id="p_bank" required
                            name="p_bank">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check-square"></i>
                        Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal edit password-->
<div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPasswordModalLabel">Edit password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="edit-password-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="old-password">Old password</label>
                        <input type="password" class="form-control" id="old-password" name="oldPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="new-password">New password</label>
                        <input type="password" class="form-control" id="new-password" name="newPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="newPasswordConfirm">Confirm passsword</label>
                        <input type="password" class="form-control" id="newPasswordConfirm"
                            name="newPasswordConfirm" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Edit password</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Push javascript --}}
@push('js-my-profile')
@include('dashboard.js.js-my-profile')
@endpush
@endsection
