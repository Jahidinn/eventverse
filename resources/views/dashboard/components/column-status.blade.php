@if ($data->status == 'Paid')
    {{-- Jika status Paid --}}
    <span class="badge badge-pill badge-success px-2 py-1"><i class="far fa-dot-circle"></i> Sukses</span>
@elseif($data->status == 'Unpaid')
    {{-- Jika status Unpaid --}}
    <span class="badge badge-pill badge-secondary px-2 py-1"><i class="far fa-dot-circle"></i> Unpaid</span>
@elseif($data->status == 'Pending')
    {{-- Jika status Pending --}}
    <span class="badge badge-pill badge-warning px-2 py-1"><i class="far fa-dot-circle"></i> Pending</span>
@elseif($data->status == 'Expired')
    {{-- Jika status Expired --}}
    <span class="badge badge-pill badge-danger px-2 py-1"><i class="far fa-dot-circle"></i> Expired</span>
@else
    {{-- ELSE --}}
    <span class="badge badge-pill badge-danger px-2 py-1"><i class="far fa-dot-circle"></i> Gagal</span>
@endif
