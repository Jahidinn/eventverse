<script>
    //Javascript Menangani Edit event

    //preview image
    const editFileUpload = (editImage) => {

        const files = editImage.target.files;
        const filesLength = files.length;
        if (filesLength > 0) {
            const imageSrc = URL.createObjectURL(files[0]);
            const imagePreviewElement = document.querySelector("#tb-image-edit");
            imagePreviewElement.src = imageSrc;
            imagePreviewElement.style.display = "block";
        }
    };

    // peringatan meninggalkan halaman saat transaksi
    window.onbeforeunload = function() {
        return "Apakah Anda yakin ingin meninggalkan halaman ini?";
    };

    //cek validasi file
    var edit = document.getElementById("tb-file-upload-edit")

    edit.addEventListener('change', function() {
        var prevImage = $('#prev-image-event').val();
        var fileLimit = 600; // could be whatever you want
        var files = edit.files; //this is an array
        var fileSize = files[0].size; //
        var fileSizeInKB = (fileSize / 1024); // this would be in kilobytes defaults to bytes

        if (fileSizeInKB < fileLimit) {
            $('#image-warning').hide();

            form = new FormData();
            var featured_image = edit.files[0];
            var eventId = $('#id-event').val();

            form.append('bannerEventEdit', featured_image);
            form.append('eventId', eventId);

            //Ajax proses edit banner / poster
            $.ajax({
                type: 'POST',
                url: "{{ url('/event-edit-image') }}",
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        Swal.fire('Ooopss', response.error, 'error');
                        document.querySelector("#tb-image-edit").src =
                            "{{ asset('storage/event-images') }}/" + prevImage;
                    } else {
                        editFileUpload({
                            target: {
                                files: [edit.files[0]]
                            }
                        });
                        $('#prev-image-event').val(response.img);
                        Swal.fire('Ok!', response.success, 'success');
                    }
                }
            });

        } else {
            $('#image-warning').removeAttr('hidden');
            $('#image-warning').show();
            Swal.fire(
                'Error',
                'Ukuran file lebih dari 500KB! upload ulang ya!',
                'error'
            );
            document.querySelector("#tb-image-edit").src =
                "{{ asset('storage/event-images') }}/" + prevImage;
            // do not pass go, do not add to db. Pass error to user  
        }
    });

    $(document).ready(function(e) {

        var jenisLokasi = '{{ $detailEvent->location_jenis }}';
        var province = '{{ $detailEvent->location_province }}';

        //hidden pilih lokasi ketika eventnya online
        if (jenisLokasi == 'Online') {
            $('#lokasi-event-container').attr('hidden', true);
        } else {
            // $.ajax({
            //     url: '/get-cities/' + province,
            //     type: 'GET',
            //     cache: false,
            //     dataType: 'JSON',
            //     success: function(response) {
            //         var city = $('#cities');
            //         city.removeAttr('disabled');

            //         $.each(response.result, function(key, value) {

            //             $("#cities").append('<option value="' + value.name +
            //                 '">' +
            //                 value.name +
            //                 '</option>');
            //         });

            //     }

            // });
        }

        $(function() {
            $("#editEventStartDate").datepicker({
                autoclose: true,
                todayHighlight: true
            }).datepicker('update', new Date('{{ $detailEvent->start_date }}'));

            $("#editEventEndDate").datepicker({
                autoclose: true,
                todayHighlight: true
            }).datepicker('update', new Date('{{ $detailEvent->end_date }}'));
        });

        var jenisPenyelenggara = '{{ $detailEvent->organizer }}';
        var org = 'org';
        var individual = 'individual';

        if (jenisPenyelenggara === 'org') {
            $('.event-no-org').attr('hidden', true);
            $('.cont-org').attr('hidden', false);
            $('.cont-individual').attr('hidden', true);
            $('#penyelenggaraEvent').val(
                '{{ $detailEvent->org ? $detailEvent->org->org_name : '' }}');
        } else {
            $('.event-no-org').attr('hidden', false);
            $('.cont-org').attr('hidden', true);
            $('.cont-individual').attr('hidden', false);
            $('#penyelenggaraEvent').val(
                '{{ $detailEvent->individual ? $detailEvent->individual->name : '' }}');
        }

        //cek ketersediaan URL
        $('#url-event-edit').on('keyup', function(e) {
            e.preventDefault();
            var prevUrl = '{{ $detailEvent->slug }}';
            var url = $('#url-event-edit').val();

            if (url == prevUrl) {
                $('#url-notif-danger').attr('hidden', true);
                $('#url-notif-success').attr('hidden', true);
            } else {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('/check-url') }}",
                    data: {
                        url: url
                    },
                    success: function(response) {
                        if (response.result == 0) {
                            $('#url-notif-danger').attr('hidden', true);
                            $('#url-notif-success').removeAttr('hidden');
                        } else if (response.result == 'N') { //jika null
                            $('#url-notif-danger').attr('hidden', true);
                            $('#url-notif-success').attr('hidden', true);
                        } else {
                            $('#url-notif-danger').removeAttr('hidden');
                            $('#url-notif-success').attr('hidden', true);
                        }
                    }
                });
            }

        });

    });


    $('#form-event-edit').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: "{{ url('/event-edit') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.error) {
                    Swal.fire('', response.error, 'error');
                } else {
                    Swal.fire({
                        text: response.success,
                        icon: 'success',
                        willClose: () => {
                            // Aksi yang akan dijalankan setelah alert ditutup
                            window.location.href = "/" + response.url;
                        }
                    });

                }
            }
        });
    });
</script>
