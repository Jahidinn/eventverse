@if ($data->status == 'Proses')
    {{-- Jika proses --}}
    <span class="badge badge-warning"><i class="fas fa-clock"></i> {{ $data->status }}</span>
@elseif($data->status == 'Sukses')
    {{-- Jika sukses --}}
    <span class="badge badge-success"><i class="fas fa-check-circle"></i> {{ $data->status }}</span>
@else
    {{-- Jika gagal atau batal --}}
    <span class="badge badge-danger"><i class="fas fa-times-circle"></i> {{ $data->status }}</span>
@endif
