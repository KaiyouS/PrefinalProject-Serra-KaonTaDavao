<?php

namespace App\Http\Controllers;

use App\Models\User;

class ReviewerController extends Controller
{
    public function show(User $user)
    {
        $user->load([
            'reviews' => fn ($q) => $q->with('eatery')->latest(),
        ]);

        $reviewCount = $user->reviews->count();

        return view('reviewers.show', compact('user', 'reviewCount'));
    }
}
