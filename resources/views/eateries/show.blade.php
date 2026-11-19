@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <a href="{{ route('eateries.index') }}" class="text-sm text-slate-500 hover:underline">← Back to eateries</a>
    </div>

    <div class="flex items-start justify-between gap-4 mb-4">
        <div>
            <h1 class="text-2xl font-bold">{{ $eatery->name }}</h1>
            <div class="text-sm text-slate-600 mt-1">
                <a href="{{ route('districts.show', $eatery->district) }}" class="hover:underline">{{ $eatery->district->name }}</a>
                · {{ $eatery->address }}
                · {{ ['budget' => 'P', 'mid' => 'PP', 'splurge' => 'PPP'][$eatery->price_range] ?? $eatery->price_range }}
                @if ($eatery->specialty) · {{ $eatery->specialty }} @endif
                @if (! $eatery->is_open) <span class="ml-2 text-xs bg-rose-100 text-rose-700 px-2 py-0.5 rounded">Closed</span> @endif
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('eateries.edit', $eatery) }}" class="bg-slate-800 text-white px-3 py-1.5 rounded text-sm">Edit</a>
            <form method="POST" action="{{ route('eateries.destroy', $eatery) }}" onsubmit="return confirm('Delete this eatery?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-rose-600 text-white px-3 py-1.5 rounded text-sm">Delete</button>
            </form>
        </div>
    </div>

    @if ($eatery->features->isNotEmpty())
        <div class="flex flex-wrap gap-1 mb-4">
            @foreach ($eatery->features as $feature)
                <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}" class="text-xs bg-slate-100 hover:bg-slate-200 px-2 py-0.5 rounded">{{ $feature->name }}</a>
            @endforeach
        </div>
    @endif

    @if ($eatery->permit)
        <div class="bg-white border border-slate-200 rounded-xl p-4 mb-6">
            <div class="text-sm text-slate-500">Business Permit</div>
            <div class="font-mono">{{ $eatery->permit->permit_no }}</div>
            <div class="text-sm">Expires: {{ $eatery->permit->expires_on->format('Y-m-d') }}</div>
            @if ($eatery->permit->expires_on->isPast())
                <div class="text-rose-600 font-semibold">Permit expired</div>
            @endif
        </div>
    @endif

    <h2 class="text-xl font-bold mb-3">Dishes</h2>
    @if ($eatery->dishes->isEmpty())
        <p class="text-slate-600 mb-6">No dishes yet.</p>
    @else
        <ul class="divide-y divide-slate-200 bg-white border border-slate-200 rounded-xl mb-6">
            @foreach ($eatery->dishes as $dish)
                <li class="px-4 py-2 flex items-center justify-between">
                    <span>
                        {{ $dish->name }}
                        @if ($dish->is_bestseller)
                            <span class="ml-2 text-xs bg-amber-100 text-amber-800 px-2 py-0.5 rounded">Bestseller</span>
                        @endif
                    </span>
                    <span class="font-mono">P{{ number_format($dish->price, 2) }}</span>
                </li>
            @endforeach
        </ul>
    @endif

    <h2 class="text-xl font-bold mb-3">Reviews</h2>

    @if ($eatery->is_open)
        <form method="POST" action="{{ route('eateries.reviews.store', $eatery) }}" class="bg-white border border-slate-200 rounded-xl p-4 mb-6 space-y-3">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Reviewer</label>
                <select name="user_id" class="border border-slate-300 rounded px-3 py-2 w-full">
                    <option value="">— Choose a reviewer —</option>
                    @foreach ($users as $u)
                        <option value="{{ $u->id }}" @selected(old('user_id') == $u->id)>{{ $u->name }}</option>
                    @endforeach
                </select>
                @error('user_id') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Rating</label>
                <select name="rating" class="border border-slate-300 rounded px-3 py-2 w-full">
                    <option value="">— Choose rating —</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" @selected(old('rating') == $i)>{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
                @error('rating') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Review</label>
                <textarea name="body" rows="3" class="border border-slate-300 rounded px-3 py-2 w-full">{{ old('body') }}</textarea>
                @error('body') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded">Post Review</button>
        </form>
    @else
        <p class="bg-rose-50 border border-rose-200 text-rose-800 rounded px-4 py-2 mb-6">This eatery is closed. Reviews are paused.</p>
    @endif

    @if ($eatery->reviews->isEmpty())
        <p class="text-slate-600">No reviews yet.</p>
    @else
        <ul class="space-y-3">
            @foreach ($eatery->reviews as $review)
                <li class="bg-white border border-slate-200 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <a href="{{ route('reviewers.show', $review->user) }}" class="font-semibold hover:underline">{{ $review->user->name }}</a>
                            <x-rating :rating="$review->rating" />
                            <span class="text-sm text-slate-500">· {{ $review->created_at->format('Y-m-d') }}</span>
                        </div>
                        <form method="POST" action="{{ route('reviews.destroy', $review) }}" onsubmit="return confirm('Delete this review?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-rose-600 hover:underline">Delete</button>
                        </form>
                    </div>
                    <p class="mt-2 text-slate-800">{{ $review->body }}</p>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
