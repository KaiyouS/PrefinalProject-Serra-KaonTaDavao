@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Eateries</h1>

    <form method="GET" action="{{ route('eateries.index') }}" class="bg-white border border-slate-200 rounded-xl p-4 mb-4 grid grid-cols-1 md:grid-cols-3 gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name or specialty" class="border border-slate-300 rounded px-3 py-2 md:col-span-3">
        <select name="district" class="border border-slate-300 rounded px-3 py-2">
            <option value="">All districts</option>
            @foreach ($districts as $d)
                <option value="{{ $d->id }}" @selected(request('district') == $d->id)>{{ $d->name }}</option>
            @endforeach
        </select>
        <select name="feature" class="border border-slate-300 rounded px-3 py-2">
            <option value="">All features</option>
            @foreach ($features as $f)
                <option value="{{ $f->name }}" @selected(request('feature') === $f->name)>{{ $f->name }}</option>
            @endforeach
        </select>
        <div class="flex gap-2">
            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded">Filter</button>
            <a href="{{ route('eateries.index') }}" class="border border-slate-300 px-4 py-2 rounded">Reset</a>
        </div>
    </form>

    @if ($eateries->isEmpty())
        <p class="text-slate-600">No eateries match your filters.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($eateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>
        <div class="mt-6">
            {{ $eateries->links() }}
        </div>
    @endif
@endsection
