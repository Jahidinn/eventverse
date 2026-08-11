<script>
    
    $(function () {

        const ticketPrice = Number($('#ticketPrice').val());
        const maxQty = Number($('#maxQty').val() || 999999);

        let qty = Number($('#ticketQty').val()) || 1;

        updateSummary();

        if (typeof renderParticipants === 'function') {
            renderParticipants(qty);
        }

        async function updateReservation(quantity) {

            return $.ajax({
                url: "{{ route('reservation.update', ['reservationCode' => $reservation->reservation_code]) }}",
                type: "PATCH",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    quantity: quantity
                }
            });

        }

        /*
        |--------------------------------------------------------------------------
        | Minus
        |--------------------------------------------------------------------------
        */

        $('#qtyMinus').on('click', async function () {

            if (qty <= 1) {

                Toast.fire({
                    icon: 'warning',
                    title: 'Minimal pembelian 1 tiket.'
                });

                return;
            }

            try {

                const response = await updateReservation(qty - 1);

                qty = Number(response.quantity);

                $('#ticketQty').val(qty);

                updateSummary();

                if (typeof renderParticipants === 'function') {
                    renderParticipants(qty);
                }

            } catch (xhr) {

                let message = 'Terjadi kesalahan pada server.';

                if (xhr.responseJSON?.errors) {
                    message = Object.values(xhr.responseJSON.errors)[0][0];
                } else if (xhr.responseJSON?.message) {
                    message = xhr.responseJSON.message;
                }

                Toast.fire({
                    icon: 'error',
                    title: message
                });

            }

        });

        /*
        |--------------------------------------------------------------------------
        | Plus
        |--------------------------------------------------------------------------
        */

        $('#qtyPlus').on('click', async function () {

            if (qty >= maxQty) {

                Toast.fire({
                    icon: 'warning',
                    title: `Maksimal ${maxQty} tiket tersedia.`
                });

                return;
            }

            try {

                const response = await updateReservation(qty + 1);

                qty = Number(response.quantity);

                $('#ticketQty').val(qty);

                updateSummary();

                if (typeof renderParticipants === 'function') {
                    renderParticipants(qty);
                }

            } catch (xhr) {

                let message = 'Terjadi kesalahan pada server.';

                if (xhr.responseJSON?.errors) {
                    message = Object.values(xhr.responseJSON.errors)[0][0];
                } else if (xhr.responseJSON?.message) {
                    message = xhr.responseJSON.message;
                }

                Toast.fire({
                    icon: 'error',
                    title: message
                });

            }

        });

        /*
        |--------------------------------------------------------------------------
        | Update Summary
        |--------------------------------------------------------------------------
        */

        function updateSummary() {

            const total = ticketPrice * qty;

            $('#summaryQty').text(
                `Qty ${qty} Ticket${qty > 1 ? 's' : ''}`
            );

            if (ticketPrice <= 0) {

                $('#summaryPrice').text('GRATIS');

            } else {

                $('#summaryPrice').text(formatRupiah(total));

            }

            $('#quantity').val(qty);
            $('#totalPrice').val(total);

        }

    });

function formatRupiah(number) {

    return 'Rp ' + Number(number).toLocaleString('id-ID');

}
</script>