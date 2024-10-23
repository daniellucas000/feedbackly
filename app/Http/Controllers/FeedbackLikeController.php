<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\FeedbackLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FeedbackLikeController extends Controller
{
    public function store($id)
    {
        $id_user = Auth::id();

        $feedback = Feedback::where('id', $id)->first();

        if (empty($feedback)) {
            return Inertia::render('Feedback/Error', [
                'error' => 'Feedback não encontrado'
            ]);
        }

        $feedbackLike = FeedbackLike::create([
            'feedback_id' => $id,
            'user_id' => $id_user,
        ]);

        return Inertia::location(route('dashboard'), $feedbackLike);
    }
}
