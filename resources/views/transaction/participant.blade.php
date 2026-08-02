<div class="checkout-section-title mt-3 text-center">
    Data Peserta
</div>

<div id="participantContainer"></div>

<template id="participantTemplate">

    <div class="participant-card">

        <div class="participant-body">

            <div class="participant-header">

                <div class="participant-title-group">
                    <h3 class="participant-title">
                        Peserta <span class="participant-number">1</span>
                    </h3>
                    <p class="participant-desc">
                        Lengkapi data peserta berikut.
                    </p>
                </div>

                <!-- DIPERBAIKI: Menggunakan label wrapper netral tanpa class form-check Bootstrap -->
                <label class="participant-copy-btn" for="copy___INDEX__">
                    <input
                        type="checkbox"
                        class="participant-copy"
                        id="copy___INDEX__">
                    <span>Samakan data pemesan</span>
                </label>

            </div>

            {{-- Hidden --}}
            <input
                type="hidden"
                name="participants[__INDEX__][same_as_buyer]"
                class="same-as-buyer"
                value="0">

            {{-- Custom Form --}}
            @include('transaction.participant-fields',[
                'index'=>'__INDEX__'
            ])

        </div>

    </div>

</template>