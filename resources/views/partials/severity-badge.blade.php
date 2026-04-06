@php
    $sev = $severity instanceof \App\Enums\Severity
        ? $severity
        : \App\Enums\Severity::from($severity);

    $bgMap = [
        'danger'    => 'bg-danger text-white',
        'warning'   => 'bg-soft-warning text-warning',
        'primary'   => 'bg-soft-primary text-primary',
        'info'      => 'bg-soft-info text-info',
        'success' => 'bg-soft-success text-success',
    ];

    $class = $bgMap[$sev->color()] ?? 'bg-soft-secondary text-secondary';
@endphp
<span class="badge {{ $class }}">{{ $sev->label() }}</span>