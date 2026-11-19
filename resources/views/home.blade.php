@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Kaon Ta! Davao</h1>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <div class="text-sm text-slate-500">Eateries</div>
            <div class="text-2xl font-bold">{{ $eateryCount }}</div>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <div class="text-sm text-slate-500">Districts</div>
            <div class="text-2xl font-bold">{{ $districtCount }}</div>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <div class="text-sm text-slate-500">Reviews</div>
            <div class="text-2xl font-bold">{{ $reviewCount }}</div>
        </div>
    </div>

    <h2 class="text-xl font-bold mb-3">Top Rated</h2>
    @if ($topRated->isEmpty())
        <p class="text-slate-600">No reviews yet.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($topRated as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>
    @endif
@endsection
