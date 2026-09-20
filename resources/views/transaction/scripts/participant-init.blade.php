<script>
/* =========================================================
   INIT THIRD-PARTY COMPONENTS (Choices, Flatpickr, intlTelInput)
========================================================= */
function initParticipantComponents() {

    /* ---------- Choices ---------- */
    document.querySelectorAll('.ev-select').forEach(function (el) {
        if (el._choices) return;

        el._choices = new Choices(el, {
            searchEnabled: false,
            shouldSort: false,
            itemSelectText: '',
            allowHTML: false,
        });
    });

    /* ---------- Flatpickr: Date ---------- */
    document.querySelectorAll('.date-picker').forEach(function (el) {
        if (el._flatpickr) return;

        flatpickr(el, {
            dateFormat: 'd M Y',
            allowInput: true,
        });
    });

    /* ---------- Flatpickr: Time ---------- */
    document.querySelectorAll('.time-picker').forEach(function (el) {
        if (el._flatpickr) return;

        flatpickr(el, {
            enableTime: true,
            noCalendar: true,
            dateFormat: 'H:i',
            time_24hr: true,
        });
    });

    /* ---------- intlTelInput ---------- */
    document.querySelectorAll('.phone-input').forEach(function (el) {
        if (el._iti) return;

        const iti = window.intlTelInput(el, {
              initialCountry: 'id',
            countryOrder: ['id'],
            separateDialCode: false,
            strictMode: true,
            numberDisplayFormat: 'E164',

            placeholderNumberPolicy: 'OFF',

            // ← pengganti utilsScript
            loadUtils: () => import('https://cdn.jsdelivr.net/npm/intl-tel-input@29.2.3/dist/js/utils.js'),

            // Styling Tailwind (opsional, kalau mau seragam)
            classNames: {
                container: '!w-full',
                input: '!w-full !h-11 !border-[1.5px] !border-[#cbd5e1] !rounded-lg !bg-white !text-sm !text-[#0f172a] !outline-none focus:!border-[#2282ff]',
            },
        });

        iti.setNumber('+62');
        el._iti = iti;
    });
}


/* =========================================================
   PHONE PREFIX HANDLER (+62 enforcement)
========================================================= */
function enforcePhonePrefix(input) {
    if (input.value.startsWith('+62')) return;

    let num = input.value.replace(/\D/g, '');
    num = num.replace(/^62/, '');
    num = num.replace(/^0/, '');
    input.value = '+62' + num;
}

function lockCursorAfterPrefix(input) {
    if (input.selectionStart < 3) input.setSelectionRange(3, 3);
}

/* ---------- Buyer phone (special — no .phone-input class) ---------- */
const buyerPhone = document.getElementById('buyerPhone');

if (buyerPhone) {
    buyerPhone.value = '+62';

    buyerPhone.addEventListener('input', function () { enforcePhonePrefix(this); });
    buyerPhone.addEventListener('click', function () { lockCursorAfterPrefix(this); });
    buyerPhone.addEventListener('keydown', function (e) {
        if ((e.key === 'Backspace' && this.selectionStart <= 3) ||
            (e.key === 'Delete' && this.selectionStart < 3)) {
            e.preventDefault();
        }
    });
}

/* ---------- Delegation untuk .phone-input (termasuk yg baru dirender) ---------- */
document.addEventListener('input', function (e) {
    if (e.target.matches('.phone-input')) enforcePhonePrefix(e.target);
});

document.addEventListener('click', function (e) {
    if (e.target.matches('.phone-input')) lockCursorAfterPrefix(e.target);
});

document.addEventListener('keydown', function (e) {
    if (!e.target.matches('.phone-input')) return;

    if ((e.key === 'Backspace' && e.target.selectionStart <= 3) ||
        (e.key === 'Delete' && e.target.selectionStart < 3)) {
        e.preventDefault();
    }
});
</script>