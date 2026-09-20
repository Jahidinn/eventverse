@extends('layouts.app')

@section('title', 'Digital Ticket - ' . $event->title)

@section('content')

@php
    // Penyelenggara
    if ($event->organizer == 'org') {
        $penyelenggara = $event->org->org_name ?? '';
    } elseif ($event->organizer == 'individual') {
        $penyelenggara = $event->individual->name ?? '';
    } else {
        $penyelenggara = '';
    }

    // Event image (dengan cache-busting)
    $imageExist = $event->image &&
        file_exists(public_path('storage/event-images/' . $event->image));

    if ($imageExist) {
        $imagePath = 'storage/event-images/' . $event->image;
        $fullPath  = public_path($imagePath);
        $eventImagePath = asset($imagePath) . '?v=' . filemtime($fullPath);
    } else {
        $eventImagePath = asset('assets/default-img/event-images/def-no-img.png');
    }
@endphp

<section class="bg-[#f8fafc] min-h-screen pt-5 pb-14">
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- ==================== HEADER ==================== --}}
    <div class="text-center mb-5">
        <h1 class="text-xl sm:text-2xl font-extrabold text-[#0f172a] m-0 tracking-tight">
            Digital Ticket
        </h1>
        <p class="text-xs text-[#64748b] mt-1.5">
            Tunjukkan QR Code ini saat check-in di lokasi acara
        </p>
    </div>


    {{-- ==================== EVENT SUMMARY ==================== --}}
    <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-4 sm:p-5 mb-4">
        <div class="flex items-center gap-3 mb-4">
            <img src="{{ $eventImagePath }}"
                 alt="{{ $event->title }}"
                 class="w-12 h-12 rounded-xl object-cover shrink-0 border border-[#edf0f5]">
            <h2 class="text-base sm:text-lg font-extrabold text-[#0f172a] m-0 leading-snug line-clamp-2">
                {{ $event->title }}
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
            <div class="bg-[#f8fafc] rounded-lg px-3 py-2.5 min-w-0">
                <div class="text-[10px] font-semibold text-[#64748b] mb-0.5">Tanggal Event</div>
                <div class="text-xs font-bold text-[#0f172a] truncate">
                    @if($event->start_date == $event->end_date)
                        {{ date('d-m-Y', strtotime($event->start_date)) }}
                    @else
                        {{ date('d-m-Y', strtotime($event->start_date)) }} - {{ date('d-m-Y', strtotime($event->end_date)) }}
                    @endif
                </div>
            </div>

            <div class="bg-[#f8fafc] rounded-lg px-3 py-2.5 min-w-0">
                <div class="text-[10px] font-semibold text-[#64748b] mb-0.5">Lokasi Event</div>
                <div class="text-xs font-bold text-[#0f172a] truncate">
                    @if(strtolower($event->location_jenis) == 'online')
                        Online Event
                    @else
                        {{ $event->location_detail }}@if($event->location_city) ({{ $event->location_city }})@endif
                    @endif
                </div>
            </div>

            <div class="bg-[#f8fafc] rounded-lg px-3 py-2.5 min-w-0">
                <div class="text-[10px] font-semibold text-[#64748b] mb-0.5">Penyelenggara</div>
                <div class="text-xs font-bold text-[#0f172a] truncate">
                    {{ $penyelenggara ?: '-' }}
                </div>
            </div>
        </div>
    </div>


    {{-- ==================== TRANSACTION SUMMARY ==================== --}}
    <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-4 sm:p-5 mb-6">

        <div class="flex items-center justify-between gap-3 pb-3 mb-4 border-b border-[#f1f5f9]">
            <div class="text-[11px] font-extrabold tracking-[0.08em] text-[#64748b] uppercase">
                Ringkasan Transaksi
            </div>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#ecfdf3] border border-[#bbf7d0] text-[10px] font-extrabold tracking-wide text-[#15803d]">
                <span class="w-1.5 h-1.5 rounded-full bg-[#22c55e]"></span>
                PAID
            </span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2.5">
            <div class="bg-[#f8fafc] rounded-lg px-3 py-2.5 min-w-0">
                <div class="text-[10px] font-semibold text-[#64748b] mb-0.5">Kode Transaksi</div>
                <div class="text-xs font-bold text-[#0f172a] font-mono truncate" title="{{ $transaction->transaction_code }}">
                    {{ $transaction->transaction_code }}
                </div>
            </div>

            <div class="bg-[#f8fafc] rounded-lg px-3 py-2.5 min-w-0">
                <div class="text-[10px] font-semibold text-[#64748b] mb-0.5">Nama Pembeli</div>
                <div class="text-xs font-bold text-[#0f172a] truncate" title="{{ $transaction->buyer_name ?? '-' }}">
                    {{ $transaction->buyer_name ?? '-' }}
                </div>
            </div>

            <div class="bg-[#f8fafc] rounded-lg px-3 py-2.5 min-w-0 col-span-2 sm:col-span-1">
                <div class="text-[10px] font-semibold text-[#64748b] mb-0.5">Email Pembeli</div>
                <div class="text-xs font-bold text-[#0f172a] truncate" title="{{ $transaction->buyer_email ?? '-' }}">
                    {{ $transaction->buyer_email ?? '-' }}
                </div>
            </div>

            <div class="bg-[#f8fafc] rounded-lg px-3 py-2.5 min-w-0">
                <div class="text-[10px] font-semibold text-[#64748b] mb-0.5">No. Telepon</div>
                <div class="text-xs font-bold text-[#0f172a] truncate" title="{{ $transaction->buyer_phone ?? '-' }}">
                    {{ $transaction->buyer_phone ?? '-' }}
                </div>
            </div>

            @if(isset($transaction->grand_total))
                <div class="bg-[#ebf3ff] rounded-lg px-3 py-2.5 min-w-0 border border-[#c2dcff]">
                    <div class="text-[10px] font-semibold text-[#2282ff] mb-0.5">Total Pembayaran</div>
                    <div class="text-xs font-extrabold text-[#2282ff] truncate">
                        Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                    </div>
                </div>
            @endif
        </div>
    </div>


    {{-- ==================== E-TICKET SECTION ==================== --}}
    <div class="mb-4">
        <div class="mb-3">
            <div class="text-[11px] font-extrabold tracking-[0.08em] text-[#64748b] uppercase">
                E-Ticket Peserta
            </div>
            <h2 class="text-lg font-extrabold text-[#0f172a] mt-1 m-0">
                {{ $transaction->participants->count() }} Tiket
            </h2>
        </div>

        @forelse($transaction->participants as $index => $participant)
            @php
                $participantTicketCode = $participant->ticket_code
                    ?? $transaction->ticket_code
                    ?? $transaction->transaction_code;
                $participantQrCode = QrCode::size(120)->generate($participantTicketCode);
            @endphp

            {{-- ============ MODERN TICKET ============ --}}
            <div class="relative flex flex-col lg:flex-row rounded-2xl overflow-hidden bg-white shadow-[0_15px_40px_-12px_rgba(15,23,42,0.12)] mb-5">

                {{-- LEFT SIDE (Dark + BG image + Overlay) --}}
                <div class="relative flex-1 p-5 sm:p-6 text-white overflow-hidden bg-[#0f172a] flex flex-col justify-between min-h-[260px]">

                    {{-- BG Image --}}
                    <img src="{{ $eventImagePath }}"
                         alt="Event Background"
                         class="absolute inset-0 w-full h-full object-cover opacity-60 z-[1]">

                    {{-- Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-[#0f172a]/85 to-[#1e293b]/95 z-[2]"></div>

                    {{-- Content --}}
                    <div class="relative z-[3] flex flex-col justify-between h-full gap-4">

                        {{-- Top bar --}}
                        <div class="flex items-center justify-between gap-3">
                            <div class="inline-flex items-center px-2.5 py-1 rounded-full bg-white/15 backdrop-blur border border-white/20 text-[10px] font-extrabold tracking-[0.12em]">
                                EVENTVERSE TICKET
                            </div>
                            <div class="text-[11px] font-bold tracking-wide text-[#cbd5e1]">
                                TIKET #{{ $index + 1 }}
                            </div>
                        </div>

                        {{-- Participant info --}}
                        <div class="p-3.5 sm:p-4 rounded-xl bg-white/10 backdrop-blur border border-white/15">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="col-span-2">
                                    <div class="text-[10px] font-bold tracking-[0.1em] uppercase text-[#94a3b8] mb-0.5">
                                        Nama Peserta
                                    </div>
                                    <div class="text-base font-extrabold text-white break-words">
                                        {{ $participant->name }}
                                    </div>
                                </div>

                                @if($participant->email)
                                    <div class="min-w-0">
                                        <div class="text-[10px] font-bold tracking-[0.1em] uppercase text-[#94a3b8] mb-0.5">
                                            Email
                                        </div>
                                        <div class="text-xs font-medium text-[#e2e8f0] break-all">
                                            {{ $participant->email }}
                                        </div>
                                    </div>
                                @endif

                                @if($participant->phone)
                                    <div class="min-w-0">
                                        <div class="text-[10px] font-bold tracking-[0.1em] uppercase text-[#94a3b8] mb-0.5">
                                            Telepon
                                        </div>
                                        <div class="text-xs font-medium text-[#e2e8f0] break-all">
                                            {{ $participant->phone }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Bottom info --}}
                        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 pt-3 border-t border-dashed border-white/20">
                            <div class="text-[13px] font-bold text-[#f8fafc] leading-snug line-clamp-2 sm:max-w-[65%]">
                                {{ $event->title }}
                            </div>
                            <div class="text-left sm:text-right">
                                <div class="text-[10px] font-bold tracking-[0.1em] uppercase text-[#94a3b8] mb-0.5">
                                    Ticket Code
                                </div>
                                <div class="text-[13px] font-extrabold tracking-wider text-[#38bdf8] font-mono break-all">
                                    {{ $participantTicketCode }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ============ PERFORATION SEPARATOR ============ --}}
                {{-- Desktop: vertical --}}
                <div class="hidden lg:block relative w-[2px] bg-[#e2e8f0]">
                    <div class="absolute -top-3.5 -left-[13px] w-7 h-7 rounded-full bg-[#f8fafc]"></div>
                    <div class="absolute -bottom-3.5 -left-[13px] w-7 h-7 rounded-full bg-[#f8fafc]"></div>
                </div>

                {{-- Mobile: horizontal --}}
                <div class="lg:hidden relative h-[2px] bg-[#e2e8f0] mx-6">
                    <div class="absolute -top-[13px] -left-3.5 w-7 h-7 rounded-full bg-[#f8fafc]"></div>
                    <div class="absolute -top-[13px] -right-3.5 w-7 h-7 rounded-full bg-[#f8fafc]"></div>
                </div>

                {{-- RIGHT SIDE (QR) --}}
                <div class="w-full lg:w-[240px] flex flex-col items-center justify-center p-5 sm:p-6 bg-white shrink-0">
                    <div class="p-2 rounded-xl bg-[#f8fafc] border border-[#f1f5f9] shadow-[0_4px_12px_rgba(0,0,0,0.04)]">
                        <div class="w-[120px] h-[120px] flex items-center justify-center">
                            {!! $participantQrCode !!}
                        </div>
                    </div>
                    <div class="mt-2.5 text-[11px] font-semibold text-[#64748b] text-center">
                        Scan saat Check-In
                    </div>
                </div>

            </div>
        @empty
            <div class="p-6 rounded-2xl bg-[#fffbeb] border border-[#fde68a] text-center">
                <i class="ti ti-alert-triangle text-[#d97706] text-2xl block mb-1.5"></i>
                <div class="text-sm font-semibold text-[#92400e]">
                    Tidak ada peserta pada transaksi ini.
                </div>
            </div>
        @endforelse

        {{-- Download Button --}}
        @if($transaction->participants->count() > 0)
            <button type="button"
                    class="download-btn-action w-full h-12 inline-flex items-center justify-center gap-2 rounded-xl text-sm font-bold text-white bg-gradient-to-br from-[#2282ff] to-[#02559b] shadow-[0_4px_14px_rgba(34,130,255,0.35)] hover:-translate-y-0.5 hover:shadow-[0_8px_20px_rgba(34,130,255,0.45)] transition-all"
                    data-transaction-code="{{ $transaction->transaction_code }}">
                <i class="ti ti-download text-base"></i>
                <span>Download Ticket</span>
            </button>
        @endif
    </div>


    {{-- ==================== INFO CARD ==================== --}}
    <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] overflow-hidden mt-4">

        <div class="flex items-center gap-2 px-4 sm:px-5 py-3.5 bg-[#f8fafc] border-b border-[#e2e8f0]">
            <i class="ti ti-info-circle text-[#2282ff] text-lg"></i>
            <div class="text-[13px] font-bold text-[#0f172a]">
                Informasi Penting
            </div>
        </div>

        <div class="px-4 sm:px-5 py-4">
            <ul class="list-disc pl-5 m-0 flex flex-col gap-1.5 text-xs text-[#475569] leading-relaxed">
                <li>Simpan tiket dan QR Code dengan baik untuk verifikasi check-in di lokasi acara.</li>
                <li>Jangan menyebarkan QR Code untuk menghindari klaim ganda oleh pihak lain.</li>
            </ul>
        </div>

    </div>

</div>
</section>

@endsection


@push('scripts')
<script>
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.download-btn-action');
    if (!btn) return;

    e.preventDefault();

    const transactionCode = btn.dataset.transactionCode;
    if (!transactionCode) return;

    window.location.href =
        `/transaction/${encodeURIComponent(transactionCode)}/ticket/download`;
});
</script>
@endpush