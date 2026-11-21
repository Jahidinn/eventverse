<div class="dash-kpi {{ $tone ?? '' }}">
    <div class="dash-kpi-top">
        <span class="dash-kpi-label">{{ $label }}</span>
        <span class="dash-kpi-icon {{ $tone ?? '' }}">
            <i class="ti {{ $icon }}"></i>
        </span>
    </div>
    <div class="dash-kpi-value {{ ($money ?? false) ? 'is-money' : '' }}">{{ $value }}</div>
    @if (!empty($sub))
        <div class="dash-kpi-sub">{{ $sub }}</div>
    @endif
</div>
