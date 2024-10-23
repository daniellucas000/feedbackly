<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $search = request()->input('q', "");
        $user = Auth::user();

        $feedbacks = Feedback::select(
            'feedbacks.id',
            'feedbacks.place',
            'feedbacks.rating',
            'feedbacks.categorie',
            'feedbacks.image',
            'feedbacks.comment',
            'feedbacks.city',
            'feedbacks.user_id',
            'users.name as user_name',
            'users.profile'
        )
            ->when(!empty($user), fn($q) => $q->where("feedbacks.city", "like", "%$search%"))
            ->leftJoin('users', 'feedbacks.user_id', '=', 'users.id')
            ->get();

        $d = [
            'feedbacks' => $feedbacks,
            'query' => $search,
        ];

        return Inertia::render('dashboard', $d);
    }
}
