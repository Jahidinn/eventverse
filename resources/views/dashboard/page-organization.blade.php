@extends('dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="alert alert-dark bg-dashboard text-white" role="alert">
            <strong>ORGANISASI KAMU</strong>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="card">
            <div class="card-body px-2">
                <button class="btn btn-info rounded-0 mb-3" data-toggle="modal" data-target="#followOrganisasiModal">Ikut
                    organisasi</button>

                <table class="table table-striped" id="myfollowing-table">
                    <thead>
                        <tr>
                            <th scope="col">Organisasi</th>
                            <th scope="col" style="width: 82px;"></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <hr>
                <span class="btn pl-0 text-info" data-toggle="modal" data-target="#kelolaOragisasiModal"><i
                        class="fas fa-cog"></i> Kelola organisasimu
                    sendiri <i class="fab fa-telegram-plane"></i>
                    {{-- <button class="btn btn-success btn-sm">
                        <b><i class="fas fa-cog"></i> Kelola sekarang!</b>
                    </button> --}}
                </span>
            </div>
        </div>
    </section>

    {{-- Modal ikut organisasi --}}
    <div class="modal fade" id="followOrganisasiModal" tabindex="-1" aria-labelledby="followOrganisasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="followOrganisasiModalLabel">Ikut organisasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="search" class="form-control shadow-none mb-3" id="follow_org_search"
                        name="follow_org_search" placeholder="cari organisasi">

                    <div id="org-follow-container" hidden>
                        <table class="table table-striped w-100" id="get-data-org-table">
                            <thead hidden>
                                <tr>
                                    <th scope="col">Organisasi</th>
                                    <th scope="col" class="w-25">#</th>
                                </tr>
                            </thead>
                            {{-- <tbody>
                            </tbody> --}}
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="mr-auto btn text-primary kelola-org-from-add"><i class="fas fa-cog"></i> Buat
                        organisasi</span>
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
                    <div class="data-my-org">
                        <button class="btn btn-info mb-3 rounded-0 buat-organisasi"><i class="fas fa-plus"></i> Buat
                            organisasi</button>
                        <input type="search" class="form-control shadow-none mb-3" id="org_search" name="org_search"
                            placeholder="Cari organisasi kamu">
                        <div>
                            <table class="table table-striped w-100" id="my-organization-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Organisasi</th>
                                        <th scope="col" style="width: 100px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
										<td>Nama organisasi</td>
										<td>
											<button class="btn btn-sm btn-info">
												<i class="fas fa-edit"></i> Edit
											</button>
											<button class="btn btn-sm btn-danger">
												<i class="fas fa-trash-alt"></i> Del
											</button>
										</td>
									</tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="my-org-info" hidden>
                        <span class="btn back-my-org-info"><i class="fas fa-arrow-left"></i> Kembali</span>
                        <hr>
                        <div class="card text-center">
                            <div class="card-body text-center">

                                <div class="org_logo_container org-info-logo-container">
                                    <img src="{{ asset('storage/organization-images') . '/' . 'logo.png' }}"
                                        class="img-circle" alt="User Image" id="org-info-logo">
                                </div>

                                <b class="org-info-name">Nama Organisasi</b><br>
                                <span class="badge badge-secondary org-info-type">Public</span>
                            </div>
                        </div>
                        <ul class="nav nav-tabs p-0 border-0" role="tablist">
                            <li class="nav-item col-6 p-0">
                                <a class="nav-link active" data-toggle="tab" href="#participant" role="tab">Anggota</a>
                            </li>
                            <li class="nav-item col-6 p-0 mb-2">
                                <a class="nav-link" data-toggle="tab" href="#request" role="tab">Request <span
                                        class="badge badge-secondary member-request-count">0</span></a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="participant" role="tabpanel">
                                <input type="search" class="form-control shadow-none mb-3 mt-2" id="member-search"
                                    name="member-search" placeholder="Cari anggota">
                                <table class="table table-striped w-100" id="organization-member-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Anggota</th>
                                            <th scope="col" style="width: 90px;"></th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                            <div class="tab-pane" id="request">
                                <table class="table table-striped w-100" id="organization-request-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Member request</th>
                                            <th scope="col" class="w-25"></th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
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
                <form action="" id="create-organization">
                    @csrf
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
                                                <input type="file" name="org_logo_input" id="org_logo_input"
                                                    onchange="this.form.filename.value = this.files.length ? this.files[0].name : ''" />
                                                Pilih logo
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <div class="org_logo_container">
                                    <img src="{{ asset('storage/organization-images') . '/' . 'logo.png' }}"
                                        class="img-circle" alt="User Image" id="org_logo">
                                </div>
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
                                name="org_address">
                        </div>
                        <div class="form-group">
                            <span class="text-secondary">Kontak</span>
                            <input type="text" class="form-control shadow-none mt-1" id="org_contact" required
                                name="org_contact">
                        </div>
                        <div class="form-group">
                            <span class="text-secondary">Tipe organisasi</span>
                            <select class="form-control shadow-none mt-1" id="org_type" required name="org_type">
                                <option value="public">Public</option>
                                <option value="private">Private</option>
                            </select>
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
    <div class="modal fade" id="editOrgModal" tabindex="-1" aria-labelledby="editOrgModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editOrgModalLabel">Edit organisasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="edit-organization">
                    @csrf
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
                                                <input type="file" name="org_logo_input_edit" id="org_logo_input_edit"
                                                    onchange="this.form.filename.value = this.files.length ? this.files[0].name : ''" />
                                                Pilih logo
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="org_id_edit" id="org_id_edit">
                            <input type="hidden" name="org_org_id_edit" id="org_org_id_edit">
                            <input type="hidden" name="org_image_prev" id="org_image_prev">
                            <div class="col-4 text-center">
                                <div class="org_logo_container">
                                    <img src="{{ asset('storage/organization-images') . '/' . 'logo.png' }}"
                                        class="img-circle" alt="User Image" id="org_logo_edit">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="text-secondary">Nama organisasi</span>
                            <input type="text" class="form-control shadow-none mt-1" id="org_name_edit" required
                                name="org_name_edit">
                        </div>
                        <div class="form-group">
                            <span class="text-secondary">Institusi</span>
                            <input type="text" class="form-control shadow-none mt-1" id="org_institution_edit"
                                required name="org_institution_edit">
                        </div>
                        <div class="form-group">
                            <span class="text-secondary">Alamat</span>
                            <input type="text" class="form-control shadow-none mt-1" id="org_address_edit" required
                                name="org_address_edit">
                        </div>
                        <div class="form-group">
                            <span class="text-secondary">Kontak</span>
                            <input type="text" class="form-control shadow-none mt-1" id="org_contact_edit" required
                                name="org_contact_edit">
                        </div>
                        <div class="form-group">
                            <span class="text-secondary">Tipe organisasi</span>
                            <select class="form-control shadow-none mt-1" id="org_type_edit" required
                                name="org_type_edit">
                                <option value="Public">Public</option>
                                <option value="Private">Private</option>
                            </select>
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
    {{-- Modal EDIT organisasi --}}

    {{-- Push javascript --}}
    @push('js-my-profile')
        @include('dashboard.js.js-organization')
    @endpush
@endsection
