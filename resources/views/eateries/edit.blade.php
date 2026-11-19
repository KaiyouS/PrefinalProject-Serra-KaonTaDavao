@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit {{ $eatery->name }}</h1>

    <form method="POST" action="{{ route('eateries.update', $eatery) }}" class="bg-white border border-slate-200 rounded-xl p-4 space-y-3">
        @csrf
        @method('PUT')
        @include('eateries._form', ['eatery' => $eatery])
        <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded mt-3">Save</button>
    </form>
@endsection
