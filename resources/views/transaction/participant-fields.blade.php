@if($customForms)

@foreach($customForms as $customForm)
@php
    $validation = $customForm->field_validation ?? [];
@endphp

<div class="checkout-field mb-4">
    <label class="checkout-label block text-[13px] font-bold text-[#334155] mb-1.5">
        {{ $customForm->field_label }}
        @if($customForm->field_required)
            <span class="text-rose-500">*</span>
        @endif
    </label>

    @switch($customForm->field_type)

        @case('phone')
            <input type="tel"
                   id="customForm_{{ $index }}_{{ $customForm->id }}"
                   name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
                   data-field-key="{{ $customForm->field_key ?? '' }}"
                   class="checkout-input phone-input w-full h-11 px-3.5 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12"
                   placeholder="821xxxxxxxx" inputmode="numeric" autocomplete="tel" value="+62"
                   {{ $customForm->field_required ? 'required' : '' }}>
            <input type="hidden" name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]" value="{{ $customForm->field_key }}">
        @break

        @case('text')
            <input type="text"
                   id="customForm_{{ $index }}_{{ $customForm->id }}"
                   name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
                   data-field-key="{{ $customForm->field_key ?? '' }}"
                   class="checkout-input w-full h-11 px-3.5 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12"
                   placeholder="{{ $customForm->field_placeholder }}"
                   minlength="{{ $validation['min_length'] ?? '' }}"
                   maxlength="{{ $validation['max_length'] ?? '' }}"
                   {{ $customForm->field_required ? 'required' : '' }}>
            <input type="hidden" name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]" value="{{ $customForm->field_key }}">
        @break

        @case('email')
            <input type="email"
                   id="customForm_{{ $index }}_{{ $customForm->id }}"
                   name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
                   data-field-key="{{ $customForm->field_key ?? '' }}"
                   class="checkout-input w-full h-11 px-3.5 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12"
                   placeholder="{{ $customForm->field_placeholder }}"
                   minlength="{{ $validation['min_length'] ?? '' }}"
                   maxlength="{{ $validation['max_length'] ?? '' }}"
                   {{ $customForm->field_required ? 'required' : '' }}>
            <input type="hidden" name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]" value="{{ $customForm->field_key }}">
        @break

        @case('number')
            <input type="number"
                   id="customForm_{{ $index }}_{{ $customForm->id }}"
                   name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
                   class="checkout-input w-full h-11 px-3.5 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12"
                   placeholder="{{ $customForm->field_placeholder }}"
                   min="{{ $validation['min'] ?? '' }}"
                   max="{{ $validation['max'] ?? '' }}"
                   {{ $customForm->field_required ? 'required' : '' }}>
            <input type="hidden" name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]" value="{{ $customForm->field_key }}">
        @break

        @case('date')
            <input type="text"
                   id="customForm_{{ $index }}_{{ $customForm->id }}"
                   name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
                   class="checkout-input date-picker w-full h-11 px-3.5 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12"
                   placeholder="{{ $customForm->field_placeholder }}"
                   autocomplete="off"
                   {{ $customForm->field_required ? 'required' : '' }}>
            <input type="hidden" name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]" value="{{ $customForm->field_key }}">
        @break

        @case('time')
            <input type="text"
                   id="customForm_{{ $index }}_{{ $customForm->id }}"
                   name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
                   class="checkout-input time-picker w-full h-11 px-3.5 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12"
                   placeholder="{{ $customForm->field_placeholder }}"
                   autocomplete="off"
                   {{ $customForm->field_required ? 'required' : '' }}>
            <input type="hidden" name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]" value="{{ $customForm->field_key }}">
        @break

        @case('textarea')
            <textarea id="customForm_{{ $index }}_{{ $customForm->id }}"
                      name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
                      data-field-key="{{ $customForm->field_key ?? '' }}"
                      class="checkout-input checkout-textarea w-full min-h-[120px] px-3.5 py-3 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12 resize-y leading-relaxed"
                      placeholder="{{ $customForm->field_placeholder }}"
                      minlength="{{ $validation['min_length'] ?? '' }}"
                      maxlength="{{ $validation['max_length'] ?? '' }}"
                      {{ $customForm->field_required ? 'required' : '' }}></textarea>
            <input type="hidden" name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]" value="{{ $customForm->field_key }}">
        @break

        @case('select')
            <select id="customForm_{{ $index }}_{{ $customForm->id }}"
                    name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
                    class="ev-select w-full h-11 px-3.5 pr-9 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12 appearance-none"
                    style="background-image:url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2216%22 height=%2216%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%2364748b%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>'); background-repeat:no-repeat; background-position:right 14px center;"
                    data-field-key="{{ $customForm->field_key ?? '' }}"
                    {{ $customForm->field_required ? 'required' : '' }}>
                <option value="">Pilih...</option>
                @foreach($customForm->field_options ?? [] as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
            <input type="hidden" name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]" value="{{ $customForm->field_key }}">
        @break

        @case('radio')
            <div class="option-group grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                @foreach($customForm->field_options ?? [] as $option)
                    <label class="option-card relative flex items-center gap-3 px-4 py-3.5 border-[1.5px] border-[#e2e8f0] rounded-xl bg-white cursor-pointer transition-all hover:border-[#2282ff] hover:bg-[#ebf3ff]/40 has-[:checked]:border-[#2282ff] has-[:checked]:bg-[#ebf3ff] has-[:checked]:ring-[3px] has-[:checked]:ring-[#2282ff]/12">
                        <input type="radio"
                               id="customForm_{{ $index }}_{{ $customForm->id }}_{{ \Illuminate\Support\Str::slug($option) }}"
                               name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
                               value="{{ $option }}"
                               data-field-key="{{ $customForm->field_key ?? '' }}"
                               class="w-4 h-4 accent-[#2282ff] m-0 shrink-0"
                               {{ $customForm->field_required ? 'required' : '' }}>
                        <span class="text-[13px] font-semibold text-[#0f172a]">{{ $option }}</span>
                    </label>
                @endforeach
                <input type="hidden" name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]" value="{{ $customForm->field_key }}">
            </div>
        @break

        @case('checkbox')
            <div class="option-group grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                @foreach($customForm->field_options ?? [] as $option)
                    <label class="option-card relative flex items-center gap-3 px-4 py-3.5 border-[1.5px] border-[#e2e8f0] rounded-xl bg-white cursor-pointer transition-all hover:border-[#2282ff] hover:bg-[#ebf3ff]/40 has-[:checked]:border-[#2282ff] has-[:checked]:bg-[#ebf3ff] has-[:checked]:ring-[3px] has-[:checked]:ring-[#2282ff]/12">
                        <input type="checkbox"
                               id="customForm_{{ $index }}_{{ $customForm->id }}_{{ \Illuminate\Support\Str::slug($option) }}"
                               name="participants[{{ $index }}][customForm][{{ $customForm->id }}][]"
                               value="{{ $option }}"
                               data-field-key="{{ $customForm->field_key ?? '' }}"
                               class="w-4 h-4 accent-[#2282ff] m-0 shrink-0">
                        <span class="text-[13px] font-semibold text-[#0f172a]">{{ $option }}</span>
                    </label>
                @endforeach
                <input type="hidden" name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]" value="{{ $customForm->field_key }}">
            </div>
        @break

        @case('file')
            <label class="upload-box flex items-center gap-3.5 p-3.5 border-[1.5px] border-dashed border-[#c2dcff] rounded-lg bg-[#ebf3ff] cursor-pointer w-full transition-all hover:border-[#2282ff] hover:bg-[#e6f0ff]">
                <input type="file" hidden
                       id="customForm_{{ $index }}_{{ $customForm->id }}"
                       name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
                       @if(!empty($validation['extensions']))
                           accept="{{ collect($validation['extensions'])->map(fn($e)=>'.'.$e)->implode(',') }}"
                       @endif
                       {{ $customForm->field_required ? 'required' : '' }}>

                <input type="hidden" name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]" value="{{ $customForm->field_key }}">

                <div class="w-10 h-10 rounded-lg bg-white text-[#2282ff] flex items-center justify-center text-xl shrink-0 shadow-[0_2px_4px_rgba(34,130,255,0.08)]">
                    <i class="ti ti-file-upload"></i>
                </div>
                <div class="flex flex-col gap-0.5 overflow-hidden">
                    <strong class="block text-[13px] text-[#0f172a] font-bold truncate">Upload File</strong>
                    <small class="block text-[11.5px] text-[#64748b]">Belum ada file dipilih</small>
                </div>
            </label>
        @break

        @case('image')
            @php
                $extensions = $customForm->field_validation['extensions'] ?? [];
                $accept = collect($extensions)->map(fn ($ext) => '.' . strtolower($ext))->implode(',');
            @endphp

            <label class="upload-box image-upload flex items-center gap-3.5 p-3.5 border-[1.5px] border-dashed border-[#c2dcff] rounded-lg bg-[#ebf3ff] cursor-pointer w-full transition-all hover:border-[#2282ff] hover:bg-[#e6f0ff]">
                <input type="file" hidden
                       id="customForm_{{ $index }}_{{ $customForm->id }}"
                       name="participants[{{ $index }}][customForm][{{ $customForm->id }}]"
                       accept="{{ $accept }}">

                <input type="hidden" name="participants[{{ $index }}][fieldKey][{{ $customForm->id }}]" value="{{ $customForm->field_key }}">

                <div class="w-10 h-10 rounded-lg bg-white text-[#2282ff] flex items-center justify-center text-xl shrink-0 shadow-[0_2px_4px_rgba(34,130,255,0.08)]">
                    <i class="ti ti-photo"></i>
                </div>
                <div class="flex flex-col gap-0.5 overflow-hidden">
                    <strong class="block text-[13px] text-[#0f172a] font-bold truncate">Upload Gambar</strong>
                    <small class="block text-[11.5px] text-[#64748b]">Belum ada file dipilih</small>
                </div>
            </label>

            <img class="image-preview block w-full max-w-[220px] h-40 object-cover mt-3 rounded-lg border border-[#e2e8f0] bg-[#f8fafc] shadow-[0_2px_8px_rgba(15,23,42,0.05)]" style="display:none;">
        @break

    @endswitch

    @if($customForm->field_help)
        <small class="block text-xs text-[#64748b] mt-1.5">{{ $customForm->field_help }}</small>
    @endif
</div>

@endforeach
@endif