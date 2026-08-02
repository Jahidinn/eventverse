<!-- MODAL CHECKOUT SOFT BLUE DESIGN -->
<div class="modal fade" id="checkoutConfirmModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered checkout-modal-xl" role="document">
        <div class="modal-content checkout-modal-content">
            
            <!-- HEADER -->
            <div class="checkout-modal-header">
                <div>
                    <div class="header-tag"><i class="ti ti-shield-check"></i> Checkout Safe & Secure</div>
                    <h4 class="checkout-modal-title">Konfirmasi & Pembayaran</h4>
                </div>
                <button type="button" class="btn-close-modal" data-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>

            <!-- BODY -->
            <div class="checkout-modal-body">
                <div class="checkout-grid-container">
                    
                    <!-- LEFT COLUMN: Details & Payment Methods -->
                    <div class="checkout-col-main">
                        
                        <!-- 1. Event Info with Dynamic Image Banner -->
                        <div class="checkout-section-card p-0 overflow-hidden">
                            <div class="event-banner-wrapper">
                                <img id="modalEventBanner" src="" alt="Event Banner" class="event-banner-img">
                                <div class="event-banner-overlay"></div>
                                <span class="event-id-badge"><i class="ti ti-ticket"></i> ID: #<span id="modalEventId">-</span></span>
                            </div>
                            <div class="event-brief-body">
                                <h5 id="modalEventTitle" class="event-title-text">-</h5>
                                <div class="event-meta-info">
                                    <span><i class="ti ti-map-pin"></i> Lokasi: <strong id="modalEventLocation" class="text-capitalize">-</strong></span>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Buyer Info -->
                        <div class="checkout-section-card">
                            <div class="section-badge"><i class="ti ti-user-check"></i> Data Pemesan</div>
                            <div class="info-grid-3">
                                <div class="info-field">
                                    <label>Nama Lengkap</label>
                                    <span id="modalBuyerName">-</span>
                                </div>
                                <div class="info-field">
                                    <label>Email</label>
                                    <span id="modalBuyerEmail">-</span>
                                </div>
                                <div class="info-field">
                                    <label>Nomor HP</label>
                                    <span id="modalBuyerPhone">-</span>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Participants List -->
                        <div class="checkout-section-card">
                            <div class="section-card-header">
                                <div class="section-badge"><i class="ti ti-users"></i> Daftar Peserta</div>
                                <span id="modalParticipantBadge" class="count-pill">0 Peserta</span>
                            </div>
                            <div id="modalParticipantList" class="participant-stack">
                                <!-- Dynamic JS -->
                            </div>
                        </div>

                        <!-- 4. Dynamic Accordion Payment Categories -->
                        <div class="checkout-section-card">
                            <div class="section-badge"><i class="ti ti-wallet"></i> Pilih Metode Pembayaran</div>
                            
                            <div id="paymentCategoriesAccordion" class="payment-accordion-wrapper">
                                <!-- Dynamic JS Render -->
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT COLUMN: 2 Split Sticky Cards -->
                    <div class="checkout-col-sidebar">
                        
                        <!-- STICKY CARD 1: Detail Rincian Biaya -->
                        <div class="sidebar-card breakdown-card">
                            <h5 class="card-title"><i class="ti ti-receipt"></i> Rincian Biaya</h5>

                            <div class="ticket-type-box">
                                <div class="ticket-name" id="modalTicketName">-</div>
                                <div class="ticket-price-qty">
                                    <span id="modalTicketPrice">Rp 0</span> × <span id="modalTicketQty">1</span>
                                </div>
                            </div>

                            <div class="summary-rows">
                                <div class="summary-item">
                                    <span>Subtotal Tiket</span>
                                    <strong id="modalSubtotal">Rp 0</strong>
                                </div>
                                <div class="summary-item">
                                    <span>Biaya Layanan/Platform</span>
                                    <span id="modalPlatformFee" class="text-free">Gratis</span>
                                </div>
                                <div class="summary-item">
                                    <span>Biaya Penanganan</span>
                                    <span id="modalPaymentFee" class="text-free">Gratis</span>
                                </div>
                            </div>
                        </div>

                        <!-- STICKY CARD 2: Total Biaya + Tombol Bayar (Fixed Sticky di HP) -->
                        <div class="sidebar-card action-pay-card">
                            <div class="pay-total-wrapper">
                                <span class="pay-total-label">Total Pembayaran</span>
                                <div class="grand-total-price" id="modalGrandTotal">Rp 0</div>
                            </div>

                            <div class="terms-disclaimer">
                                <i class="ti ti-lock-check"></i> Transaksi dienkripsi secara aman.
                            </div>

                            <button type="button" class="btn-checkout-submit" id="btnSubmitCheckout">
                                <span>Bayar Sekarang</span>
                                <i class="ti ti-arrow-right"></i>
                            </button>

                            <button type="button" class="btn-checkout-cancel" data-dismiss="modal">
                                Batal
                            </button>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
    :root {
    --ck-primary: #2563eb;          /* Soft Blue Primary */
    --ck-primary-hover: #1d4ed8;    /* Darker Soft Blue */
    --ck-primary-light: #eff6ff;    /* Very Light Blue */
    --ck-bg: #f8fafc;
    --ck-card-bg: #ffffff;
    --ck-text-dark: #0f172a;
    --ck-text-muted: #64748b;
    --ck-border: #e2e8f0;
    --ck-radius: 16px;
}

.checkout-modal-xl {
    max-width: 1020px;
}

.checkout-modal-content {
    border: none;
    border-radius: var(--ck-radius);
    background: var(--ck-bg);
    box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.22);
    overflow: hidden;
    font-family: Inter, system-ui, -apple-system, sans-serif;
}

/* Header */
.checkout-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 28px;
    background: var(--ck-card-bg);
    border-bottom: 1px solid var(--ck-border);
}

.header-tag {
    font-size: 11px;
    font-weight: 700;
    color: #10b981;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    gap: 4px;
}

.checkout-modal-title {
    margin: 2px 0 0 0;
    font-size: 20px;
    font-weight: 800;
    color: var(--ck-text-dark);
}

.btn-close-modal {
    background: #f1f5f9;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    color: var(--ck-text-muted);
    cursor: pointer;
    transition: 0.2s;
}

.btn-close-modal:hover {
    background: #e2e8f0;
    color: var(--ck-text-dark);
}

/* Body Layout */
.checkout-modal-body {
    padding: 24px 28px;
    max-height: 82vh;
    overflow-y: auto;
}

.checkout-grid-container {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 24px;
    align-items: start;
}

.checkout-section-card {
    background: var(--ck-card-bg);
    border: 1px solid var(--ck-border);
    border-radius: 14px;
    padding: 18px;
    margin-bottom: 16px;
}

/* Dynamic Event Banner */
.event-banner-wrapper {
    position: relative;
    height: 120px;
    width: 100%;
    background: #e2e8f0;
    overflow: hidden;
}

.event-banner-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.event-banner-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.05) 0%, rgba(0,0,0,0.55) 100%);
}

.event-id-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(4px);
    color: #fff;
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}

.event-brief-body {
    padding: 16px 18px;
}

.event-title-text {
    margin: 0 0 6px 0;
    font-size: 16px;
    font-weight: 700;
    color: var(--ck-text-dark);
}

.event-meta-info {
    display: flex;
    gap: 16px;
    font-size: 12px;
    color: var(--ck-text-muted);
}

/* Badges & Text */
.section-badge {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--ck-primary);
    margin-bottom: 12px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.section-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.count-pill {
    background: var(--ck-primary-light);
    color: var(--ck-primary);
    font-size: 11px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 12px;
}

/* Info Grid */
.info-grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.info-field label {
    display: block;
    font-size: 11px;
    color: var(--ck-text-muted);
    margin-bottom: 2px;
}

.info-field span {
    font-size: 13px;
    font-weight: 600;
    color: var(--ck-text-dark);
}

/* Participant List */
.participant-stack {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.participant-item {
    background: #f8fafc;
    border: 1px solid var(--ck-border);
    padding: 10px 14px;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.participant-name-text {
    font-size: 13px;
    font-weight: 600;
    color: var(--ck-text-dark);
}

.participant-sub-text {
    font-size: 11px;
    color: var(--ck-text-muted);
}

.same-buyer-badge {
    font-size: 10px;
    background: #dcfce7;
    color: #15803d;
    padding: 2px 6px;
    border-radius: 4px;
    font-weight: 600;
}

/* Payment Accordion Styling */
.payment-accordion-wrapper {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.payment-category-card {
    border: 1px solid var(--ck-border);
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
    transition: all 0.2s ease;
}

.payment-category-header {
    padding: 14px 16px;
    background: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    user-select: none;
    transition: background 0.2s;
}

.payment-category-header:hover {
    background: #f8fafc;
}

.payment-category-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 700;
    color: var(--ck-text-dark);
}

.category-icon-img {
    width: 20px;
    height: 20px;
    object-fit: contain;
}

.accordion-chevron {
    font-size: 14px;
    color: var(--ck-text-muted);
    transition: transform 0.3s ease;
}

/* Expanded/Active State for Accordion Header */
.payment-category-card.is-active {
    border-color: #93c5fd;
}

.payment-category-card.is-active .accordion-chevron {
    transform: rotate(180deg);
    color: var(--ck-primary);
}

.payment-category-body {
    display: none;
    padding: 12px 16px 16px 16px;
    border-top: 1px solid #f1f5f9;
    background: #f8fafc;
}

.payment-category-card.is-active .payment-category-body {
    display: block;
}

/* Payment Method Item Card */
.payment-methods-grid {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.payment-option-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 14px;
    border: 1.5px solid var(--ck-border);
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
    background: #fff;
}

.payment-option-card:hover {
    border-color: #93c5fd;
}

.payment-option-card.selected {
    border-color: var(--ck-primary);
    background: var(--ck-primary-light);
    box-shadow: 0 0 0 1px var(--ck-primary);
}

.payment-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

/* Logo Metode Pembayaran (misal QRIS, BCA, Mandiri) */
.payment-logo-img {
    width: 45px;          /* Diberi lebar yang cukup untuk logo memanjang */
    height: 24px;
    object-fit: contain;  /* Menjaga proporsi logo agar tidak gepeng */
    display: inline-block;
    vertical-align: middle;
}

/* Icon Header Kategori */
.category-icon-img {
    width: 28px;
    height: 20px;
    object-fit: contain;
    display: inline-block;
    vertical-align: middle;
}

.payment-name-text {
    font-size: 13px;
    font-weight: 600;
    color: var(--ck-text-dark);
}

.payment-fee-text {
    font-size: 12px;
    font-weight: 600;
    color: var(--ck-primary);
}

/* Sidebar Sticky Cards */
.checkout-col-sidebar {
    position: sticky;
    top: 0;
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.sidebar-card {
    background: var(--ck-card-bg);
    border: 1px solid var(--ck-border);
    border-radius: 14px;
    padding: 18px;
}

.card-title {
    margin: 0 0 12px 0;
    font-size: 14px;
    font-weight: 700;
    color: var(--ck-text-dark);
    display: flex;
    align-items: center;
    gap: 6px;
}

.ticket-type-box {
    background: #f8fafc;
    border: 1px dashed var(--ck-border);
    border-radius: 8px;
    padding: 10px;
    margin-bottom: 12px;
}

.ticket-name {
    font-size: 12px;
    font-weight: 700;
    color: var(--ck-text-dark);
}

.ticket-price-qty {
    font-size: 11px;
    color: var(--ck-text-muted);
    margin-top: 2px;
}

.summary-rows {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    color: var(--ck-text-muted);
}

/* Action Pay Card */
.action-pay-card {
    background: #ffffff;
    border-color: #cbd5e1;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
}

.pay-total-wrapper {
    margin-bottom: 12px;
}

.pay-total-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--ck-text-muted);
    text-transform: uppercase;
}

.grand-total-price {
    font-size: 22px;
    color: var(--ck-primary);
    font-weight: 800;
    letter-spacing: -0.02em;
}

.terms-disclaimer {
    font-size: 11px;
    color: var(--ck-text-muted);
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.btn-checkout-submit {
    width: 100%;
    height: 46px;
    background: var(--ck-primary);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-checkout-submit:hover {
    background: var(--ck-primary-hover);
    box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
}

.btn-checkout-cancel {
    width: 100%;
    background: transparent;
    border: none;
    color: var(--ck-text-muted);
    font-size: 12px;
    cursor: pointer;
    padding: 8px 0 0 0;
}

.text-free {
    color: #10b981;
    font-weight: 600;
}

.text-capitalize {
    text-transform: capitalize;
}

/* Responsive Sticky Footer untuk Mobile */
@media (max-width: 768px) {
    .checkout-modal-body {
        padding: 16px;
        padding-bottom: 110px;
    }

    .checkout-grid-container {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .info-grid-3 {
        grid-template-columns: 1fr;
    }

    .action-pay-card {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1055;
        margin: 0;
        border-radius: 18px 18px 0 0;
        box-shadow: 0 -8px 25px rgba(0, 0, 0, 0.12);
        background: #ffffff;
        padding: 12px 18px 16px 18px;
        border: 1px solid var(--ck-border);
        border-bottom: none;
    }

    .pay-total-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .pay-total-label {
        font-size: 11px;
    }

    .grand-total-price {
        font-size: 18px;
    }

    .terms-disclaimer,
    .btn-checkout-cancel {
        display: none;
    }

    .btn-checkout-submit {
        height: 44px;
        font-size: 14px;
    }
}
</style>
@push('transaction-scripts')

<script>
    const PaymentCheckoutModal = {
        selectedPaymentMethodId: null,
        selectedFee: 0,
        formData: null,
        summaryData: null,

        // Helper Format Rupiah
        formatRupiah(num) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(Number(num || 0));
        },

        // Render Modal Utama
        open(summary, formData) {
            this.summaryData = summary;
            this.formData = formData;

            // 1. Event Image & Information
            const eventData = summary.event || {};
            $('#modalEventTitle').text(eventData.title || '-');
            $('#modalEventId').text(eventData.id || '-');
            $('#modalEventLocation').text(eventData.location || '-');

            // Target direktori gambar event dari Storage
            if (eventData.image) {
                $('#modalEventBanner').attr('src', `/storage/event-images/${eventData.image}`);
            } else {
                $('#modalEventBanner').attr('src', 'https://via.placeholder.com/800x200?text=No+Image');
            }

            // 2. Buyer Info
            const buyer = summary.buyer || {};
            $('#modalBuyerName').text(buyer.name || '-');
            $('#modalBuyerEmail').text(buyer.email || '-');
            $('#modalBuyerPhone').text(buyer.phone || '-');

            // 3. Participants
            const participants = summary.participants || [];
            $('#modalParticipantBadge').text(`${participants.length} Peserta`);
            
            let participantHtml = '';
            if (participants.length > 0) {
                participants.forEach((p, idx) => {
                    participantHtml += `
                        <div class="participant-item">
                            <div>
                                <div class="participant-name-text">Peserta ${p.number || (idx + 1)}: ${p.name}</div>
                                <div class="participant-sub-text">${p.email} • ${p.phone}</div>
                            </div>
                            ${p.same_as_buyer ? '<span class="same-buyer-badge">Sama dgn Pemesan</span>' : ''}
                        </div>
                    `;
                });
            }
            $('#modalParticipantList').html(participantHtml);

            // 4. Ticket & Initial Billing Summary
            const ticket = summary.ticket || {};
            const subtotal = Number(summary.subtotal || 0);
            const platformFee = Number(summary.platform_fee || 0);

            $('#modalTicketName').text(ticket.name || 'Tiket');
            $('#modalTicketPrice').text(this.formatRupiah(ticket.price || 0));
            $('#modalTicketQty').text(summary.quantity || 1);
            $('#modalSubtotal').text(this.formatRupiah(subtotal));
            $('#modalPlatformFee').text(platformFee > 0 ? this.formatRupiah(platformFee) : 'Gratis');

            // 5. Render Dynamic Payment Categories & Accordions
            this.renderPaymentCategories(summary.payment_categories || [], subtotal);

            // Tampilkan Modal
            $('#checkoutConfirmModal').modal('show');
        },

        // Render Kategori Payment (Accordion)
        async renderPaymentCategories(categories, subtotal) {
            let categoriesHtml = '';
            let firstMethodId = null;
            let firstFeeCalculated = 0;

            if (categories.length > 0) {
                for (let index = 0; index < categories.length; index++) {
                    const cat = categories[index];
                    
                    /* =========================================================
                    * OPTIONAL: Icon Kategori (Di-comment untuk sementara)
                    * Uncomment bagian di bawah jika nanti butuh menampilkan icon kategori lagi
                    * =========================================================
                    let rawCatIcon = '';
                    if (cat.icon && (cat.icon.startsWith('http://') || cat.icon.startsWith('https://'))) {
                        rawCatIcon = cat.icon;
                    } else if (cat.methods && cat.methods.length > 0 && cat.methods[0].icon) {
                        rawCatIcon = cat.methods[0].icon;
                    }
                    const catIconSrc = await getSvgDataUri(rawCatIcon);
                    ========================================================= */

                    const isActive = index === 0 ? 'is-active' : '';

                    let methodsHtml = '';
                    if (cat.methods && cat.methods.length > 0) {
                        for (let mIdx = 0; mIdx < cat.methods.length; mIdx++) {
                            const method = cat.methods[mIdx];
                            
                            // Convert icon metode ke Data URI Base64
                            const methodIconSrc = await getSvgDataUri(method.icon);

                            let feeCalculated = 0;
                            let feeDisplay = 'Bebas Biaya';

                            if (method.fee_type === 'percent') {
                                feeCalculated = (subtotal * Number(method.fee_value)) / 100;
                                feeDisplay = `+${method.fee_value}% (${this.formatRupiah(feeCalculated)})`;
                            } else if (method.fee_type === 'fixed' && Number(method.fee_value) > 0) {
                                feeCalculated = Number(method.fee_value);
                                feeDisplay = `+${this.formatRupiah(feeCalculated)}`;
                            }

                            let isSelected = false;
                            if (index === 0 && mIdx === 0) {
                                isSelected = true;
                                firstMethodId = method.payment_gateway_method_id;
                                firstFeeCalculated = feeCalculated;
                            }

                            methodsHtml += `
                                <div class="payment-option-card ${isSelected ? 'selected' : ''}" 
                                    data-method-id="${method.payment_gateway_method_id}" 
                                    data-fee="${feeCalculated}">
                                    <div class="payment-left">
                                        ${methodIconSrc ? `<img src="${methodIconSrc}" class="payment-logo-img" alt="${method.name}">` : ''}
                                        <span class="payment-name-text">${method.name}</span>
                                    </div>
                                    <span class="payment-fee-text">${feeDisplay}</span>
                                </div>
                            `;
                        }
                    } else {
                        methodsHtml = '<div class="text-muted text-center py-2" style="font-size: 11px;">Tidak ada metode aktif.</div>';
                    }

                    categoriesHtml += `
                        <div class="payment-category-card ${isActive}">
                            <div class="payment-category-header">
                                <div class="payment-category-title">
                                    <!-- Icon Kategori (Di-comment) -->
                                    <!-- \${catIconSrc ? \`<img src="\${catIconSrc}" class="category-icon-img" alt="\${cat.name}">\` : ''} -->
                                    <span>${cat.name}</span>
                                </div>
                                <i class="ti ti-chevron-down accordion-chevron"></i>
                            </div>
                            <div class="payment-category-body">
                                <div class="payment-methods-grid">
                                    ${methodsHtml}
                                </div>
                            </div>
                        </div>
                    `;
                }
            }

            $('#paymentCategoriesAccordion').html(categoriesHtml);

            // Set default selection & bind events
            this.selectedPaymentMethodId = firstMethodId;
            this.selectedFee = firstFeeCalculated;
            this.recalculateTotal(firstFeeCalculated);

            $('.payment-category-header').off('click').on('click', function() {
                const card = $(this).closest('.payment-category-card');
                $('.payment-category-card').not(card).removeClass('is-active');
                card.toggleClass('is-active');
            });

            const self = this;
            $('.payment-option-card').off('click').on('click', function(e) {
                e.stopPropagation();
                $('.payment-option-card').removeClass('selected');
                $(this).addClass('selected');
                self.selectedPaymentMethodId = $(this).data('method-id');
                self.selectedFee = Number($(this).data('fee') || 0);
                self.recalculateTotal(self.selectedFee);
            });
        },

        // Kalkulasi Ulang Grand Total
        recalculateTotal(paymentFee = 0) {
            const subtotal = Number(this.summaryData?.subtotal || 0);
            const platformFee = Number(this.summaryData?.platform_fee || 0);
            const grandTotal = subtotal + platformFee + paymentFee;

            $('#modalPaymentFee').text(paymentFee > 0 ? this.formatRupiah(paymentFee) : 'Gratis');
            $('#modalGrandTotal').text(this.formatRupiah(grandTotal));
        }
    };


        // Helper untuk mengubah URL SVG menjadi Data URI yang bisa dibaca tag <img>
    async function getSvgDataUri(url) {
        if (!url) return '';
        // Jika file gambar standar (png/jpg/webp), langsung return URL-nya
        if (url.match(/\.(png|jpg|jpeg|webp)$/i)) return url;

        try {
            const response = await fetch(url);
            if (!response.ok) return url;
            let svgText = await response.text();

            // 1. Bersihkan tag script pengganggu jika ada
            svgText = svgText.replace(/<script[\s\S]*?<\/script>/gi, '');

            // 2. Pastikan atribut xmlns ada (WAJIB agar Data URI SVG valid)
            if (!svgText.includes('xmlns=')) {
                svgText = svgText.replace('<svg', '<svg xmlns="http://www.w3.org/2000/svg"');
            }

            // 3. Encode ke Base64 (Lebih stabil untuk browser)
            const base64 = btoa(unescape(encodeURIComponent(svgText)));
            return `data:image/svg+xml;base64,${base64}`;
        } catch (e) {
            console.warn('Gagal fetch SVG, fallback ke URL asal:', e);
            return url;
        }
    }

    // Listener Tombol Submit Bayar Sekarang
    function setCheckoutLoading(isLoading) {

        const submitBtn = $('#btnSubmitCheckout');
        const cancelBtn = $('.btn-checkout-cancel');
        const closeBtn = $('.btn-close-modal');

        if (isLoading) {

            submitBtn
                .prop('disabled', true)
                .html(`
                    <i class="ti ti-loader-2 ti-spin"></i>
                    <span>Membuat Transaksi...</span>
                `);

            cancelBtn.prop('disabled', true);
            closeBtn.prop('disabled', true);

        } else {

            submitBtn
                .prop('disabled', false)
                .html(`
                    <span>Bayar Sekarang</span>
                    <i class="ti ti-arrow-right"></i>
                `);

            cancelBtn.prop('disabled', false);
            closeBtn.prop('disabled', false);

        }

    }

    $('#btnSubmitCheckout').off('click').on('click', async function () {

        if (!PaymentCheckoutModal.selectedPaymentMethodId) {
            return showToast('warning', 'Silakan pilih metode pembayaran.');
        }

        setCheckoutLoading(true);

        try {

            PaymentCheckoutModal.formData.set(
                'payment_gateway_method_id',
                PaymentCheckoutModal.selectedPaymentMethodId
            );

            await submitCheckout(PaymentCheckoutModal.formData);

        } catch (error) {

            console.error(error);

            setCheckoutLoading(false);

            showToast(
                'error',
                error.message || 'Terjadi kesalahan saat memproses pembayaran.'
            );

        }

    });

    async function submitCheckout(formData) {

        try {

            const response = await fetch('/checkout/store', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });

            const contentType = response.headers.get('content-type') ?? '';

            if (!contentType.includes('application/json')) {

                throw new Error(
                    response.status >= 500
                        ? 'Terjadi kesalahan pada server.'
                        : 'Server mengembalikan response yang tidak valid.'
                );

            }

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message ?? 'Checkout gagal.');
            }

            window.location.replace(result.redirect_url);

        } catch (error) {

            if (error instanceof TypeError) {
                throw new Error('Tidak dapat terhubung ke server.');
            }

            throw error;

        }

    }

    function showToast(icon, title) {

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon,
            title,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

    }
</script>
    
@endpush