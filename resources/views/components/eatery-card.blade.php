@props(['eatery'])
@php
    $reviewCount = $eatery->reviews_count ?? $eatery->reviews->count();
    $avgRating = $eatery->reviews_avg_rating ?? ($reviewCount > 0 ? $eatery->reviews->avg('rating') : null);
    $priceMap = ['budget' => 'P', 'mid' => 'PP', 'splurge' => 'PPP'];
    $priceLabel = $priceMap[$eatery->price_range] ?? $eatery->price_range;
@endphp
<article class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex flex-col gap-2">
    <div class="flex items-start justify-between gap-2">
        <a href="{{ route('eateries.show', $eatery) }}" class="text-lg font-semibold hover:underline">{{ $eatery->name }}</a>
        @if (! $eatery->is_open)
            <span class="text-xs bg-rose-100 text-rose-700 px-2 py-0.5 rounded">Closed</span>
        @endif
    </div>
    <div class="text-sm text-slate-600 flex flex-wrap items-center gap-1">
        <a href="{{ route('districts.show', $eatery->district) }}" class="hover:underline">{{ $eatery->district->name }}</a>
        <span>·</span>
        <span class="font-mono">{{ $priceLabel }}</span>
        @if ($eatery->specialty)
            <span>·</span>
            <span>{{ $eatery->specialty }}</span>
        @endif
    </div>
    @if ($eatery->features->isNotEmpty())
        <div class="flex flex-wrap gap-1">
            @foreach ($eatery->features as $feature)
                <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}" class="text-xs bg-slate-100 hover:bg-slate-200 px-2 py-0.5 rounded">{{ $feature->name }}</a>
            @endforeach
        </div>
    @endif
    <div class="text-sm">
        @if ($reviewCount > 0)
            <x-rating :rating="$avgRating" />
            <span class="ml-1 font-semibold">{{ number_format($avgRating, 1) }}</span>
            <span class="text-slate-500">({{ $reviewCount }} {{ $reviewCount === 1 ? 'review' : 'reviews' }})</span>
        @else
            <span class="text-slate-500">No reviews yet.</span>
        @endif
    </div>
</article>
