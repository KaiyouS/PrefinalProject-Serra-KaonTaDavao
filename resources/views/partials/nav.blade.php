<header class="bg-white border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="font-bold text-slate-900">Kaon Ta! Davao – Serra's Food Guide</a>
        <nav class="flex gap-4 text-sm">
            <a href="{{ route('home') }}" class="hover:underline">Home</a>
            <a href="{{ route('eateries.index') }}" class="hover:underline">Eateries</a>
            <a href="{{ route('districts.index') }}" class="hover:underline">Districts</a>
            <a href="{{ route('eateries.create') }}" class="hover:underline">Add Eatery</a>
        </nav>
    </div>
</header>
