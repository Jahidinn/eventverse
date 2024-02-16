@if ($data->status == 'Proses')
    {{-- Jika proses --}}
    <b>{{ number_format($data->amount, 0, ',', '.') }}</b>
@elseif($data->status == 'Sukses')
    {{-- Jika sukses --}}
    <b class="text-success">{{ number_format($data->amount, 0, ',', '.') }}</b>
@else
    {{-- Jika gagal atau batal --}}
    <b class="text-danger">{{ number_format($data->amount, 0, ',', '.') }}</b>
@endif
