<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $search = request()->input('q', "");
        $user = Auth::user();

        $likesCount = DB::table('feedback_likes')
            ->select('feedback_id', DB::raw('COUNT(*) as count'))
            ->groupBy('feedback_id');

        $feedbacks = Feedback::select(
            'feedbacks.id',
            'feedbacks.place',
            'feedbacks.rating',
            'feedbacks.categorie',
            'feedbacks.image',
            'feedbacks.comment',
            'feedbacks.city',
            'feedbacks.user_id',
            'feedbacks.created_at',
            'users.name as user_name',
            'users.profile',
            'likes.count as likes_count',
            DB::raw("IF(feedback_likes.feedback_id IS NOT NULL, true, false) as has_liked")
        )
            ->leftJoin('users', 'feedbacks.user_id', '=', 'users.id')
            ->leftJoinSub($likesCount, 'likes', function ($join) {
                $join->on('feedbacks.id', '=', 'likes.feedback_id');
            })
            ->leftJoin('feedback_likes', function ($join) use ($user) {
                $join->on('feedbacks.id', '=', 'feedback_likes.feedback_id')
                    ->where('feedback_likes.user_id', '=', $user->id);
            })
            ->when(!empty($search), fn($q) => $q->where("feedbacks.city", "like", "%$search%"))
            ->get();

        $d = [
            'feedbacks' => $feedbacks,
            'query' => $search,
        ];

        return Inertia::render('dashboard', $d);
    }
}
