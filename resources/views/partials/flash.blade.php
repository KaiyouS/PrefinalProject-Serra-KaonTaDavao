@if (session('success'))
    <div class="max-w-6xl mx-auto px-4 pt-4">
        <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    </div>
@endif
