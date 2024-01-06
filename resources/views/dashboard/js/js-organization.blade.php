<script>
    $('body').on('click', '.kelola-org-from-add', function(e) {
        e.preventDefault();

        $('#addOrganisasiModal').modal('hide');
        setTimeout(function() {
            $('#kelolaOragisasiModal').modal('show');
        }, 500);

    })

    $('body').on('click', '.buat-organisasi', function(e) {
        e.preventDefault();
        $('#addOrgModal').modal('show');
    })
</script>
