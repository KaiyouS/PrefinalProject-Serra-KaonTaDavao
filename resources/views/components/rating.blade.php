@props(['rating' => 0])
@php
    $filled = (int) round((float) $rating);
@endphp
<span class="text-amber-500" title="{{ number_format((float) $rating, 1) }} out of 5">@for ($i = 1; $i <= 5; $i++){{ $i <= $filled ? '★' : '☆' }}@endfor</span>
