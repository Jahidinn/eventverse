<script>
/* =========================================================
   COPY BUYER DATA
========================================================= */
function copyBuyerData(participant) {
    const buyerName = document.getElementById('buyerName')?.value || '';
    const buyerEmail = document.getElementById('buyerEmail')?.value || '';
    const buyerPhone = document.getElementById('buyerPhone')?.value || '';

    copyField('full_name', buyerName, participant);
    copyField('email', buyerEmail, participant);
    copyPhone('phone', buyerPhone, participant);
}

function copyField(fieldKey, value, participant) {
    participant.querySelectorAll(`[data-field-key="${fieldKey}"]`).forEach(function (el) {
        if (el.tagName === 'SELECT' && el._choices) {
            el._choices.setChoiceByValue(value);
        } else {
            el.value = value;
        }
        el.dispatchEvent(new Event('change', { bubbles: true }));
    });
}

function copyPhone(fieldKey, value, participant) {
    participant.querySelectorAll(`[data-field-key="${fieldKey}"]`).forEach(function (el) {
        let iti = el._iti
            || (window.intlTelInputGlobals?.getInstance(el));

        if (iti) iti.setNumber(value);
        else el.value = value;

        el.dispatchEvent(new Event('change', { bubbles: true }));
    });
}

function clearBuyerData(participant) {
    copyField('full_name', '', participant);
    copyField('email', '', participant);
    clearPhone('phone', participant);
}

function clearPhone(fieldKey, participant) {
    participant.querySelectorAll(`[data-field-key="${fieldKey}"]`).forEach(function (el) {
        let iti = el._iti
            || (window.intlTelInputGlobals?.getInstance(el));

        if (iti) iti.setCountry('id');
        else el.value = '';

        el.dispatchEvent(new Event('change', { bubbles: true }));
    });
}

function toggleBuyerFields(participant, readonly) {
    participant.querySelectorAll('[data-field-key="full_name"], [data-field-key="email"]').forEach(function (el) {
        el.classList.toggle('field-locked', readonly);
        readonly ? el.setAttribute('readonly', 'readonly') : el.removeAttribute('readonly');
    });

    participant.querySelectorAll('[data-field-key="phone"]').forEach(function (el) {
        el.classList.toggle('field-locked', readonly);
        el.classList.toggle('phone-readonly', readonly);
        readonly ? el.setAttribute('readonly', 'readonly') : el.removeAttribute('readonly');
    });
}


/* =========================================================
   LISTENERS
========================================================= */

/* Checkbox "Samakan data pemesan" (delegated) */
document.addEventListener('change', function (e) {
    if (!e.target.matches('.participant-copy')) return;

    const participant = e.target.closest('.participant-card');
    const hidden = participant.querySelector('.same-as-buyer');

    if (e.target.checked) {
        hidden.value = 1;
        copyBuyerData(participant);
        toggleBuyerFields(participant, true);
    } else {
        hidden.value = 0;
        clearBuyerData(participant);
        toggleBuyerFields(participant, false);
    }
});

/* Buyer berubah → sync ke semua participant yang dicentang */
['buyerName', 'buyerEmail', 'buyerPhone'].forEach(function (id) {
    const el = document.getElementById(id);
    if (!el) return;

    const handler = function () {
        document.querySelectorAll('.participant-copy:checked').forEach(function (cb) {
            copyBuyerData(cb.closest('.participant-card'));
        });
    };

    el.addEventListener('keyup', handler);
    el.addEventListener('change', handler);
});
</script>