@extends('layouts.app')

@section('title', 'Transaction Detail - ' . $transaction->transaction_code)

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | PENYELENGGARA
    |--------------------------------------------------------------------------
    */
    if ($event->organizer == 'org') {
        $penyelenggara = $event->org->org_name ?? '';
    } elseif ($event->organizer == 'individual') {
        $penyelenggara = $event->individual->name ?? '';
    } else {
        $penyelenggara = '';
    }

    /*
    |--------------------------------------------------------------------------
    | EVENT IMAGE (dengan cache-busting)
    |--------------------------------------------------------------------------
    */
    $imageExist = $event->image &&
        file_exists(public_path('storage/event-images/' . $event->image));

    if ($imageExist) {
        $imagePath = 'storage/event-images/' . $event->image;
        $fullPath  = public_path($imagePath);
        $eventImagePath = asset($imagePath) . '?v=' . filemtime($fullPath);
    } else {
        $eventImagePath = asset('assets/default-img/event-images/def-no-img.png');
    }

    /*
    |--------------------------------------------------------------------------
    | EVENT DATE
    |--------------------------------------------------------------------------
    */
    if ($event->start_date == $event->end_date) {
        $eventDate = date('d M Y', strtotime($event->start_date));
    } else {
        $eventDate = date('d M Y', strtotime($event->start_date))
            . ' - ' . date('d M Y', strtotime($event->end_date));
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS & TOTAL
    |--------------------------------------------------------------------------
    */
    $status = strtoupper($transaction->status ?? '-');
    $subtotal = (float) ($transaction->subtotal ?? 0);
    $grandTotal = (float) ($transaction->grand_total ?? 0);
    $totalParticipants = $participants->count();

    /*
    |--------------------------------------------------------------------------
    | CUSTOM FORMS CHECK
    |--------------------------------------------------------------------------
    */
    $hasParticipantForms = $participants->contains(
        fn ($participant) => $participant->forms && $participant->forms->count()
    );

@endphp


<section class="bg-[#f8fafc] min-h-screen pt-5 pb-14">
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- ==================== TOP ACTIONS ==================== --}}
    <div class="flex flex-col sm:flex-row sm:justify-end gap-2 mb-4">
        <a href="{{ route('transaction.invoice', $transaction->transaction_code) }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white border-[1.5px] border-[#e2e8f0] text-sm font-semibold text-[#0f172a] hover:border-[#c2dcff] hover:bg-[#f8fbff] hover:text-[#2282ff] transition-all">
            <i class="ti ti-file-invoice text-base"></i>
            <span>Invoice</span>
        </a>

        <a href="{{ route('transaction.invoice.download', $transaction->transaction_code) }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#2282ff] text-white text-sm font-semibold shadow-[0_4px_14px_rgba(34,130,255,0.3)] hover:bg-[#1b6cd6] hover:-translate-y-0.5 hover:shadow-[0_6px_18px_rgba(34,130,255,0.4)] transition-all">
            <i class="ti ti-file-type-pdf text-base"></i>
            <span>Download PDF</span>
        </a>
    </div>


    {{-- ==================== TRANSACTION HEADER ==================== --}}
    <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-7 mb-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <div class="text-[10px] font-extrabold tracking-[0.08em] text-[#94a3b8] uppercase mb-1.5">
                    Transaction Detail
                </div>
                <h1 class="text-lg sm:text-xl font-extrabold text-[#0f172a] m-0 tracking-tight break-all">
                    {{ $transaction->transaction_code }}
                </h1>
                <div class="text-xs text-[#94a3b8] mt-1.5">
                    {{ $transaction->created_at?->format('d M Y, H:i') }}
                </div>
            </div>

            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#ecfdf3] border border-[#bbf7d0] text-[10px] font-extrabold tracking-wide text-[#15803d] w-fit">
                <span class="w-1.5 h-1.5 rounded-full bg-[#22c55e]"></span>
                {{ $status }}
            </span>

        </div>
    </div>


    {{-- ==================== EVENT CARD ==================== --}}
    <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-6 mb-4">
        <div class="text-[13px] font-bold text-[#273247] mb-4">Event</div>

        <div class="flex flex-col sm:flex-row gap-4 sm:gap-5">
            <img src="{{ $eventImagePath }}"
                 alt="{{ $event->title }}"
                 class="w-full sm:w-[120px] h-[160px] sm:h-[90px] object-cover rounded-xl border border-[#edf0f5] shrink-0">

            <div class="min-w-0 flex-1">
                <h2 class="text-[15px] sm:text-base font-bold text-[#1d2738] m-0 mb-3 leading-snug">
                    {{ $event->title }}
                </h2>

                <div class="flex flex-col gap-2 text-xs text-[#64748b]">
                    <div class="flex items-start gap-2">
                        <i class="ti ti-calendar text-[#2282ff] text-sm shrink-0 mt-0.5"></i>
                        <span>{{ $eventDate }}</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <i class="ti ti-map-pin text-[#2282ff] text-sm shrink-0 mt-0.5"></i>
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
                    <div class="flex items-start gap-2">
                        <i class="ti ti-user text-[#2282ff] text-sm shrink-0 mt-0.5"></i>
                        <span>{{ $penyelenggara ?: '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ==================== TRANSACTION + BUYER ==================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

        {{-- Transaction Info --}}
        <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-6">
            <div class="text-[13px] font-bold text-[#273247] mb-4">Transaction Information</div>

            <div class="flex flex-col divide-y divide-[#f0f2f6]">
                <div class="flex justify-between items-start gap-4 py-2.5 first:pt-0 text-xs">
                    <span class="text-[#7a8495] shrink-0">Transaction Number</span>
                    <strong class="text-[#273247] text-right break-all">{{ $transaction->transaction_code }}</strong>
                </div>
                <div class="flex justify-between items-start gap-4 py-2.5 text-xs">
                    <span class="text-[#7a8495] shrink-0">Invoice Number</span>
                    <strong class="text-[#2282ff] text-right break-all">{{ $transaction->invoice_number ?? '-' }}</strong>
                </div>
                <div class="flex justify-between items-start gap-4 py-2.5 text-xs">
                    <span class="text-[#7a8495] shrink-0">Transaction Date</span>
                    <strong class="text-[#273247] text-right">{{ $transaction->created_at?->format('d M Y, H:i') }}</strong>
                </div>
                @if($transaction->paid_at)
                    <div class="flex justify-between items-start gap-4 py-2.5 text-xs">
                        <span class="text-[#7a8495] shrink-0">Paid At</span>
                        <strong class="text-[#273247] text-right">{{ $transaction->paid_at->format('d M Y, H:i') }}</strong>
                    </div>
                @endif
                <div class="flex justify-between items-start gap-4 py-2.5 last:pb-0 text-xs">
                    <span class="text-[#7a8495] shrink-0">Status</span>
                    <strong class="text-[#16a34a] uppercase text-right">{{ $status }}</strong>
                </div>
            </div>
        </div>

        {{-- Buyer Info --}}
        <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-6">
            <div class="text-[13px] font-bold text-[#273247] mb-4">Buyer Information</div>

            <div class="text-base font-bold text-[#1d2738] mb-4">
                {{ $transaction->buyer_name ?? '-' }}
            </div>

            <div class="flex flex-col gap-2.5 text-xs text-[#64748b]">
                <div class="flex items-center gap-2">
                    <i class="ti ti-mail text-[#2282ff] text-sm shrink-0"></i>
                    <span class="break-all">{{ $transaction->buyer_email ?? '-' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="ti ti-phone text-[#2282ff] text-sm shrink-0"></i>
                    <span>{{ $transaction->buyer_phone ?? '-' }}</span>
                </div>
            </div>
        </div>

    </div>


    {{-- ==================== TICKET PURCHASE ==================== --}}
    <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-6 mb-4">
        <div class="text-[13px] font-bold text-[#273247] mb-4">Ticket Purchase</div>

        <div class="flex items-center justify-between gap-4 p-4 rounded-xl bg-[#f8fafc] border border-[#e7ebf2]">
            <div>
                <div class="text-sm font-bold text-[#1d2738]">{{ $ticket->ticket_name ?? '-' }}</div>
                <div class="text-[10px] text-[#929bab] mt-1">Event Ticket</div>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <span class="text-[10px] text-[#8993a5]">Quantity</span>
                <strong class="min-w-[32px] h-8 px-2 inline-flex items-center justify-center rounded-lg bg-[#dbeafe] text-[#1d4ed8] text-xs font-bold">
                    {{ $totalParticipants }}
                </strong>
            </div>
        </div>
    </div>


    {{-- ==================== PAYMENT ==================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

        {{-- Payment Info --}}
        <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-6">
            <div class="text-[13px] font-bold text-[#273247] mb-4">Payment Information</div>

            <div class="flex flex-col divide-y divide-[#f0f2f6]">
                <div class="flex justify-between items-start gap-4 py-2.5 first:pt-0 text-xs">
                    <span class="text-[#7a8495] shrink-0">Payment Method</span>
                    <strong class="text-[#273247] text-right">{{ $paymentGatewayMethod?->method?->name ?? '-' }}</strong>
                </div>
                <div class="flex justify-between items-start gap-4 py-2.5 text-xs">
                    <span class="text-[#7a8495] shrink-0">Payment Gateway</span>
                    <strong class="text-[#273247] text-right">{{ $paymentGatewayMethod?->gateway?->name ?? '-' }}</strong>
                </div>
                <div class="flex justify-between items-start gap-4 py-2.5 last:pb-0 text-xs">
                    <span class="text-[#7a8495] shrink-0">Payment Status</span>
                    <strong class="text-[#16a34a] uppercase text-right">{{ $status }}</strong>
                </div>
            </div>
        </div>

        {{-- Payment Summary --}}
        <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-6">
            <div class="text-[13px] font-bold text-[#273247] mb-4">Payment Summary</div>

            <div class="p-4 rounded-xl bg-[#f8fafc] border border-[#e7ebf2]">
                <div class="flex justify-between items-center gap-4 text-xs text-[#697386]">
                    <span>Subtotal</span>
                    <strong class="text-[#273247]">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                </div>

                <div class="h-px bg-[#dfe4ec] my-3.5"></div>

                <div class="flex justify-between items-center gap-4">
                    <span class="text-xs font-bold text-[#273247]">Total Paid</span>
                    <strong class="text-lg font-extrabold text-[#1d4ed8]">
                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </strong>
                </div>
            </div>
        </div>

    </div>


    {{-- ==================== PARTICIPANTS ==================== --}}
    <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-6 mb-4">

        <div class="text-[13px] font-bold text-[#273247] mb-1">Participants</div>
        <div class="text-[10px] text-[#8993a5] mb-4">
            {{ $totalParticipants }} participant(s) registered in this transaction.
        </div>

        <div class="flex flex-col divide-y divide-[#f0f2f6]">
            @forelse($participants as $index => $participant)
                @php
                    $participantTicketCode = $participant->ticket_code
                        ?? $transaction->ticket_code
                        ?? $transaction->transaction_code;
                @endphp

                <div class="flex justify-between items-start gap-4 py-3.5 first:pt-0 last:pb-0">

                    {{-- Left: name + email --}}
                    <div class="min-w-0 flex-1">
                        <div class="text-[10px] font-bold text-[#9aa4b4] uppercase tracking-wider mb-1">
                            Peserta {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <div class="text-xs font-semibold text-[#273247] truncate">
                            {{ $participant->name ?? '-' }}
                        </div>
                        @if($participant->email)
                            <div class="text-[10px] text-[#9aa4b4] mt-0.5 truncate">
                                {{ $participant->email }}
                            </div>
                        @endif
                    </div>

                    {{-- Right: ticket code + e-ticket button --}}
                    <div class="shrink-0 flex flex-col items-end gap-2">
                        <div class="text-right">
                            <div class="text-[9px] text-[#9aa4b4] uppercase tracking-wider">Ticket Code</div>
                            <div class="text-[10px] font-mono text-[#536075] break-all mt-0.5 max-w-[180px]">
                                {{ $participantTicketCode }}
                            </div>
                        </div>

                        <a href="{{ route('transaction.ticket', $transaction->transaction_code) }}"
                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-[#eff6ff] border border-[#dbeafe] text-[#2282ff] text-[10px] font-bold hover:bg-[#2282ff] hover:text-white hover:border-[#2282ff] transition-all">
                            <i class="ti ti-ticket text-xs"></i>
                            <span>E-ticket</span>
                        </a>
                    </div>

                </div>
            @empty
                <div class="py-4 text-center text-xs text-[#94a3b8]">
                    No participants found.
                </div>
            @endforelse
        </div>

    </div>


    {{-- ==================== CUSTOM FORMS ==================== --}}
    @if($hasParticipantForms)

        <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-5 sm:p-6 mb-4">

            <div class="text-[13px] font-bold text-[#273247] mb-4">Participant Information</div>

            <div class="flex flex-col divide-y divide-[#edf0f5]">
                @foreach($participants as $participant)
                    @if($participant->forms?->count())

                        <div class="py-4 first:pt-0 last:pb-0">

                            {{-- Participant name --}}
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-6 h-6 rounded-md bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center text-[10px] font-bold shrink-0">
                                    {{ strtoupper(substr($participant->name ?? '?', 0, 1)) }}
                                </div>
                                <div class="text-xs font-bold text-[#273247] truncate">
                                    {{ $participant->name ?? '-' }}
                                </div>
                            </div>

                            {{-- Fields --}}
                            <div class="flex flex-col divide-y divide-[#f0f2f6]">
                                @foreach($participant->forms as $form)
                                    @php
                                        $customForm = $form->form;
                                        $fieldLabel = $customForm?->field_label ?? $form->field_label ?? 'Field';
                                        $fieldType = strtolower($customForm?->field_type ?? '');
                                        $value = $form->form_value;
                                        $isImage = $fieldType === 'image';
                                        $isFile = $fieldType === 'file';

                                        $fileUrl = null;
                                        if ($value) {
                                            $relPath = ltrim($value, '/');
                                            $fullPath = public_path('storage/' . $relPath);
                                            $fileUrl = asset('storage/' . $relPath)
                                                . (file_exists($fullPath) ? '?v=' . filemtime($fullPath) : '');
                                        }
                                        $fileName = $value ? basename($value) : null;
                                    @endphp

                                    {{-- ============ TEXT / EMPTY ============ --}}
                                    @if(!$value || (!$isImage && !$isFile))
                                        <div class="flex justify-between items-start gap-4 py-2.5 first:pt-0 last:pb-0 text-xs">
                                            <span class="text-[#7a8495] shrink-0">{{ $fieldLabel }}</span>
                                            @if(!$value)
                                                <strong class="text-[#9ca3af]">-</strong>
                                            @else
                                                <strong class="text-[#273247] font-semibold text-right break-words sm:max-w-[60%]">
                                                    {{ $value }}
                                                </strong>
                                            @endif
                                        </div>

                                    {{-- ============ IMAGE ============ --}}
                                    @elseif($isImage)
                                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3 py-3 first:pt-0 last:pb-0">
                                            <span class="text-xs text-[#7a8495] shrink-0 sm:pt-1">{{ $fieldLabel }}</span>

                                            <div class="flex flex-col gap-2.5 w-full sm:w-auto sm:items-end">
                                                {{-- Preview --}}
                                                <a href="{{ $fileUrl }}"
                                                target="_blank"
                                                class="group block w-full sm:w-[130px] h-[180px] sm:h-[95px] rounded-xl overflow-hidden border-2 border-[#e5e9f0] bg-[#f8fafc] shrink-0 hover:border-[#2282ff] hover:shadow-[0_4px_16px_rgba(34,130,255,0.15)] transition-all">
                                                    <img src="{{ $fileUrl }}"
                                                        alt="{{ $fieldLabel }}"
                                                        loading="lazy"
                                                        class="w-full h-full object-cover block group-hover:scale-105 transition-transform duration-300">
                                                </a>

                                                {{-- Actions --}}
                                                <div class="grid grid-cols-2 gap-2 w-full sm:w-auto sm:flex sm:items-center">
                                                    <a href="{{ $fileUrl }}"
                                                    target="_blank"
                                                    class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-lg bg-white border border-[#e2e8f0] text-[#273247] text-xs font-semibold hover:border-[#2282ff] hover:text-[#2282ff] hover:bg-[#f0f6ff] hover:-translate-y-px transition-all">
                                                        <i class="ti ti-eye text-sm"></i>
                                                        <span>View</span>
                                                    </a>

                                                    <a href="{{ $fileUrl }}"
                                                    download="{{ $fileName }}"
                                                    class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#2282ff] text-white text-xs font-semibold shadow-[0_2px_8px_rgba(34,130,255,0.25)] hover:bg-[#1b6cd6] hover:shadow-[0_4px_14px_rgba(34,130,255,0.4)] hover:-translate-y-px transition-all">
                                                        <i class="ti ti-download text-sm"></i>
                                                        <span>Download</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    {{-- ============ FILE ============ --}}
                                    @elseif($isFile)
                                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 py-3 first:pt-0 last:pb-0">
                                            <span class="text-xs text-[#7a8495] shrink-0">{{ $fieldLabel }}</span>

                                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 w-full sm:w-auto">
                                                {{-- File info --}}
                                                <div class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-lg bg-[#f8fafc] border border-[#e5e9f0] min-w-0 sm:max-w-[240px]">
                                                    <div class="w-9 h-9 rounded-md bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center text-lg shrink-0">
                                                        <i class="ti ti-file"></i>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <div class="text-xs font-semibold text-[#1d2738] truncate" title="{{ $fileName }}">
                                                            {{ $fileName }}
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Download --}}
                                                <a href="{{ $fileUrl }}"
                                                download="{{ $fileName }}"
                                                class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#2282ff] text-white text-xs font-semibold shadow-[0_2px_8px_rgba(34,130,255,0.25)] hover:bg-[#1b6cd6] hover:shadow-[0_4px_14px_rgba(34,130,255,0.4)] hover:-translate-y-px transition-all">
                                                    <i class="ti ti-download text-sm"></i>
                                                    <span>Download</span>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                    @endif
                @endforeach
            </div>

        </div>

    @endif


    {{-- ==================== FOOTER ==================== --}}
    <div class="flex flex-col sm:flex-row justify-between gap-4 pt-3 px-1 text-[10px] text-[#8b95a5]">
        <div class="flex flex-col gap-0.5">
            <strong class="text-[11px] text-[#4b5563]">Eventverse</strong>
            <span>Event Management & Ticketing</span>
        </div>
        <div class="sm:max-w-[400px] sm:text-right leading-relaxed">
            Transaction information shown on this page is based on the completed payment transaction.
        </div>
    </div>

</div>
</section>

@endsection