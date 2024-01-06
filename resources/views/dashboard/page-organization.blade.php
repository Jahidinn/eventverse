@extends('dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="alert alert-dark bg-dashboard text-white" role="alert">
            <strong>ORGANISASI</strong>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="card">
            <div class="card-body">
                <button class="btn btn-info" data-toggle="modal" data-target="#addOrganisasiModal">Ikut organisasi</button>
                <hr>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Organisasi yang kamu ikuti</th>
                            <th scope="col">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Nama organisasi</td>
                            <td>
                                <button class="btn btn-sm btn-danger">
                                    Keluar <i class="fas fa-caret-square-right"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <span>Kelola organisasi kamu sendiri!
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#kelolaOragisasiModal">
                        <b><i class="fas fa-cog"></i> Kelola sekarang!</b>
                    </button>
                </span>
            </div>
        </div>
    </section>

    {{-- Modal ikut organisasi --}}
    <div class="modal fade" id="addOrganisasiModal" tabindex="-1" aria-labelledby="addOrganisasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOrganisasiModalLabel">Ikut organisasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="search" class="form-control shadow-none mb-3" id="search" name="search"
                        placeholder="cari organisasi">

                    <div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Organisasi</th>
                                    <th scope="col">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Nama organisasi</td>
                                    <td>
                                        <button class="btn btn-sm btn-info">
                                            <i class="fas fa-plus"></i> Ikuti
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="mr-auto btn text-secondary kelola-org-from-add"><b><i class="fas fa-cog"></i> Buat
                            organisasi</b></span>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal ikut organisasi --}}

    {{-- Modal kelola organisasi --}}
    <div class="modal fade" id="kelolaOragisasiModal" tabindex="-1" aria-labelledby="kelolaOragisasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kelolaOragisasiModalLabel">Kelola organisasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <button class="btn btn-info mb-3 buat-organisasi"><i class="fas fa-plus"></i> Buat organisasi</button>
                    <input type="search" class="form-control shadow-none mb-3" id="search" name="search"
                        placeholder="Cari organisasi kamu">
                    <div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Organisasi</th>
                                    <th scope="col">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Nama organisasi</td>
                                    <td>
                                        <button class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i> Del
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal kelola organisasi --}}

    {{-- Modal TAMBAH organisasi --}}
    <div class="modal fade" id="addOrgModal" tabindex="-1" aria-labelledby="addOrgModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOrgModalLabel">Buat organisasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="edit-add-organization">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="file" class="sr-only">File</label>
                                    <div class="input-group">
                                        <input type="text" name="filename" class="form-control shadow-none"
                                            placeholder="No file selected" readonly>
                                        <span class="input-group-btn">
                                            <div class="btn btn-success custom-file-uploader">
                                                <input type="file" name="org_logo" id="org_logo"
                                                    onchange="this.form.filename.value = this.files.length ? this.files[0].name : ''" />
                                                Pilih logo
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <img src="{{ asset('storage/organization-images') . '/' . 'logo.png' }}"
                                    class="img-circle" alt="User Image" style="max-width: 80px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="text-secondary">Nama organisasi</span>
                            <input type="text" class="form-control shadow-none mt-1" id="org_name" required
                                name="org_name">
                        </div>
                        <div class="form-group">
                            <span class="text-secondary">Institusi</span>
                            <input type="text" class="form-control shadow-none mt-1" id="org_institution" required
                                name="org_institution">
                        </div>
                        <div class="form-group">
                            <span class="text-secondary">Alamat</span>
                            <input type="text" class="form-control shadow-none mt-1" id="org_address" required
                                name="org_address" minlength="9">
                        </div>
                        <div class="form-group">
                            <span class="text-secondary">Kontak</span>
                            <input type="text" class="form-control shadow-none mt-1" id="org_contact" required
                                name="org_contact">
                        </div>
                        <div class="form-group">
                            <span class="text-secondary">Tipe organisasi</span>
                            <input type="text" class="form-control shadow-none mt-1" id="org_type" required
                                name="org_type">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check-square"></i>
                            Buat organisasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal TAMBAH organisasi --}}

    {{-- Modal EDIT organisasi --}}
    <div class="modal fade" id="addOrgModal" tabindex="-1" aria-labelledby="addOrgModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOrgModalLabel">Buat organisasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="edit-add-organization">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="file" class="sr-only">File</label>
                                    <div class="input-group">
                                        <input type="text" name="filename" class="form-control shadow-none"
                                            placeholder="No file selected" readonly>
                                        <span class="input-group-btn">
                                            <div class="btn btn-success custom-file-uploader">
                                                <input type="file" name="org_logo" id="org_logo"
                                                    onchange="this.form.filename.value = this.files.length ? this.files[0].name : ''" />
                                                Pilih logo
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <img src="{{ asset('storage/organization-images') . '/' . 'logo.png' }}"
                                    class="img-circle" alt="User Image" style="max-width: 80px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="text-secondary">Nama organisasi</span>
                            <input type="text" class="form-control shadow-none mt-1" id="org_name" required
                                name="org_name">
                        </div>
                        <div class="form-group">
                            <span class="text-secondary">Institusi</span>
                            <input type="text" class="form-control shadow-none mt-1" id="org_institution" required
                                name="org_institution">
                        </div>
                        <div class="form-group">
                            <span class="text-secondary">Alamat</span>
                            <input type="text" class="form-control shadow-none mt-1" id="org_address" required
                                name="org_address" minlength="9">
                        </div>
                        <div class="form-group">
                            <span class="text-secondary">Kontak</span>
                            <input type="text" class="form-control shadow-none mt-1" id="org_contact" required
                                name="org_contact">
                        </div>
                        <div class="form-group">
                            <span class="text-secondary">Tipe organisasi</span>
                            <input type="text" class="form-control shadow-none mt-1" id="org_type" required
                                name="org_type">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check-square"></i>
                            Buat organisasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal EDIT organisasi --}}

    {{-- Push javascript --}}
    @push('js-my-profile')
        @include('dashboard.js.js-organization')
    @endpush
@endsection
