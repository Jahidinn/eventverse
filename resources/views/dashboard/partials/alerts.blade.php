@if (session('popup'))
    <div class="mb-4 flex gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900" role="status">
        <i class="ti ti-circle-check"></i>
        <div><strong>Berhasil.</strong> {{ session('popup') }}</div>
    </div>
@endif

@if (session('success'))
    <div class="mb-4 flex gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900" role="status">
        <i class="ti ti-circle-check"></i>
        <div><strong>Berhasil.</strong> {{ session('success') }}</div>
    </div>
@endif

@if (session('error'))
    <div class="mb-4 flex gap-3 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-900" role="alert">
        <i class="ti ti-alert-circle"></i>
        <div><strong>Perhatian.</strong> {{ session('error') }}</div>
    </div>
@endif

@if (isset($errors) && $errors->any())
    <div class="mb-4 flex gap-3 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-900" role="alert">
        <i class="ti ti-alert-circle"></i>
        <div>
            <strong>Periksa input.</strong>
            {{ $errors->first() }}
        </div>
    </div>
@endif
