<script>
    //invoice protection
    $(document).ready(function() {
        var currentUrl = document.referrer
        var prevURL = '{{ env('APP_URL_INVOICE') }}';
        var prevURL2 = '{{ env('APP_URL_INVOICE2') }}';
        var prevURL3 = '{{ env('APP_URL_INVOICE3') }}';

        //Keamanan akses invoice
        if (currentUrl.indexOf(prevURL) !== -1 || currentUrl.indexOf(prevURL2) !== -1 || currentUrl.indexOf(
                prevURL3) !== -1) {
            $('#invoice_page').removeAttr('hidden');
            $('#invoice_page').attr('hidden', false);
        } else {
            window.location.href = '/';
        }
    });

    $('body').on('click', '#download-invoice', function(e) {
        e.preventDefault();
        var url = '{{ env('APP_URL_INVOICE') }}';

        var id_transaksi = $(this).data('id_transaksi');
        window.location.href = '/generate-pdf?id_transaksi=' + id_transaksi + '&url=' + url
    })
</script>
