@php
    $stat = $status instanceof \App\Enums\ReportingStat
        ? $status
        : \App\Enums\ReportingStat::from($status);
@endphp
<span class="badge {{ $stat->color() }}">{{ $stat->label() }}</span>