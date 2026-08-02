@php
    $icons = [
        'text' => 'fa-font',
        'textarea' => 'fa-align-left',
        'email' => 'fa-envelope',
        'phone' => 'fa-phone',
        'number' => 'fa-hashtag',
        'select' => 'fa-list',
        'radio' => 'fa-circle-dot',
        'checkbox' => 'fa-square-check',
        'file' => 'fa-paperclip',
        'image' => 'fa-image',
    ];

    $icon = $icons[$form->field_type] ?? 'fa-circle';
@endphp

<div
    class="ev-form-card"
    id="fieldCard{{ $form->id }}"
    data-id="{{ $form->id }}"
    data-field-label="{{ $form->field_label }}"
    data-field-type="{{ $form->field_type }}"
    data-description="{{ $form->field_help }}"
    data-placeholder="{{ $form->field_placeholder }}"
    data-required="{{ $form->field_required ? 1 : 0 }}"
    data-options='@json($form->field_options)'
    data-validation='@json($form->field_validation)'
>

    <div class="ev-form-head">

        <div class="ev-form-info">

            <div class="ev-form-icon">

                <i class="fa-solid {{ $icon }}"></i>

            </div>

            <div class="ev-form-content">

                <h4>

                    {{ $form->field_label }}

                </h4>

                <p>

                    {{ ucfirst($form->field_type) }}

                    @if($form->field_options)

                        • {{ count($form->field_options) }} Options

                    @endif

                </p>

            </div>

        </div>

        @unless($form->is_system)

        <div class="ev-card-menu-wrapper">

            <button
                type="button"
                class="ev-card-menu">

                <i class="fa-solid fa-ellipsis"></i>

            </button>

            <div class="ev-card-dropdown">

                <button
                    type="button"
                    class="editField"
                    data-id="{{ $form->id }}">

                    <i class="fa-solid fa-pen"></i>

                    Edit

                </button>

                <button
                    type="button"
                    class="deleteField danger"
                    data-id="{{ $form->id }}">

                    <i class="fa-solid fa-trash"></i>

                    Delete

                </button>

            </div>

        </div>

        @endunless

    </div>
    <div class="ev-divider"></div>

    <div class="ev-form-footer">

        <div class="ev-tags">

            @if($form->is_system)

                <span class="tag system">

                    {{-- <i class="fa-solid fa-shield-halved"></i> --}}

                    System

                </span>

            @else

                <span class="tag custom">

                    {{-- <i class="fa-solid fa-wand-magic-sparkles"></i> --}}

                    Custom

                </span>

            @endif

            @if($form->field_required)

                <span class="tag required">

                    {{-- <i class="fa-solid fa-circle-check"></i> --}}

                    Required

                </span>

            @else

                <span class="tag optional">

                    {{-- <i class="fa-regular fa-circle"></i> --}}

                    Optional

                </span>

            @endif

        </div>

    </div>

</div>