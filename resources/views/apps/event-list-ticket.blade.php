@if($ticketData->count())
    <div class="ticket-grid">
        @foreach($ticketData as $ticket)
            @php
                $now = now();

                $reserved = (int) $ticket->reserved_quantity;
                $sold = (int) $ticket->sold_quantity;

                $stock = max(
                    $ticket->ticket_quota - $reserved - $sold,
                    0
                );

                $used = $reserved + $sold;

                $percent = 0;

                if ($ticket->ticket_quota > 0) {
                    $percent = min(
                        100,
                        round(($used / $ticket->ticket_quota) * 100)
                    );
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
            @endphp

            <div class="ticket-card {{ $status }}">
                <div class="ticket-top">
                    <div>
                        <h5 class="ticket-title">{{ $ticket->ticket_name }}</h5>
                        @if($ticket->ticket_description)
                            <p class="ticket-desc">{{ $ticket->ticket_description }}</p>
                        @endif
                    </div>
                    <span class="status-badge {{ $status }}">
                        @switch($status)
                            @case('available') On Sale @break
                            @case('coming') Opening Soon @break
                            @case('soldout') Sold Out @break
                            @default Closed
                        @endswitch
                    </span>
                </div>

                <div class="ticket-date">
                    <i class="ti ti-clock-hour-4"></i>
                    <span>{{ \Carbon\Carbon::parse($ticket->ticket_start)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($ticket->ticket_end)->translatedFormat('d M Y') }}</span>
                </div>

                @if($status!="coming")
                    <div class="ticket-progress">
                        <div class="progress">
                            <<div class="fill" style="width: {{ $percent ?? 0 }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <small class="text-muted">Status Kuota</small>
                            <small class="fw-bold text-dark">
                                @if($status=="soldout")
                                    100% Sold
                                @else
                                    Tersisa {{ $stock }} tiket
                                @endif
                            </small>
                        </div>
                    </div>
                @endif

                {{-- TICKET BOTTOM --}}
                <div class="ticket-bottom">

                    <!-- Bagian Kiri: Harga & Qty -->
                    <div class="ticket-bottom-left">
                        <div class="price">
                            @if($ticket->ticket_price==0)
                                Gratis
                            @else
                                <small>Rp</small>{{ number_format($ticket->ticket_price,0,',','.') }}
                            @endif
                        </div>

                        @if($status=="available")
                            <div class="ticket-qty">
                                <!-- Tombol Minus -->
                                <button type="button" class="qty-btn qty-minus-btn" data-ticket="{{ $ticket->id }}">
                                    <i class="ti ti-minus"></i>
                                </button>

                                <!-- Input Angka (Pakai class qty-input-field) -->
                                <input 
                                    type="number" 
                                    class="qty-input-field" 
                                    value="1" 
                                    min="1">

                                <!-- Tombol Plus -->
                                <button type="button" class="qty-btn qty-plus-btn" data-ticket="{{ $ticket->id }}">
                                    <i class="ti ti-plus"></i>
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Bagian Kanan: Tombol Akses -->
                    <div class="ticket-bottom-right">
                        @if($status=="available")
                            <!-- Tombol Pesan Tiket -->
                            <button
                                type="button"
                                class="btn-gradient btn-ticket ticket-button"
                                data-id="{{ $ticket->id }}"
                                data-event_id="{{ $detailEvent->id }}"
                                data-stock="{{ $stock }}">

                                {{ $ticket->ticket_button }}
                                <i class="ti ti-arrow-right ml-2"></i>
                            </button>
                        @else
                            <button class="btn-ticket disabled" disabled>
                                @switch($status)
                                    @case('coming') Opening Soon @break
                                    @case('soldout') Sold Out @break
                                    @default Closed
                                @endswitch
                            </button>
                        @endif
                    </div>

                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <i class="ti ti-ticket-off text-muted fs-1 d-block mb-2"></i>
        <h6 class="text-muted">Belum ada tiket yang tersedia untuk event ini.</h6>
    </div>
@endif

<style>
/* Pembungkus Bawah Tiket */
.ticket-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    margin-top: 18px;
    padding-top: 14px;
    border-top: 1px dashed var(--border-color, #E2E8F0);
    flex-wrap: wrap; /* Menjaga responsif pada layar kecil */
}

/* Grup Kiri: Harga + Qty */
.ticket-bottom-left {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.ticket-bottom .price {
    font-size: 20px;
    font-weight: 800;
    color: var(--text-dark, #0F172A);
    white-space: nowrap;
}

.ticket-bottom .price small {
    font-size: 13px;
    font-weight: 600;
    margin-right: 2px;
}

/* Container Input Qty Plus Minus */
.ticket-qty {
    display: flex;
    align-items: center;
    border: 1px solid #E9ECEF;
    border-radius: 30px;
    overflow: hidden;
    background: #fff;
    height: 38px;
}

.qty-btn {
    width: 36px;
    height: 38px;
    border: none;
    background: transparent;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: .2s;
    cursor: pointer;
    color: #475569;
}

.qty-btn:hover {
    background: #F8F9FA;
    color: #0F172A;
}

/* Hilangkan outline saat tombol qty diklik */
.qty-btn:focus {
    outline: none;
    box-shadow: none; /* opsional, untuk hilangkan efek shadow browser */
}

/* Field Input Tengah */
.qty-input-field {
    width: 44px;
    height: 38px;
    border: none;
    text-align: center;
    font-weight: 700;
    font-size: 15px;
    outline: none;
    background: transparent;
}

/* Hilangkan panah default input number browser */
.qty-input-field::-webkit-outer-spin-button,
.qty-input-field::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
.qty-input-field[type=number] {
    -moz-appearance: textfield;
}

/* Grup Kanan: Tombol Tiket */
.ticket-bottom-right {
    margin-left: auto; /* Memaksa tombol untuk selalu nempel ke kanan */
}

/* Responsif Layar Mobile */
@media (max-width: 576px) {
    .ticket-bottom {
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
    }

    .ticket-bottom-left {
        justify-content: space-between;
        width: 100%;
    }

    .ticket-bottom-right {
        width: 100%;
        margin-left: 0;
    }

    .ticket-bottom-right .btn-ticket {
        width: 100%;
        justify-content: center;
    }
}
</style>