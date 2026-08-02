@if($customForms)

@foreach($customForms as $customForm)

@php
    $validation = $customForm->field_validation ?? [];
@endphp

<div class="checkout-field">

    <label class="checkout-label">

        {{ $customForm->field_label }}

        @if($customForm->field_required)
            <span class="text-danger">*</span>
        @endif

    </label>

    @switch($customForm->field_type)

    {{-- ========================================================= --}}
    {{-- PHONE --}}
    {{-- ========================================================= --}}

    @case('phone')

        <input
            type="tel"
            class="checkout-input phone-input"
            id="customForm_{{ $index }}_{{ $customForm->id }}"
            name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
            data-field-key="{{ $customForm->field_key ?? '' }}"
            placeholder="821xxxxxxxx"
            inputmode="numeric"
            autocomplete="tel"
            value="+62"
            {{ $customForm->field_required ? 'required' : '' }}>

        <input
            type="hidden"
            name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]"
            value="{{ $customForm->field_key }}">

    @break


    {{-- ========================================================= --}}
    {{-- TEXT --}}
    {{-- ========================================================= --}}

    @case('text')

        <input
            type="text"
            id="customForm_{{ $index }}_{{ $customForm->id }}"
            name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
            data-field-key="{{ $customForm->field_key ?? '' }}"
            class="checkout-input"
            placeholder="{{ $customForm->field_placeholder }}"
            minlength="{{ $validation['min_length'] ?? '' }}"
            maxlength="{{ $validation['max_length'] ?? '' }}"
            {{ $customForm->field_required ? 'required' : '' }}>

        <input
            type="hidden"
            name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]"
            value="{{ $customForm->field_key }}">

    @break


    {{-- ========================================================= --}}
    {{-- EMAIL --}}
    {{-- ========================================================= --}}

    @case('email')

        <input
            type="email"
            id="customForm_{{ $index }}_{{ $customForm->id }}"
            name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
            data-field-key="{{ $customForm->field_key ?? '' }}"
            class="checkout-input"
            placeholder="{{ $customForm->field_placeholder }}"
            minlength="{{ $validation['min_length'] ?? '' }}"
            maxlength="{{ $validation['max_length'] ?? '' }}"
            {{ $customForm->field_required ? 'required' : '' }}>

        <input
            type="hidden"
            name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]"
            value="{{ $customForm->field_key }}">

    @break


    {{-- ========================================================= --}}
    {{-- NUMBER --}}
    {{-- ========================================================= --}}

    @case('number')

        <input
            type="number"
            id="customForm_{{ $index }}_{{ $customForm->id }}"
            name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
            class="checkout-input"
            placeholder="{{ $customForm->field_placeholder }}"
            min="{{ $validation['min'] ?? '' }}"
            max="{{ $validation['max'] ?? '' }}"
            {{ $customForm->field_required ? 'required' : '' }}>

        <input
            type="hidden"
            name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]"
            value="{{ $customForm->field_key }}">

    @break


    {{-- ========================================================= --}}
    {{-- DATE --}}
    {{-- ========================================================= --}}

    @case('date')

        <input
            type="text"
            id="customForm_{{ $index }}_{{ $customForm->id }}"
            name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
            class="checkout-input date-picker"
            placeholder="{{ $customForm->field_placeholder }}"
            autocomplete="off"
            {{ $customForm->field_required ? 'required' : '' }}>

        <input
            type="hidden"
            name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]"
            value="{{ $customForm->field_key }}">

    @break


    {{-- ========================================================= --}}
    {{-- TIME --}}
    {{-- ========================================================= --}}

    @case('time')

        <input
            type="text"
            id="customForm_{{ $index }}_{{ $customForm->id }}"
            name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
            class="checkout-input time-picker"
            placeholder="{{ $customForm->field_placeholder }}"
            autocomplete="off"
            {{ $customForm->field_required ? 'required' : '' }}>

        <input
            type="hidden"
            name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]"
            value="{{ $customForm->field_key }}">

    @break

    {{-- ========================================================= --}}
    {{-- TEXTAREA --}}
    {{-- ========================================================= --}}

    @case('textarea')

        <textarea
            id="customForm_{{ $index }}_{{ $customForm->id }}"
            name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
            class="checkout-input checkout-textarea"
            data-field-key="{{ $customForm->field_key ?? '' }}"
            placeholder="{{ $customForm->field_placeholder }}"
            minlength="{{ $validation['min_length'] ?? '' }}"
            maxlength="{{ $validation['max_length'] ?? '' }}"
            {{ $customForm->field_required ? 'required' : '' }}></textarea>

        <input
            type="hidden"
            name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]"
            value="{{ $customForm->field_key }}">

    @break


    {{-- ========================================================= --}}
    {{-- SELECT --}}
    {{-- ========================================================= --}}

    @case('select')

        <select
            id="customForm_{{ $index }}_{{ $customForm->id }}"
            name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
            class="ev-select"
            data-field-key="{{ $customForm->field_key ?? '' }}"
            {{ $customForm->field_required ? 'required' : '' }}>

            <option value="">
                Pilih... 
            </option>

            @foreach($customForm->field_options ?? [] as $option)

                <option value="{{ $option }}">
                    {{ $option }}
                </option>

            @endforeach

        </select>

        <input
            type="hidden"
            name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]"
            value="{{ $customForm->field_key }}">

    @break


    {{-- ========================================================= --}}
    {{-- RADIO --}}
    {{-- ========================================================= --}}

    @case('radio')

        <div class="option-group">

            @foreach($customForm->field_options ?? [] as $option)

                <label class="option-card">

                    <input
                        type="radio"
                        id="customForm_{{ $index }}_{{ $customForm->id }}_{{ \Illuminate\Support\Str::slug($option) }}"
                        name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
                        value="{{ $option }}"
                        data-field-key="{{ $customForm->field_key ?? '' }}"
                        {{ $customForm->field_required ? 'required' : '' }}>

                    <span>
                        {{ $option }}
                    </span>

                </label>

            @endforeach

            <input
                type="hidden"
                name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]"
                value="{{ $customForm->field_key }}">

        </div>

    @break


    {{-- ========================================================= --}}
    {{-- CHECKBOX --}}
    {{-- ========================================================= --}}

    @case('checkbox')

        <div class="option-group">

            @foreach($customForm->field_options ?? [] as $option)

                <label class="option-card">

                    <input
                        type="checkbox"
                        id="customForm_{{ $index }}_{{ $customForm->id }}_{{ \Illuminate\Support\Str::slug($option) }}"
                        name="participants[{{ $index }}][customForm][{{ $customForm->id }}][]"
                        value="{{ $option }}"
                        data-field-key="{{ $customForm->field_key ?? '' }}">

                    <span>
                        {{ $option }}
                    </span>

                </label>

            @endforeach

            <input
                type="hidden"
                name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]"
                value="{{ $customForm->field_key }}">

        </div>

    @break

        {{-- ========================================================= --}}
    {{-- FILE --}}
    {{-- ========================================================= --}}

    @case('file')

        <label class="upload-box">

            <input
                type="file"
                hidden
                id="customForm_{{ $index }}_{{ $customForm->id }}"
                name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
                @if(!empty($validation['extensions']))
                    accept="{{ collect($validation['extensions'])->map(fn($e)=>'.'.$e)->implode(',') }}"
                @endif
                {{ $customForm->field_required ? 'required' : '' }}>

            <input
                type="hidden"
                name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]"
                value="{{ $customForm->field_key }}">

            <div class="upload-icon">
                <i class="ti ti-file-upload"></i>
            </div>

            <div class="upload-content">

                <strong>Upload File</strong>

                <small>Belum ada file dipilih</small>

            </div>

        </label>

    @break


    {{-- ========================================================= --}}
    {{-- IMAGE --}}
    {{-- ========================================================= --}}

    @case('image')

        <label class="upload-box image-upload">

            @php
                $extensions = $customForm->field_validation['extensions'] ?? [];

                $accept = collect($extensions)
                    ->map(fn ($ext) => '.' . strtolower($ext))
                    ->implode(',');
            @endphp

            <input
                type="file"
                hidden
                id="customForm_{{ $index }}_{{ $customForm->id }}"
                name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
                accept="{{ $accept }}"
            >

            <input
                type="hidden"
                name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]"
                value="{{ $customForm->field_key }}">

            <div class="upload-icon">
                <i class="ti ti-photo"></i>
            </div>

            <div class="upload-content">

                <strong>Upload Gambar</strong>

                <small>Belum ada file dipilih</small>

            </div>

        </label>

        <img
            class="image-preview"
            style="display:none;">

    @break


    @endswitch


    @if($customForm->field_help)

        <small class="checkout-help">

            {{ $customForm->field_help }}

        </small>

    @endif

</div>

@endforeach

@endif