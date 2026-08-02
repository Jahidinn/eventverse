<script>
    $(function () {

        /*
        |--------------------------------------------------------------------------
        | Samakan Data Pemesan
        |--------------------------------------------------------------------------
        */

        $(document).on('change', '.participant-copy', function () {

            const participant = $(this).closest('.participant-card');
            const hidden = participant.find('.same-as-buyer');

            if ($(this).is(':checked')) {

            hidden.val(1);

            copyBuyerData(participant);

            toggleBuyerFields(participant, true);

        } else {

            hidden.val(0);

            clearBuyerData(participant);

            toggleBuyerFields(participant, false);

        }

        });


        /*
        |--------------------------------------------------------------------------
        | Buyer berubah
        |--------------------------------------------------------------------------
        */

        $('#buyerName, #buyerEmail, #buyerPhone').on('keyup change', function () {

            $('.participant-copy:checked').each(function () {

                copyBuyerData(
                    $(this).closest('.participant-card')
                );

            });

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Copy Semua Data Buyer
    |--------------------------------------------------------------------------
    */

    function copyBuyerData(participant) {

        const buyerName = $('#buyerName').val();
        const buyerEmail = $('#buyerEmail').val();
        const buyerPhone = $('#buyerPhone').val();

        copyField('full_name', buyerName, participant);

        copyField('email', buyerEmail, participant);

        copyPhone('phone', buyerPhone, participant);

    }


    /*
    |--------------------------------------------------------------------------
    | Copy Text Field
    |--------------------------------------------------------------------------
    */

    function copyField(fieldKey, value, participant) {

        participant.find('[data-field-key="' + fieldKey + '"]').each(function () {

            const element = $(this);

            if (element.is('select')) {

                const choices = element.data('choices');

                if (choices) {

                    choices.setChoiceByValue(value);

                } else {

                    element.val(value).trigger('change');

                }

            } else {

                element.val(value).trigger('change');

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Copy Phone
    |--------------------------------------------------------------------------
    */

    function copyPhone(fieldKey, value, participant) {

        participant.find('[data-field-key="' + fieldKey + '"]').each(function () {

            const input = $(this);

            let iti = input.data('iti');

            if (!iti && window.intlTelInputGlobals) {
                iti = window.intlTelInputGlobals.getInstance(this);
            }

            if (iti) {
                iti.setNumber(value);
            } else {
                input.val(value);
            }

            input.trigger('change');
        });

    }

    function clearBuyerData(participant) {

        copyField('full_name', '', participant);
        copyField('email', '', participant);
        clearPhone('phone', participant);

    }

    function clearPhone(fieldKey, participant) {

        participant.find('[data-field-key="' + fieldKey + '"]').each(function () {

            const input = $(this);

            let iti = input.data('iti');

            if (!iti && window.intlTelInputGlobals) {
                iti = window.intlTelInputGlobals.getInstance(this);
            }

            if (iti) {
                iti.setCountry('id');
            } else {
                input.val('');
            }

            input.trigger('change');
        });

    }

    function toggleBuyerFields(participant, readonly) {

        participant.find('[data-field-key="full_name"], [data-field-key="email"]').each(function () {

            $(this)
                .toggleClass('field-locked', readonly)
                .prop('readonly', readonly);

        });

        participant.find('[data-field-key="phone"]').each(function () {

            $(this)
                .toggleClass('field-locked phone-readonly', readonly)
                .prop('readonly', readonly);

        });

    }
</script>