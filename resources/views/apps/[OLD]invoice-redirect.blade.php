<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="0;url={{ url('/event/invoice/') }}/{{ $invoiceId }}">
    <title>Redirecting...</title>
</head>

<body>
    <p>If you are not redirected, <a href="{{ url('/event/invoice/') }}/{{ $invoiceId }}">click here</a>.</p>
    <script>
        // JavaScript fallback in case meta refresh doesn't work
        window.location.href = "{{ url('/event/invoice/') }}/{{ $invoiceId }}";
    </script>
</body>

</html>
