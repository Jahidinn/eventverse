@if ($data->status == 'Proses')
    {{-- Jika proses --}}
    <button class="btn btn-success btn-sm admin-proses-wd" data-id="{{ $data->id }}">
        <i class="fas fa-check-circle"></i> Terima
    </button>
    <button class="btn btn-danger btn-sm admin-cancel-wd" data-id="{{ $data->id }}">
        <i class="fas fa-times-circle"></i> Tolak
    </button>
@elseif($data->status == 'Sukses')
    {{-- Jika sukses --}}
    <button class="btn btn-success btn-sm" disabled><i class="fas fa-check-circle"></i> Terima </button>
    <button class="btn btn-danger btn-sm" disabled> <i class="fas fa-times-circle"></i> Tolak </button>
@else
    {{-- Jika gagal atau batal --}}
    <button class="btn btn-success btn-sm" disabled><i class="fas fa-check-circle"></i> Terima </button>
    <button class="btn btn-danger btn-sm" disabled> <i class="fas fa-times-circle"></i> Tolak </button>
@endif
