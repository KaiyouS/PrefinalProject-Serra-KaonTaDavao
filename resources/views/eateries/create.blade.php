@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Add Eatery</h1>

    <form method="POST" action="{{ route('eateries.store') }}" class="bg-white border border-slate-200 rounded-xl p-4 space-y-3">
        @csrf
        @include('eateries._form', ['eatery' => null])
        <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded mt-3">Save</button>
    </form>
@endsection
