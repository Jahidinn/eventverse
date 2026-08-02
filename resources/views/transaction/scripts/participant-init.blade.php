<script>
    function initParticipantComponents() {

        /*
        |--------------------------------------------------------------------------
        | Choices
        |--------------------------------------------------------------------------
        */

        $('.ev-select').each(function () {

            if ($(this).data('choices')) return;

            const choice = new Choices(this, {

                searchEnabled: false,

                shouldSort: false,

                itemSelectText: '',

                allowHTML: false

            });

            $(this).data('choices', choice);

        });


        /*
        |--------------------------------------------------------------------------
        | Flatpickr Date
        |--------------------------------------------------------------------------
        */

        $('.date-picker').each(function(){

            if(this._flatpickr) return;

            flatpickr(this,{

                dateFormat:"d M Y",

                allowInput:true

            });

        });


        /*
        |--------------------------------------------------------------------------
        | Flatpickr Time
        |--------------------------------------------------------------------------
        */

        $('.time-picker').each(function(){

            if(this._flatpickr) return;

            flatpickr(this,{

                enableTime:true,

                noCalendar:true,

                dateFormat:"H:i",

                time_24hr:true

            });

        });


        /*
        |--------------------------------------------------------------------------
        | Phone
        |--------------------------------------------------------------------------
        */

        $('.phone-input').each(function(){

            if($(this).data('iti')) return;

            const iti = window.intlTelInput(this,{

                initialCountry:"id",

                preferredCountries:["id"],

                separateDialCode:false,

                strictMode:true,

                utilsScript:"https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/utils.js"

            });
            iti.setNumber("+62");

            $(this).data('iti',iti);

        });

    }

    const buyerPhone = document.getElementById('buyerPhone');

// Default
buyerPhone.value = '+62';

// Saat mengetik
buyerPhone.addEventListener('input', function () {

    // Jika +62 hilang, kembalikan lagi
    if (!this.value.startsWith('+62')) {

        // Ambil hanya angka yang diketik user
        let number = this.value.replace(/\D/g, '');

        // Hilangkan 62 atau 0 di depan jika ada
        number = number.replace(/^62/, '');
        number = number.replace(/^0/, '');

        this.value = '+62' + number;
    }

});

// Cegah cursor masuk ke depan +62
buyerPhone.addEventListener('click', function () {

    if (this.selectionStart < 3) {
        this.setSelectionRange(3, 3);
    }

});

buyerPhone.addEventListener('keydown', function (e) {

    // Tidak boleh backspace/delete pada +62
    if (
        (e.key === 'Backspace' && this.selectionStart <= 3) ||
        (e.key === 'Delete' && this.selectionStart < 3)
    ) {
        e.preventDefault();
    }

});

$(document).on('input', '.phone-input', function () {

    if (!this.value.startsWith('+62')) {

        let number = this.value.replace(/\D/g, '');

        number = number.replace(/^62/, '');
        number = number.replace(/^0/, '');

        this.value = '+62' + number;
    }

});

$(document).on('click', '.phone-input', function () {

    if (this.selectionStart < 3) {
        this.setSelectionRange(3, 3);
    }

});

$(document).on('keydown', '.phone-input', function (e) {

    if (
        (e.key === 'Backspace' && this.selectionStart <= 3) ||
        (e.key === 'Delete' && this.selectionStart < 3)
    ) {
        e.preventDefault();
    }

});
</script>