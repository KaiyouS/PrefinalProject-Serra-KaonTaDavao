@php
    $selectedFeatures = old('features', $eatery ? $eatery->features->pluck('id')->toArray() : []);
@endphp

@if ($errors->any())
    <div class="bg-rose-50 border border-rose-300 text-rose-800 rounded px-4 py-2 mb-4">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-3">
    <div>
        <label class="block text-sm font-medium mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name', $eatery->name ?? '') }}" class="border border-slate-300 rounded px-3 py-2 w-full">
        @error('name') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">District</label>
        <select name="district_id" class="border border-slate-300 rounded px-3 py-2 w-full">
            <option value="">— Choose a district —</option>
            @foreach ($districts as $d)
                <option value="{{ $d->id }}" @selected(old('district_id', $eatery->district_id ?? null) == $d->id)>{{ $d->name }}</option>
            @endforeach
        </select>
        @error('district_id') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Address</label>
        <input type="text" name="address" value="{{ old('address', $eatery->address ?? '') }}" class="border border-slate-300 rounded px-3 py-2 w-full">
        @error('address') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Price range</label>
        <select name="price_range" class="border border-slate-300 rounded px-3 py-2 w-full">
            @foreach (['budget' => 'Budget (P)', 'mid' => 'Mid (PP)', 'splurge' => 'Splurge (PPP)'] as $val => $label)
                <option value="{{ $val }}" @selected(old('price_range', $eatery->price_range ?? null) === $val)>{{ $label }}</option>
            @endforeach
        </select>
        @error('price_range') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Specialty</label>
        <input type="text" name="specialty" value="{{ old('specialty', $eatery->specialty ?? '') }}" class="border border-slate-300 rounded px-3 py-2 w-full">
        @error('specialty') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_open" value="1" @checked(old('is_open', $eatery->is_open ?? true))>
            <span class="text-sm">Open for business</span>
        </label>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Features</label>
        <div class="grid grid-cols-2 gap-1">
            @foreach ($features as $feature)
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="features[]" value="{{ $feature->id }}" @checked(in_array($feature->id, $selectedFeatures))>
                    {{ $feature->name }}
                </label>
            @endforeach
        </div>
        @error('features') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Permit number</label>
        <input type="text" name="permit_no" value="{{ old('permit_no', $eatery?->permit?->permit_no ?? '') }}" class="border border-slate-300 rounded px-3 py-2 w-full">
        @error('permit_no') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Permit expiry date</label>
        <input type="date" name="expires_on" value="{{ old('expires_on', $eatery?->permit?->expires_on?->format('Y-m-d') ?? '') }}" class="border border-slate-300 rounded px-3 py-2 w-full">
        @error('expires_on') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>
