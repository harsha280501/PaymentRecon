<div>

    @php
    $_from = Carbon\Carbon::parse($from);
    $_to = Carbon\Carbon::parse($to);
    @endphp

    @if ($from !== null && $_to->diffInDays($_from) <= 28 ) <span style="font-weight: 900 !important">({{ $_from->format('d-m-Y') }} - {{ $_to->format('d-m-Y') }} )</span>
        @endif
</div>
