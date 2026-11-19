<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEateryRequest;
use App\Http\Requests\UpdateEateryRequest;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EateryController extends Controller
{
    public function index(Request $request)
    {
        $query = Eatery::with('district', 'features')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderBy('name');

        if ($q = $request->input('q')) {
            $query->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                    ->orWhere('specialty', 'like', "%{$q}%");
            });
        }

        if ($districtId = $request->input('district')) {
            $query->where('district_id', $districtId);
        }

        if ($featureName = $request->input('feature')) {
            $query->whereHas('features', fn ($w) => $w->where('name', $featureName));
        }

        $eateries = $query->paginate(6)->withQueryString();
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.index', compact('eateries', 'districts', 'features'));
    }

    public function create()
    {
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.create', compact('districts', 'features'));
    }

    public function store(StoreEateryRequest $request)
    {
        $data = $request->validated();
        $permitData = [
            'permit_no' => $data['permit_no'],
            'expires_on' => $data['expires_on'],
        ];
        $featureIds = $data['features'];
        unset($data['permit_no'], $data['expires_on'], $data['features']);
        $data['slug'] = Str::slug($data['name']);

        $eatery = Eatery::create($data);
        $eatery->permit()->create($permitData);
        $eatery->features()->sync($featureIds);

        return redirect()
            ->route('eateries.show', $eatery)
            ->with('success', 'Eatery added.');
    }

    public function show(Eatery $eatery)
    {
        $eatery->load([
            'district',
            'features',
            'permit',
            'dishes',
            'reviews' => fn ($q) => $q->with('user')->latest(),
        ]);

        $users = User::orderBy('name')->get();

        return view('eateries.show', compact('eatery', 'users'));
    }

    public function edit(Eatery $eatery)
    {
        $eatery->load('permit', 'features');
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.edit', compact('eatery', 'districts', 'features'));
    }

    public function update(UpdateEateryRequest $request, Eatery $eatery)
    {
        $data = $request->validated();
        $permitData = [
            'permit_no' => $data['permit_no'],
            'expires_on' => $data['expires_on'],
        ];
        $featureIds = $data['features'];
        unset($data['permit_no'], $data['expires_on'], $data['features']);
        $data['slug'] = Str::slug($data['name']);

        $eatery->update($data);
        $eatery->permit()->updateOrCreate([], $permitData);
        $eatery->features()->sync($featureIds);

        return redirect()
            ->route('eateries.show', $eatery)
            ->with('success', 'Eatery updated.');
    }

    public function destroy(Eatery $eatery)
    {
        $eatery->reviews()->delete();
        $eatery->dishes()->delete();
        $eatery->permit()->delete();
        $eatery->features()->detach();
        $eatery->delete();

        return redirect()
            ->route('eateries.index')
            ->with('success', 'Eatery deleted.');
    }
}
