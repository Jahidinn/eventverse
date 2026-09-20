<script>
/* =========================================================
   FORM SUBMIT: VALIDATE CHECKOUT → OPEN MODAL
========================================================= */
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('checkout-event');
    const button = document.getElementById('checkout-button');

    if (!form) return;

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        button.disabled = true;
        const oldHtml = button.innerHTML;
        button.innerHTML = `
            <i class="ti ti-loader-2 animate-spin"></i>
            <span>Memproses...</span>
        `;

        try {
            // 1. Bersihkan phone input DULU (ubah nilai di DOM)
            document.querySelectorAll('.phone-input').forEach(input => {
                const cleaned = input.value.replace(/[^\d+]/g, '');
                if (input.value !== cleaned) {
                    input.value = cleaned;
                }
            });

            // 2. Snapshot formData SETELAH cleanup
            const formData = new FormData(form);

            const res = await fetch("{{ route('checkout.validate') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData,
            });

            const result = await res.json();
            if (!res.ok) throw result;

            // 3. Buka modal
            window.openCheckoutModal(result.summary, formData);

            // 4. TUNGGU modal benar-benar terbuka (biar loading terasa)
            await new Promise(resolve => {
                window.addEventListener('checkout-modal-opened', resolve, { once: true });
                setTimeout(resolve, 5000); // Fallback max 5 detik
            });

        } catch (error) {
            console.error(error);

            if (error.errors) {
                Object.values(error.errors).forEach(messages => {
                    messages.forEach(msg => showToast('error', msg));
                });
            } else {
                showToast('error', error.message ?? 'Terjadi kesalahan pada server.');
            }
        } finally {
            button.disabled = false;
            button.innerHTML = oldHtml;
        }
    });

});
</script>