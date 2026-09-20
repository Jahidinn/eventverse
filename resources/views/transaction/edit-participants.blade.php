@extends('layouts.app')

@section('title', 'Edit Data Peserta - ' . $transaction->transaction_code)

@section('content')

<section class="bg-[#f8fafc] pt-4 pb-24 min-h-screen"
         x-data="editParticipantsPage()"
         x-init="init()">

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- ==================== BREADCRUMB ==================== --}}
    <nav class="flex items-center gap-2 text-xs text-[#64748b] mb-4">
        <a href="{{ route('transaction.detail', $transaction->transaction_code) }}"
           class="hover:text-[#2282ff] transition-colors">
            Detail Transaksi
        </a>
        <i class="ti ti-chevron-right text-[#cbd5e1]"></i>
        <span class="text-[#0f172a] font-semibold">Edit Data Peserta</span>
    </nav>

    {{-- ==================== HEADER CARD ==================== --}}
    <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_2px_14px_-2px_rgba(15,23,42,0.05)] overflow-hidden mb-5">
        <div class="p-5 sm:p-6">

            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div>
                    <div class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wide text-[#2282ff] mb-2">
                        <i class="ti ti-edit"></i> Edit Data Peserta
                    </div>
                    <h1 class="text-lg sm:text-xl font-extrabold text-[#0f172a] m-0 leading-snug">
                        {{ $transaction->event->title }}
                    </h1>
                    <div class="flex items-center gap-3 mt-2 text-xs text-[#64748b]">
                        <span class="inline-flex items-center gap-1">
                            <i class="ti ti-ticket"></i>
                            {{ $transaction->ticket->ticket_name }}
                        </span>
                        <span class="text-[#cbd5e1]">•</span>
                        <span class="inline-flex items-center gap-1">
                            <i class="ti ti-users"></i>
                            {{ $transaction->quantity }} Peserta
                        </span>
                    </div>
                </div>

                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wide bg-[#dcfce7] text-[#166534]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#16a34a]"></span>
                    {{ $transaction->status }}
                </span>
            </div>

            {{-- Info: session akan expire dalam 30 menit --}}
            <div class="mt-4 p-3 rounded-lg bg-[#fffbeb] border border-[#fde68a] flex items-start gap-2 text-xs text-[#92400e]">
                <i class="ti ti-clock-hour-4 mt-0.5 shrink-0"></i>
                <span>
                    Sesi edit Anda berlaku selama <strong>30 menit</strong> sejak verifikasi.
                    Setelah itu Anda perlu verifikasi ulang melalui fitur <em>Check Registration</em>.
                </span>
            </div>

        </div>
    </div>

    {{-- ==================== FORM ==================== --}}
    <form id="edit-participants-form"
          method="POST"
          action="{{ route('transaction.update-participants', $transaction->transaction_code) }}"
          enctype="multipart/form-data"
          @submit.prevent="submit()">

        @csrf
        @method('PATCH')

        @foreach($transaction->participants as $index => $participant)

            <div class="participant-edit-card bg-white border border-[#e2e8f0] rounded-2xl shadow-[0_2px_14px_-2px_rgba(15,23,42,0.05)] mb-5">
                <div class="p-5 sm:p-6">

                    {{-- Header Peserta --}}
                    <div class="flex items-center justify-between pb-4 mb-5 border-b border-[#f1f5f9]">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center font-bold text-sm shrink-0">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <h3 class="text-sm font-extrabold text-[#0f172a] m-0">
                                    Peserta {{ $index + 1 }}
                                </h3>
                                <p class="text-xs text-[#64748b] mt-0.5 m-0">
                                    Kode Tiket:
                                    <span class="font-mono font-bold text-[#2282ff]">{{ $participant->ticket_code }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Fields --}}
                    @foreach($participant->forms as $formRow)
                        @include('transaction.edit-participant-field', [
                            'form'   => $formRow->form,
                            'row'    => $formRow,
                            'index'  => $index,
                        ])
                    @endforeach

                </div>
            </div>

        @endforeach

        {{-- ==================== SUBMIT BAR (STICKY) ==================== --}}
        <div class="sticky bottom-0 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-4 bg-white/95 backdrop-blur border-t border-[#e2e8f0] z-30">
            <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">

                <div class="text-xs text-[#64748b] hidden sm:block">
                    Pastikan semua data sudah benar sebelum menyimpan.
                </div>

                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                    <a href="{{ route('transaction.detail', $transaction->transaction_code) }}"
                       class="order-2 sm:order-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border-[1.5px] border-[#e2e8f0] bg-white text-sm font-bold text-[#0f172a] hover:bg-[#f1f5f9] transition-colors">
                        <i class="ti ti-x"></i>
                        <span>Batal</span>
                    </a>

                    <button type="submit"
                            :disabled="saving"
                            class="order-1 sm:order-2 inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-br from-[#2282ff] to-[#02559b] text-sm font-bold text-white shadow-[0_4px_14px_rgba(34,130,255,0.35)] hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(34,130,255,0.45)] transition-all disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none">
                        <template x-if="!saving">
                            <span class="inline-flex items-center gap-2">
                                <i class="ti ti-device-floppy"></i>
                                <span>Simpan Perubahan</span>
                            </span>
                        </template>
                        <template x-if="saving">
                            <span class="inline-flex items-center gap-2">
                                <i class="ti ti-loader-2 animate-spin"></i>
                                <span>Menyimpan...</span>
                            </span>
                        </template>
                    </button>
                </div>

            </div>
        </div>

    </form>

</div>
</section>

@endsection


@push('scripts')
<script>
document.addEventListener('alpine:init', () => {

    Alpine.data('editParticipantsPage', () => ({
        saving: false,

        init() {
            // Init intl-tel-input untuk semua phone input
            if (typeof initEditPhoneInputs === 'function') {
                initEditPhoneInputs();
            }
        },

        async submit() {
            if (this.saving) return;
            this.saving = true;

            try {
                const form = document.getElementById('edit-participants-form');
                const formData = new FormData(form);

                // ─── PASTIKAN semua file ke-append manual ───
                document.querySelectorAll('.edit-file-input').forEach(input => {
                    if (input.files && input.files.length > 0) {
                        // Hapus dulu (kalau ada duplikat dari FormData(form))
                        formData.delete(input.name);
                        // Append ulang
                        formData.append(input.name, input.files[0]);
                    }
                });

                formData.set('_method', 'PATCH');

                // Debug: cek file sudah masuk
                console.log('Files in FormData:', 
                    [...formData.entries()].filter(([k]) => k.startsWith('files'))
                );

                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData,
                });

                const data = await res.json();

                if (!res.ok || !data.success) {
                    throw new Error(data.message || 'Gagal menyimpan perubahan.');
                }

                if (typeof toast !== 'undefined') {
                    toast.success('Berhasil!', {
                        description: data.message || 'Data peserta berhasil diperbarui.',
                    });
                }

                setTimeout(() => {
                    window.location.href = '{{ route('transaction.detail', $transaction->transaction_code) }}';
                }, 1200);

            } catch (err) {
                console.error(err);
                if (typeof toast !== 'undefined') {
                    toast.error('Gagal', {
                        description: err.message || 'Terjadi kesalahan. Coba lagi.',
                    });
                } else {
                    alert(err.message);
                }
                this.saving = false;
            }
        },
    }));

});


/* ---------- Init intl-tel-input untuk phone input ---------- */
function initEditPhoneInputs() {
    document.querySelectorAll('.edit-phone-input').forEach(function (el) {
        if (el._iti) return;
        if (typeof window.intlTelInput !== 'function') return;

        const initialValue = el.dataset.initialValue || '';

        const iti = window.intlTelInput(el, {
            initialCountry: 'id',
            countryOrder: ['id'],
            separateDialCode: false,
            strictMode: false,
            loadUtils: () => import('https://cdn.jsdelivr.net/npm/intl-tel-input@29.2.3/dist/js/utils.js'),
            classNames: {
                container: '!w-full',
                input: '!w-full !h-11 !pl-12 !pr-3.5 !border-[1.5px] !border-[#cbd5e1] !rounded-lg !bg-white !text-sm !text-[#0f172a] !outline-none focus:!border-[#2282ff]',
            },
        });

        if (initialValue) {
            try { iti.setNumber(initialValue); } catch (e) {}
        }

        el._iti = iti;
    });
}


/* ---------- Preview & info file (replace) ---------- */
document.addEventListener('change', function (e) {
    const input = e.target;
    if (!input.matches('.edit-file-input')) return;

    const file = input.files[0];
    if (!file) return;

    const wrapper = input.closest('.edit-upload-wrapper');
    if (!wrapper) return;

    const filenameEl = wrapper.querySelector('.edit-upload-filename');
    const sizeEl = wrapper.querySelector('.edit-upload-size');
    const previewEl = wrapper.querySelector('.edit-upload-preview');

    // Format size
    const size = file.size < 1024 * 1024
        ? (file.size / 1024).toFixed(1) + ' KB'
        : (file.size / 1024 / 1024).toFixed(2) + ' MB';

    if (filenameEl) filenameEl.textContent = file.name;
    if (sizeEl) sizeEl.textContent = size;

    // Preview untuk image
    if (previewEl && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (ev) => {
            previewEl.src = ev.target.result;
            previewEl.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});


/* ---------- Session timeout warning ---------- */
document.addEventListener('DOMContentLoaded', function () {
    // Kasih warning 5 menit sebelum session habis (25 menit setelah page load)
    setTimeout(() => {
        if (typeof toast !== 'undefined') {
            toast.info('Sesi edit akan berakhir', {
                description: 'Anda memiliki 5 menit tersisa sebelum verifikasi ulang diperlukan.',
                duration: 8000,
            });
        }
    }, 25 * 60 * 1000);
});
</script>
@endpush