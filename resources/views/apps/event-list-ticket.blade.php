@if($ticketData->count())
    <div class="ticket-grid grid gap-3.5">
        @foreach($ticketData as $ticket)
            @php
                $now = now();

                $reserved = (int) $ticket->reserved_quantity;
                $sold = (int) $ticket->sold_quantity;

                $stock = max($ticket->ticket_quota - $reserved - $sold, 0);
                $used = $reserved + $sold;

                $percent = 0;
                if ($ticket->ticket_quota > 0) {
                    $percent = min(100, round(($used / $ticket->ticket_quota) * 100));
                }

                if ($now->lt(\Carbon\Carbon::parse($ticket->ticket_start))) {
                    $status = 'coming';
                } elseif ($now->gt(\Carbon\Carbon::parse($ticket->ticket_end))) {
                    $status = 'closed';
                } elseif ($stock <= 0) {
                    $status = 'soldout';
                } else {
                    $status = 'available';
                }

                $statusBadgeClass = match ($status) {
                    'available' => 'bg-[#dcfce7] text-[#166534]',
                    'coming'    => 'bg-[#fef3c7] text-[#92400e]',
                    'soldout'   => 'bg-[#f1f5f9] text-[#64748b]',
                    default     => 'bg-[#f1f5f9] text-[#64748b]',
                };

                $statusText = match ($status) {
                    'available' => 'On Sale',
                    'coming'    => 'Opening Soon',
                    'soldout'   => 'Sold Out',
                    default     => 'Closed',
                };

                $statusAccent = match ($status) {
                    'available' => 'bg-[#2282ff]',
                    'coming'    => 'bg-[#f59e0b]',
                    'soldout'   => 'bg-[#94a3b8]',
                    default     => 'bg-[#94a3b8]',
                };
            @endphp

            <div class="ticket-card {{ $status }} relative bg-white border border-[#e2e8f0] hover:border-[#2282ff] rounded-xl p-4 sm:p-5 pl-5 sm:pl-6 transition-all overflow-hidden">

                {{-- ACCENT BAR (kiri) --}}
                <span class="absolute left-0 top-4 bottom-4 w-1 rounded-r-full {{ $statusAccent }}"></span>

                {{-- ================= HEADER ================= --}}
                <div class="flex justify-between items-start gap-3 flex-wrap">
                    <div class="min-w-0 flex items-start gap-2.5">
                        <div class="w-9 h-9 rounded-lg bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center text-base shrink-0">
                            <i class="ti ti-ticket"></i>
                        </div>
                        <div class="min-w-0">
                            <h5 class="text-[15px] sm:text-base font-bold text-[#0f172a] m-0 leading-tight">
                                {{ $ticket->ticket_name }}
                            </h5>
                            @if($ticket->ticket_description)
                                <p class="text-xs text-[#64748b] mt-0.5 mb-0">{{ $ticket->ticket_description }}</p>
                            @endif
                        </div>
                    </div>
                    <span class="shrink-0 px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide {{ $statusBadgeClass }}">
                        {{ $statusText }}
                    </span>
                </div>

                {{-- ================= TANGGAL ================= --}}
                <div class="flex items-center gap-1.5 text-xs text-[#64748b] mt-3">
                    <i class="ti ti-clock-hour-4 text-sm"></i>
                    <span>
                        {{ \Carbon\Carbon::parse($ticket->ticket_start)->translatedFormat('d M Y') }}
                        –
                        {{ \Carbon\Carbon::parse($ticket->ticket_end)->translatedFormat('d M Y') }}
                    </span>
                </div>

                {{-- ================= PROGRESS KUOTA ================= --}}
                @if($status != "coming")
                    <div class="mt-3">
                        <div class="w-full h-1.5 rounded-full bg-[#e2e8f0] overflow-hidden">
                            <div class="h-full {{ $statusAccent }} rounded-full transition-all" style="width: {{ $percent ?? 0 }}%"></div>
                        </div>
                        <div class="flex justify-between mt-1.5">
                            <small class="text-[11px] text-[#64748b]">Status Kuota</small>
                            <small class="text-[11px] font-bold text-[#0f172a]">
                                @if($status == "soldout")
                                    100% Sold
                                @else
                                    Tersisa {{ $stock }} tiket
                                @endif
                            </small>
                        </div>
                    </div>
                @endif

                {{-- ================= PERFORASI ================= --}}
                <div class="ticket-perf">
                    <span class="text-[#cbd5e1] text-sm"><i class="ti ti-scissors"></i></span>
                </div>

                {{-- ================= BOTTOM ================= --}}
                <div class="ticket-bottom flex flex-wrap justify-between items-center gap-3">

                    {{-- KIRI: harga & qty --}}
                    <div class="ticket-bottom-left flex flex-wrap items-center gap-3">
                        <div class="price text-lg sm:text-xl font-extrabold text-[#0f172a] whitespace-nowrap leading-none">
                            @if($ticket->ticket_price == 0)
                                <span class="text-emerald-600">Gratis</span>
                            @else
                                <small class="text-xs font-semibold mr-0.5 text-[#64748b]">Rp</small>{{ number_format($ticket->ticket_price, 0, ',', '.') }}
                            @endif
                        </div>

                        @if($status == "available")
                            <div class="ticket-qty flex items-center border border-[#e9ecef] rounded-full bg-white overflow-hidden h-9">
                                <button type="button"
                                        class="qty-btn qty-minus-btn w-9 h-9 flex items-center justify-center bg-transparent text-[#475569] hover:bg-[#f1f5f9] hover:text-[#0f172a] focus:outline-none transition-colors text-sm"
                                        data-ticket="{{ $ticket->id }}">
                                    <i class="ti ti-minus"></i>
                                </button>

                                <input type="number"
                                       class="qty-input-field w-10 h-9 border-0 text-center font-bold text-sm bg-transparent outline-none"
                                       value="1"
                                       min="1">

                                <button type="button"
                                        class="qty-btn qty-plus-btn w-9 h-9 flex items-center justify-center bg-transparent text-[#475569] hover:bg-[#f1f5f9] hover:text-[#0f172a] focus:outline-none transition-colors text-sm"
                                        data-ticket="{{ $ticket->id }}">
                                    <i class="ti ti-plus"></i>
                                </button>
                            </div>
                        @endif
                    </div>

                    {{-- KANAN: tombol aksi --}}
                    <div class="ticket-bottom-right ml-auto">
                        @if($status == "available")
                            <button type="button"
                                    class="ticket-button inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-[13px] font-bold text-white bg-gradient-to-br from-[#2282ff] to-[#02559b] shadow-[0_4px_12px_rgba(34,130,255,0.35)] hover:-translate-y-0.5 hover:shadow-[0_6px_18px_rgba(34,130,255,0.45)] transition-all disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none"
                                    data-id="{{ $ticket->id }}"
                                    data-event_id="{{ $detailEvent->id }}"
                                    data-stock="{{ $stock }}">
                                {{ $ticket->ticket_button }}
                                <i class="ti ti-arrow-right ml-1.5 text-sm"></i>
                            </button>
                        @else
                            <button type="button"
                                    class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-[13px] font-bold bg-[#e2e8f0] text-[#94a3b8] cursor-not-allowed"
                                    disabled>
                                {{ $statusText }}
                            </button>
                        @endif
                    </div>

                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-10">
        <i class="ti ti-ticket-off text-[#94a3b8] text-4xl block mb-2"></i>
        <h6 class="text-[#64748b] font-semibold text-sm m-0">Belum ada tiket yang tersedia untuk event ini.</h6>
    </div>
@endif

<style>
/* Hide spinner input number */
.qty-input-field::-webkit-outer-spin-button,
.qty-input-field::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
.qty-input-field[type=number] {
    -moz-appearance: textfield;
}

/* Perforasi bergaya tiket */
.ticket-perf {
    position: relative;
    height: 1px;
    margin: 14px 0;
    display: flex;
    align-items: center;
    justify-content: center;
}
.ticket-perf::before,
.ticket-perf::after {
    content: '';
    flex: 1;
    height: 0;
    border-top: 1.5px dashed #e2e8f0;
}
.ticket-perf span {
    margin: 0 10px;
    line-height: 0;
}

/* Responsive */
@media (max-width: 576px) {
    .ticket-bottom {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }
    .ticket-bottom-left {
        justify-content: space-between;
        width: 100%;
    }
    .ticket-bottom-right {
        width: 100%;
        margin-left: 0 !important;
    }
    .ticket-bottom-right .ticket-button,
    .ticket-bottom-right button {
        width: 100%;
        justify-content: center;
    }
}
</style>