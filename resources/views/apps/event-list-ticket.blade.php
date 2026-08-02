@if($ticketData->count())
    <div class="ticket-grid">
        @foreach($ticketData as $ticket)
            @php
                $now = now();
                $sold = $ticketTransaction->where('ticket_id',$ticket->ticket_id)->sum('quantity');
                $stock = max($ticket->ticket_quota-$sold,0);
                $percent = 0;

                if($ticket->ticket_quota>0){
                    $percent = min(100,round(($sold/$ticket->ticket_quota)*100));
                }

                if($now->lt(\Carbon\Carbon::parse($ticket->ticket_start))){
                    $status='coming';
                }elseif($now->gt(\Carbon\Carbon::parse($ticket->ticket_end))){
                    $status='closed';
                }elseif($stock<=0){
                    $status='soldout';
                }else{
                    $status='available';
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
                    <span>{{ \Carbon\Carbon::parse($ticket->ticket_start)->translatedFormat('d M Y • H:i') }} - {{ \Carbon\Carbon::parse($ticket->ticket_end)->translatedFormat('d M Y • H:i') }}</span>
                </div>

                @if($status!="coming")
                    <div class="ticket-progress">
                        <div class="progress">
                            <div class="fill" style="width:{{$percent}}%"></div>
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

                <div class="ticket-bottom">
                    <div class="price">
                        @if($ticket->ticket_price==0)
                            Gratis
                        @else
                            <small>Rp</small>{{ number_format($ticket->ticket_price,0,',','.') }}
                        @endif
                    </div>

                    @if($status=="available")
                        <button type="button" 
                                class="btn-gradient btn-ticket ticket-button" 
                                data-id="{{ $ticket->id }}" 
                                data-event_id="{{ $detailEvent->event_id }}" 
                                data-label_button="{{ $ticket->ticket_button }}">
                            <span>{{ $ticket->ticket_button }}</span>
                            <i class="ti ti-arrow-right ms-2"></i>
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
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <i class="ti ti-ticket-off text-muted fs-1 d-block mb-2"></i>
        <h6 class="text-muted">Belum ada tiket yang tersedia untuk event ini.</h6>
    </div>
@endif