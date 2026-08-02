<script>
    const form = document.getElementById('checkout-event');
    const button = document.getElementById('checkout-button');

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    form.addEventListener('submit', checkout);

    async function checkout(e) {

        e.preventDefault();

        button.disabled = true;

        const oldHtml = button.innerHTML;

        button.innerHTML = `
            <i class="ti ti-loader ti-spin"></i>
            Memproses...
        `;

        try {

            const formData = new FormData(form);

            const response = await fetch("{{ route('checkout.validate') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });

            const result = await response.json();

            if (!response.ok) {
                throw result;
            }

            console.log(result.summary);

            // TAMPILKAN POPUP MODAL BARU
            PaymentCheckoutModal.open(result.summary, formData);

            /*
            |--------------------------------------------------------------------------
            | TODO
            |--------------------------------------------------------------------------
            | Tampilkan popup konfirmasi + pilih pembayaran
            | Setelah user klik "Bayar", panggil:
            |
            | await submitCheckout(formData);
            */

        } catch (error) {

            console.error(error);

            if (error.errors) {

                Object.values(error.errors).forEach(messages => {

                    messages.forEach(message => {

                        Toast.fire({
                            icon: 'error',
                            title: message
                        });

                    });

                });

            } else {

                Toast.fire({
                    icon: 'error',
                    title: error.message ?? 'Terjadi kesalahan pada server.'
                });

            }

        } finally {

            button.disabled = false;
            button.innerHTML = oldHtml;

        }

    }

    // async function submitCheckout(formData) {

    //     button.disabled = true;

    //     const oldHtml = button.innerHTML;

    //     button.innerHTML = `
    //         <i class="ti ti-loader ti-spin"></i>
    //         Memproses...
    //     `;

    //     try {

    //         const response = await fetch("{{ route('checkout.store') }}", {
    //             method: 'POST',
    //             headers: {
    //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    //                 'Accept': 'application/json',
    //                 'X-Requested-With': 'XMLHttpRequest'
    //             },
    //             body: formData
    //         });

    //         const result = await response.json();

    //         if (!response.ok) {
    //             throw result;
    //         }

    //         window.location.href = result.redirect;

    //     } catch (error) {

    //         console.error(error);

    //         if (error.errors) {

    //             Object.values(error.errors).forEach(messages => {

    //                 messages.forEach(message => {

    //                     Toast.fire({
    //                         icon: 'error',
    //                         title: message
    //                     });

    //                 });

    //             });

    //         } else {

    //             Toast.fire({
    //                 icon: 'error',
    //                 title: error.message ?? 'Terjadi kesalahan pada server.'
    //             });

    //         }

    //     } finally {

    //         button.disabled = false;
    //         button.innerHTML = oldHtml;

    //     }

    // }

</script>