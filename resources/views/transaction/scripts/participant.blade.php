<script>
/* =========================================================
   RENDER PARTICIPANTS (dari template)
========================================================= */
function renderParticipants(qty) {
    const container = document.getElementById('participantContainer');
    if (!container) return;

    const cards = container.querySelectorAll('.participant-card');
    const current = cards.length;

    if (qty > current) {
        const template = document.getElementById('participantTemplate');

        for (let i = current; i < qty; i++) {
            const fragment = template.content.cloneNode(true);

            fragment.querySelectorAll('*').forEach(function (el) {
                if (el.name) el.name = el.name.replace(/__INDEX__/g, i);
                if (el.id) el.id = el.id.replace(/__INDEX__/g, i);
                if (el.htmlFor) el.htmlFor = el.htmlFor.replace(/__INDEX__/g, i);
            });

            container.appendChild(fragment);
        }

    } else if (qty < current) {
        for (let i = current - 1; i >= qty; i--) {
            cards[i].remove();
        }
    }

    /* Re-number */
    container.querySelectorAll('.participant-card').forEach(function (card, index) {
        const numEl = card.querySelector('.participant-number');
        if (numEl) numEl.textContent = index + 1;
    });

    /* Re-init library */
    if (typeof initParticipantComponents === 'function') {
        initParticipantComponents();
    }
}


/* =========================================================
   LISTEN: qty berubah
========================================================= */
window.addEventListener('qty-changed', function (e) {
    renderParticipants(Number(e.detail.qty) || 1);
});
</script>