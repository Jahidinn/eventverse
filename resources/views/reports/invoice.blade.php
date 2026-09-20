@extends('layouts.app')

@section('title', 'Invoice - ' . ($transaction->invoice_number ?? $transaction->transaction_code))

@section('content')

@php
    // ==============================
    // PENYELENGGARA
    // ==============================
    if ($event->organizer == 'org') {
        $penyelenggara = $event->org->org_name ?? '';
    } elseif ($event->organizer == 'individual') {
        $penyelenggara = $event->individual->name ?? '';
    } else {
        $penyelenggara = '';
    }

    // ==============================
    // EVENT IMAGE (cache-busting)
    // ==============================
    $imageExist = $event->image &&
        file_exists(public_path('storage/event-images/' . $event->image));

    if ($imageExist) {
        $imagePath = 'storage/event-images/' . $event->image;
        $fullPath  = public_path($imagePath);
        $eventImagePath = asset($imagePath) . '?v=' . filemtime($fullPath);
    } else {
        $eventImagePath = asset('assets/default-img/event-images/def-no-img.png');
    }

    // ==============================
    // EVENT DATE
    // ==============================
    if ($event->start_date == $event->end_date) {
        $eventDate = date('d M Y', strtotime($event->start_date));
    } else {
        $eventDate = date('d M Y', strtotime($event->start_date))
            . ' - ' . date('d M Y', strtotime($event->end_date));
    }

    // ==============================
    // INVOICE DATE
    // ==============================
    $invoiceDate = $transaction->invoice_issued_at
        ? date('d M Y', strtotime($transaction->invoice_issued_at))
        : date('d M Y', strtotime($transaction->created_at));

    // ==============================
    // TOTAL PARTICIPANTS
    // ==============================
    $totalParticipants = $transaction->participants->count();

    // ==============================
    // STATUS
    // ==============================
    $paymentStatus = strtoupper($transaction->status ?? 'PAID');
@endphp


<section class="bg-[#f8fafc] print:bg-white min-h-screen pt-5 pb-14 print:pt-0 print:pb-0">
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 print:max-w-none print:px-0">

    {{-- ==================== ACTION ==================== --}}
    <div class="flex flex-col sm:flex-row sm:justify-end gap-2 mb-4 print:hidden">
        <a href="{{ route('transaction.invoice.download', $transaction->transaction_code) }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#2282ff] text-white text-sm font-semibold shadow-[0_4px_14px_rgba(34,130,255,0.3)] hover:bg-[#1b6cd6] hover:-translate-y-0.5 hover:shadow-[0_6px_18px_rgba(34,130,255,0.4)] transition-all">
            <i class="ti ti-file-type-pdf text-base"></i>
            <span>Download PDF</span>
        </a>
    </div>


    {{-- ==================== INVOICE DOCUMENT ==================== --}}
    <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] overflow-hidden print:border-0 print:rounded-none print:shadow-none">

        {{-- ============ HEADER ============ --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6 px-5 sm:px-10 py-6 sm:py-8 border-b border-[#edf0f5]">

            <div class="flex items-center gap-3">
                <img src="/assets/img/eventverse-color.png"
                     alt="Eventverse"
                     class="w-[170px] max-h-[55px] h-auto object-contain object-left">
            </div>

            <div class="sm:text-right">
                <div class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#172033] leading-none">
                    INVOICE
                </div>

                <span class="inline-flex items-center gap-1.5 mt-2.5 px-3 py-1 rounded-full bg-[#ecfdf3] border border-[#bbf7d0] text-[10px] font-extrabold tracking-wide text-[#15803d]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#22c55e]"></span>
                    PAID
                </span>
            </div>

        </div>


        {{-- ============ META ============ --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 px-5 sm:px-10 py-5 sm:py-6 bg-[#fafbfd] border-b border-[#edf0f5]">

            <div>
                <div class="text-[10px] font-extrabold tracking-[0.08em] text-[#94a3b8] uppercase mb-1.5">
                    Invoice Number
                </div>
                <div class="text-lg font-extrabold text-[#1d4ed8] tracking-tight">
                    {{ $transaction->invoice_number ?? '-' }}
                </div>
            </div>

            <div class="flex flex-wrap gap-6 sm:gap-10">
                <div>
                    <div class="text-[10px] font-extrabold tracking-[0.08em] text-[#94a3b8] uppercase mb-1">
                        Invoice Date
                    </div>
                    <div class="text-[13px] font-semibold text-[#273247]">{{ $invoiceDate }}</div>
                </div>

                <div>
                    <div class="text-[10px] font-extrabold tracking-[0.08em] text-[#94a3b8] uppercase mb-1">
                        Transaction Number
                    </div>
                    <div class="text-[13px] font-semibold text-[#273247] break-all">{{ $transaction->transaction_code }}</div>
                </div>
            </div>

        </div>


        {{-- ============ EVENT + BUYER ============ --}}
        <div class="grid grid-cols-1 md:grid-cols-[1.2fr_0.8fr] gap-4 px-5 sm:px-10 pt-6 sm:pt-7">

            {{-- EVENT --}}
            <div class="p-4 sm:p-5 border border-[#e8ecf3] rounded-xl bg-white">
                <div class="text-[10px] font-extrabold tracking-[0.08em] text-[#94a3b8] uppercase mb-3.5">
                    Event
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-3.5">
                    <img src="{{ $eventImagePath }}"
                         alt="{{ $event->title }}"
                         class="w-full sm:w-[78px] h-[140px] sm:h-[78px] object-cover rounded-xl border border-[#edf0f5] shrink-0">

                    <div class="min-w-0 flex-1">
                        <h2 class="text-sm sm:text-[15px] font-bold text-[#1d2738] leading-snug mb-2.5">
                            {{ $event->title }}
                        </h2>

                        <div class="flex items-start gap-1.5 text-[11px] text-[#626d7f] mb-1.5">
                            <i class="ti ti-calendar text-[#2282ff] text-xs shrink-0 mt-0.5"></i>
                            <span>{{ $eventDate }}</span>
                        </div>

                        <div class="flex items-start gap-1.5 text-[11px] text-[#626d7f]">
                            <i class="ti ti-map-pin text-[#2282ff] text-xs shrink-0 mt-0.5"></i>
                            <span>
                                @if(strtolower($event->location_jenis) == 'online')
                                    Online Event
                                @else
                                    {{ $event->location_detail }}
                                    @if($event->location_city)
                                        ({{ $event->location_city }})
                                    @endif
                                @endif
                            </span>
                        </div>

                        <div class="mt-2 text-[10px] text-[#94a3b8]">
                            {{ $penyelenggara ?: '-' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- BUYER --}}
            <div class="p-4 sm:p-5 border border-[#e8ecf3] rounded-xl bg-white">
                <div class="text-[10px] font-extrabold tracking-[0.08em] text-[#94a3b8] uppercase mb-3.5">
                    Billed To
                </div>

                <div class="text-[15px] font-bold text-[#1d2738] mb-3.5">
                    {{ $transaction->buyer_name ?? '-' }}
                </div>

                <div class="flex items-center gap-2 text-[11px] text-[#626d7f] mb-1.5">
                    <i class="ti ti-mail text-[#2282ff] text-sm shrink-0"></i>
                    <span class="break-all">{{ $transaction->buyer_email ?? '-' }}</span>
                </div>

                <div class="flex items-center gap-2 text-[11px] text-[#626d7f]">
                    <i class="ti ti-phone text-[#2282ff] text-sm shrink-0"></i>
                    <span>{{ $transaction->buyer_phone ?? '-' }}</span>
                </div>
            </div>

        </div>


        {{-- ============ PURCHASE DETAIL ============ --}}
        <div class="px-5 sm:px-10 pt-6 sm:pt-7">
            <div class="text-[10px] font-extrabold tracking-[0.08em] text-[#94a3b8] uppercase mb-3.5">
                Purchase Details
            </div>

            <div class="border border-[#e7ebf2] rounded-xl overflow-hidden">

                {{-- Head --}}
                <div class="grid grid-cols-[1fr_60px_130px] sm:grid-cols-[1fr_90px_180px] gap-3 sm:gap-4 items-center px-4 py-3 bg-[#f8fafc]">
                    <div class="text-[9px] font-extrabold tracking-[0.08em] text-[#8a94a6] uppercase">Description</div>
                    <div class="text-[9px] font-extrabold tracking-[0.08em] text-[#8a94a6] uppercase text-center">Qty</div>
                    <div class="text-[9px] font-extrabold tracking-[0.08em] text-[#8a94a6] uppercase text-right">Amount</div>
                </div>

                {{-- Row --}}
                <div class="grid grid-cols-[1fr_60px_130px] sm:grid-cols-[1fr_90px_180px] gap-3 sm:gap-4 items-center px-4 py-4 text-xs">
                    <div class="min-w-0">
                        <div class="font-semibold text-[#202b3c] truncate">
                            {{ $ticket->ticket_name ?? '-' }}
                        </div>
                        <div class="text-[10px] text-[#99a2b1] mt-0.5">Event Ticket</div>
                    </div>
                    <div class="text-center text-[#273247] font-semibold">{{ $totalParticipants }}</div>
                    <div class="text-right text-[#273247] font-semibold whitespace-nowrap">
                        Rp {{ number_format($transaction->subtotal ?? 0, 0, ',', '.') }}
                    </div>
                </div>

            </div>
        </div>


        {{-- ============ TOTAL ============ --}}
        <div class="grid grid-cols-1 md:grid-cols-[1fr_330px] gap-6 sm:gap-10 px-5 sm:px-10 py-6 sm:py-8">

            {{-- Payment Info --}}
            <div>
                <div class="text-[10px] font-extrabold tracking-[0.08em] text-[#94a3b8] uppercase mb-3.5">
                    Payment Information
                </div>

                <div class="flex flex-col divide-y divide-[#f0f2f6]">
                    <div class="flex justify-between items-start gap-4 py-2 first:pt-0 text-[11px]">
                        <span class="text-[#707b8e]">Status</span>
                        <strong class="text-[#16a34a] uppercase text-right font-bold">{{ $transaction->status }}</strong>
                    </div>

                    <div class="flex justify-between items-start gap-4 py-2 last:pb-0 text-[11px]">
                        <span class="text-[#707b8e]">Payment Method</span>
                        <strong class="text-[#263246] text-right font-semibold">
                            {{ $transaction->paymentGatewayMethod?->method?->name ?? '-' }}
                        </strong>
                    </div>
                </div>
            </div>

            {{-- Summary --}}
            <div class="p-4 sm:p-5 rounded-xl bg-[#f8fafc] border border-[#e7ebf2]">
                <div class="flex justify-between items-center gap-4 text-[11px] text-[#667085]">
                    <span>Subtotal</span>
                    <strong class="text-[#263246] font-semibold">
                        Rp {{ number_format($transaction->subtotal ?? 0, 0, ',', '.') }}
                    </strong>
                </div>

                <div class="h-px bg-[#dfe4ec] my-3.5"></div>

                <div class="flex justify-between items-center gap-4">
                    <span class="text-xs font-bold text-[#263246]">Total Paid</span>
                    <strong class="text-lg font-extrabold text-[#1d4ed8] tracking-tight">
                        Rp {{ number_format($transaction->grand_total ?? 0, 0, ',', '.') }}
                    </strong>
                </div>
            </div>

        </div>


        {{-- ============ PARTICIPANTS ============ --}}
        @if($transaction->participants->count())

            <div class="px-5 sm:px-10 pb-6 sm:pb-8">
                <div class="text-[10px] font-extrabold tracking-[0.08em] text-[#94a3b8] uppercase mb-3.5">
                    Participants
                </div>

                <div class="border border-[#e7ebf2] rounded-xl overflow-hidden">

                    {{-- Head --}}
                    <div class="grid grid-cols-[40px_1fr_130px] sm:grid-cols-[45px_1fr_220px] gap-3 sm:gap-4 items-center px-4 py-3 bg-[#f8fafc]">
                        <div class="text-[9px] font-extrabold tracking-[0.08em] text-[#8993a5] uppercase">#</div>
                        <div class="text-[9px] font-extrabold tracking-[0.08em] text-[#8993a5] uppercase">Participant</div>
                        <div class="text-[9px] font-extrabold tracking-[0.08em] text-[#8993a5] uppercase text-right">Ticket Code</div>
                    </div>

                    {{-- Rows --}}
                    @foreach($transaction->participants as $index => $participant)
                        @php
                            $participantTicketCode = $participant->ticket_code
                                ?? $transaction->ticket_code
                                ?? $transaction->transaction_code;
                        @endphp

                        <div class="grid grid-cols-[40px_1fr_130px] sm:grid-cols-[45px_1fr_220px] gap-3 sm:gap-4 items-center px-4 py-3 border-t border-[#edf0f5] text-[11px]">
                            <div class="text-[#9aa4b4] font-semibold">{{ $index + 1 }}</div>

                            <div class="min-w-0">
                                <div class="text-[#273247] font-semibold truncate">
                                    {{ $participant->name }}
                                </div>
                                @if($participant->email)
                                    <div class="text-[10px] text-[#9aa4b4] mt-0.5 truncate">
                                        {{ $participant->email }}
                                    </div>
                                @endif
                            </div>

                            <div class="text-[10px] font-mono text-[#536075] text-right break-all">
                                {{ $participantTicketCode }}
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        @endif


        {{-- ============ FOOTER ============ --}}
        <div class="flex flex-col sm:flex-row justify-between gap-5 px-5 sm:px-10 py-5 sm:py-6 border-t border-[#edf0f5] bg-[#fafbfd]">

            <div class="sm:max-w-[570px]">
                <div class="text-[11px] font-bold text-[#374151] mb-1">
                    Thank you for your purchase.
                </div>
                <div class="text-[10px] text-[#8b95a5] leading-relaxed">
                    Simpan invoice ini sebagai bukti pembayaran.
                    E-ticket dapat digunakan untuk proses check-in pada hari acara.
                </div>
            </div>

            <div class="flex flex-col sm:items-end gap-0.5">
                <strong class="text-[11px] font-extrabold text-[#374151]">EVENTVERSE</strong>
                <span class="text-[9px] text-[#9aa3b1]">Event Management & Ticketing</span>
            </div>

        </div>

    </div>

</div>
</section>

@endsection