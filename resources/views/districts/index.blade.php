@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Districts</h1>
    <ul class="divide-y divide-slate-200 bg-white border border-slate-200 rounded-xl">
        @foreach ($districts as $district)
            <li class="px-4 py-3 flex items-center justify-between">
                <a href="{{ route('districts.show', $district) }}" class="font-medium hover:underline">{{ $district->name }}</a>
                <span class="text-sm text-slate-600">{{ $district->eateries_count }} {{ $district->eateries_count === 1 ? 'eatery' : 'eateries' }}</span>
            </li>
        @endforeach
    </ul>
@endsection
