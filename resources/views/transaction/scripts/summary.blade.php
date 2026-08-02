<script>
    $(function () {

        const ticketPrice = Number($('#ticketPrice').val());
        const maxQty = Number($('#maxQty').val() || 999999);

        let qty = Number($('#ticketQty').val()) || 1;

        updateSummary();

        if (typeof renderParticipants === 'function') {
            renderParticipants(qty);
        }

        /*
        |--------------------------------------------------------------------------
        | Minus
        |--------------------------------------------------------------------------
        */

        $('#qtyMinus').on('click', function () {

            if (qty <= 1) return;

            qty--;

            $('#ticketQty').val(qty);

            updateSummary();

            if (typeof renderParticipants === 'function') {
                renderParticipants(qty);
            }

        });

        /*
        |--------------------------------------------------------------------------
        | Plus
        |--------------------------------------------------------------------------
        */

        $('#qtyPlus').on('click', function () {

            if (qty >= maxQty) return;

            qty++;

            $('#ticketQty').val(qty);

            updateSummary();

            if (typeof renderParticipants === 'function') {
                renderParticipants(qty);
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
                qty + ' Ticket' + (qty > 1 ? 's' : '')
            );

            if (ticketPrice <= 0) {

                $('#summaryPrice').text('GRATIS');

            } else {

                $('#summaryPrice').text(formatRupiah(total));

            }

            $('#quantity').val(qty);

            $('#totalPrice').val(total);

            $('#qtyMinus').prop('disabled', qty <= 1);

            $('#qtyPlus').prop('disabled', qty >= maxQty);

        }

    });

    function formatRupiah(number) {

        return 'Rp ' + Number(number).toLocaleString('id-ID');

    }
</script>