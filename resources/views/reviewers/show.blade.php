@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-2">{{ $user->name }}</h1>
    <p class="text-slate-600 mb-4">{{ $reviewCount }} {{ $reviewCount === 1 ? 'review' : 'reviews' }} written</p>

    @if ($user->reviews->isEmpty())
        <p class="text-slate-600">No reviews yet.</p>
    @else
        <ul class="space-y-3">
            @foreach ($user->reviews as $review)
                <li class="bg-white border border-slate-200 rounded-xl p-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('eateries.show', $review->eatery) }}" class="font-semibold hover:underline">{{ $review->eatery->name }}</a>
                        <x-rating :rating="$review->rating" />
                    </div>
                    <p class="mt-2 text-slate-800">{{ $review->body }}</p>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
