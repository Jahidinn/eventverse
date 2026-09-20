<h3 class="text-base font-extrabold text-[#0f172a] text-center mt-4 mb-3">
    Data Peserta
</h3>

<div id="participantContainer"></div>

<template id="participantTemplate">
    <div class="participant-card bg-white border-[1.5px] border-[#e2e8f0] rounded-2xl p-5 sm:p-6 mb-5 shadow-[0_2px_10px_-4px_rgba(15,23,42,0.04)]">
        <div class="participant-body">

            <div class="participant-header flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 pb-4 mb-5 border-b border-[#f1f5f9]">
                <div>
                    <h3 class="text-base font-extrabold text-[#0f172a] m-0">
                        Peserta <span class="participant-number">1</span>
                    </h3>
                    <p class="text-xs text-[#64748b] mt-0.5 m-0">Lengkapi data peserta berikut.</p>
                </div>

                <label class="participant-copy-btn inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#ebf3ff] border border-[#c2dcff] rounded-full cursor-pointer w-fit"
                       for="copy___INDEX__">
                    <input type="checkbox"
                           class="participant-copy w-4 h-4 accent-[#2282ff] cursor-pointer m-0"
                           id="copy___INDEX__">
                    <span class="text-xs font-bold text-[#2282ff] whitespace-nowrap">Samakan data pemesan</span>
                </label>
            </div>

            <input type="hidden"
                   name="participants[__INDEX__][same_as_buyer]"
                   class="same-as-buyer"
                   value="0">

            @include('transaction.participant-fields', ['index' => '__INDEX__'])
        </div>
    </div>
</template>