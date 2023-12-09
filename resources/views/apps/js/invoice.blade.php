<script>
    //invoice protection
    $(document).ready(function() {
        var referrer = document.referrer
        console.log(referrer);
        if (referrer == '' || referrer == null) {
            window.location.href = '/'
        } else {
            $('#invoice_page').removeAttr('hidden');
            $('#invoice_page').attr('hidden', false);
        }
    });
</script>
