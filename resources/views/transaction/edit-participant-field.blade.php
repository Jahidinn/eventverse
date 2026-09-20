@php
    $validation = $form->field_validation ?? [];
    $value = $row->form_value;
    $isFileType = in_array($form->field_type, ['file', 'image']);
    $uniqueId = 'edit_' . $row->id;
@endphp

<div class="mb-4">
    <label for="{{ $uniqueId }}" class="block text-[13px] font-bold text-[#334155] mb-1.5">
        {{ $form->field_label }}
        @if($form->field_required)
            <span class="text-rose-500">*</span>
        @endif
    </label>

    @switch($form->field_type)

        {{-- ==================== PHONE ==================== --}}
        @case('phone')
            <input
                type="tel"
                id="{{ $uniqueId }}"
                name="forms[{{ $row->id }}]"
                data-initial-value="{{ $value }}"
                value="{{ $value }}"
                placeholder="{{ $form->field_placeholder }}"
                inputmode="numeric"
                autocomplete="tel"
                class="edit-phone-input w-full h-11 px-3.5 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12"
                {{ $form->field_required ? 'required' : '' }}>
        @break

        {{-- ==================== TEXT ==================== --}}
        @case('text')
            <input
                type="text"
                id="{{ $uniqueId }}"
                name="forms[{{ $row->id }}]"
                value="{{ $value }}"
                placeholder="{{ $form->field_placeholder }}"
                minlength="{{ $validation['min_length'] ?? '' }}"
                maxlength="{{ $validation['max_length'] ?? '' }}"
                class="w-full h-11 px-3.5 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12"
                {{ $form->field_required ? 'required' : '' }}>
        @break

        {{-- ==================== EMAIL ==================== --}}
        @case('email')
            <input
                type="email"
                id="{{ $uniqueId }}"
                name="forms[{{ $row->id }}]"
                value="{{ $value }}"
                placeholder="{{ $form->field_placeholder }}"
                minlength="{{ $validation['min_length'] ?? '' }}"
                maxlength="{{ $validation['max_length'] ?? '' }}"
                class="w-full h-11 px-3.5 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12"
                {{ $form->field_required ? 'required' : '' }}>
        @break

        {{-- ==================== NUMBER ==================== --}}
        @case('number')
            <input
                type="number"
                id="{{ $uniqueId }}"
                name="forms[{{ $row->id }}]"
                value="{{ $value }}"
                placeholder="{{ $form->field_placeholder }}"
                min="{{ $validation['min'] ?? '' }}"
                max="{{ $validation['max'] ?? '' }}"
                class="w-full h-11 px-3.5 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12"
                {{ $form->field_required ? 'required' : '' }}>
        @break

        {{-- ==================== DATE ==================== --}}
        @case('date')
            <input
                type="text"
                id="{{ $uniqueId }}"
                name="forms[{{ $row->id }}]"
                value="{{ $value }}"
                placeholder="{{ $form->field_placeholder }}"
                autocomplete="off"
                class="edit-date-picker w-full h-11 px-3.5 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12"
                {{ $form->field_required ? 'required' : '' }}>
        @break

        {{-- ==================== TIME ==================== --}}
        @case('time')
            <input
                type="text"
                id="{{ $uniqueId }}"
                name="forms[{{ $row->id }}]"
                value="{{ $value }}"
                placeholder="{{ $form->field_placeholder }}"
                autocomplete="off"
                class="edit-time-picker w-full h-11 px-3.5 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12"
                {{ $form->field_required ? 'required' : '' }}>
        @break

        {{-- ==================== TEXTAREA ==================== --}}
        @case('textarea')
            <textarea
                id="{{ $uniqueId }}"
                name="forms[{{ $row->id }}]"
                placeholder="{{ $form->field_placeholder }}"
                minlength="{{ $validation['min_length'] ?? '' }}"
                maxlength="{{ $validation['max_length'] ?? '' }}"
                class="w-full min-h-[120px] px-3.5 py-3 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12 resize-y leading-relaxed"
                {{ $form->field_required ? 'required' : '' }}>{{ $value }}</textarea>
        @break

        {{-- ==================== SELECT ==================== --}}
        @case('select')
            <select
                id="{{ $uniqueId }}"
                name="forms[{{ $row->id }}]"
                class="w-full h-11 px-3.5 pr-9 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12 appearance-none"
                style="background-image:url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2216%22 height=%2216%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%2364748b%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>'); background-repeat:no-repeat; background-position:right 14px center;"
                {{ $form->field_required ? 'required' : '' }}>
                <option value="">Pilih...</option>
                @foreach($form->field_options ?? [] as $option)
                    <option value="{{ $option }}" {{ $value === $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
        @break

        {{-- ==================== RADIO ==================== --}}
        @case('radio')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                @foreach($form->field_options ?? [] as $option)
                    <label class="relative flex items-center gap-3 px-4 py-3.5 border-[1.5px] border-[#e2e8f0] rounded-xl bg-white cursor-pointer transition-all hover:border-[#2282ff] hover:bg-[#ebf3ff]/40 has-[:checked]:border-[#2282ff] has-[:checked]:bg-[#ebf3ff] has-[:checked]:ring-[3px] has-[:checked]:ring-[#2282ff]/12">
                        <input
                            type="radio"
                            name="forms[{{ $row->id }}]"
                            value="{{ $option }}"
                            {{ $value === $option ? 'checked' : '' }}
                            class="w-4 h-4 accent-[#2282ff] m-0 shrink-0"
                            {{ $form->field_required ? 'required' : '' }}>
                        <span class="text-[13px] font-semibold text-[#0f172a]">{{ $option }}</span>
                    </label>
                @endforeach
            </div>
        @break

        {{-- ==================== CHECKBOX ==================== --}}
        @case('checkbox')
            @php
                $checkedValues = is_array($value) ? $value : (json_decode($value, true) ?? []);
                if (!is_array($checkedValues)) $checkedValues = [$value];
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                @foreach($form->field_options ?? [] as $option)
                    <label class="relative flex items-center gap-3 px-4 py-3.5 border-[1.5px] border-[#e2e8f0] rounded-xl bg-white cursor-pointer transition-all hover:border-[#2282ff] hover:bg-[#ebf3ff]/40 has-[:checked]:border-[#2282ff] has-[:checked]:bg-[#ebf3ff] has-[:checked]:ring-[3px] has-[:checked]:ring-[#2282ff]/12">
                        <input
                            type="checkbox"
                            name="forms[{{ $row->id }}][]"
                            value="{{ $option }}"
                            {{ in_array($option, $checkedValues) ? 'checked' : '' }}
                            class="w-4 h-4 accent-[#2282ff] m-0 shrink-0">
                        <span class="text-[13px] font-semibold text-[#0f172a]">{{ $option }}</span>
                    </label>
                @endforeach
            </div>
        @break

        {{-- ==================== FILE / IMAGE (REPLACE) ==================== --}}
        @case('file')
        @case('image')
            @php
                $isImage = $form->field_type === 'image';
                $existingUrl = null;
                $existingName = null;
                
                if ($value) {
                    $fullPath = public_path('storage/' . $value);
                    $existingUrl = asset('storage/' . $value) 
                        . (file_exists($fullPath) ? '?v=' . filemtime($fullPath) : '');
                    $existingName = basename($value);
                }
            @endphp

            <div class="edit-upload-wrapper border border-[#e2e8f0] rounded-xl overflow-hidden bg-[#f8fafc]">

                {{-- Existing file display --}}
                @if($value)
                    <div class="p-3 sm:p-4 flex items-start gap-3 border-b border-[#e2e8f0] bg-white">

                        @if($isImage && $existingUrl)
                            <img src="{{ $existingUrl }}"
                                 alt="Current image"
                                 class="edit-upload-preview w-16 h-16 rounded-lg object-cover border border-[#e2e8f0] shrink-0">
                        @else
                            <div class="w-16 h-16 rounded-lg bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center shrink-0">
                                <i class="ti ti-file-text text-2xl"></i>
                            </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <div class="text-xs text-[#94a3b8] uppercase tracking-wide font-semibold mb-0.5">
                                File saat ini
                            </div>
                            <div class="edit-upload-filename text-[13px] font-bold text-[#0f172a] truncate">
                                {{ $existingName }}
                            </div>
                            <div class="edit-upload-size text-[11px] text-[#64748b] mt-0.5">
                                Upload file baru untuk mengganti
                            </div>
                        </div>

                    </div>
                @else
                    {{-- Belum ada file --}}
                    <div class="p-3 sm:p-4 flex items-center gap-3 border-b border-[#e2e8f0] bg-white">
                        <div class="w-16 h-16 rounded-lg bg-[#f1f5f9] text-[#94a3b8] flex items-center justify-center shrink-0">
                            <i class="ti ti-{{ $isImage ? 'photo' : 'file-text' }} text-2xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-xs text-[#94a3b8] uppercase tracking-wide font-semibold mb-0.5">
                                Belum ada file
                            </div>
                            <div class="edit-upload-filename text-[13px] font-bold text-[#64748b] truncate">
                                Belum ada file diupload
                            </div>
                        </div>
                    </div>
                @endif

                {{-- New upload area --}}
                <label for="{{ $uniqueId }}" class="block p-4 cursor-pointer hover:bg-[#ebf3ff]/40 transition-colors">
                    <input type="file"
                           hidden
                           id="{{ $uniqueId }}"
                           name="files[{{ $row->id }}]"
                           class="edit-file-input"
                           @if(!empty($validation['extensions']))
                               accept="{{ collect($validation['extensions'])->map(fn($e)=>'.'.$e)->implode(',') }}"
                           @endif>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#ebf3ff] text-[#2282ff] flex items-center justify-center shrink-0">
                            <i class="ti ti-upload"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-[13px] font-bold text-[#2282ff]">
                                {{ $value ? 'Ganti file' : 'Upload file' }}
                            </div>
                            <div class="text-[11px] text-[#64748b] mt-0.5">
                                @if(!empty($validation['extensions']))
                                    Format: {{ implode(', ', $validation['extensions']) }} &middot;
                                @endif
                                Maks 10 MB
                            </div>
                        </div>
                        <i class="ti ti-chevron-right text-[#94a3b8]"></i>
                    </div>
                </label>

            </div>
        @break

        @default
            <input
                type="text"
                id="{{ $uniqueId }}"
                name="forms[{{ $row->id }}]"
                value="{{ $value }}"
                class="w-full h-11 px-3.5 border-[1.5px] border-[#cbd5e1] rounded-lg bg-white text-sm text-[#0f172a] outline-none transition-all focus:border-[#2282ff] focus:ring-[3px] focus:ring-[#2282ff]/12">
    @endswitch

    @if($form->field_help)
        <small class="block text-xs text-[#64748b] mt-1.5">{{ $form->field_help }}</small>
    @endif
</div>