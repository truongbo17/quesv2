<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LikeQuestion;
use App\Models\Question;

class LikeQuestionController extends Controller
{
    public function historyLike(Request $request)
    {
        return LikeQuestion::with('questions')
            ->where('user_id', \Auth::user()->id)->select('question_id')->get();
    }

    public function like(Request $request)
    {
        $checkLike = LikeQuestion::where('user_id', \Auth::user()->id)->where('question_id', $request->question_id)->get();

        if (!$checkLike->isEmpty()) {
            //đã like thì bỏ like
            LikeQuestion::where('user_id', \Auth::user()->id)->where('question_id', $request->question_id)->delete();

            //sau khi xóa trả về total like
            $question = Question::withCount('likes')->where('id', $request->question_id)->get();

            return $question;
        } else {

            //chưa like thì like
            LikeQuestion::create([
                'user_id' => \Auth::user()->id,
                'question_id' => $request->question_id
            ]);

            //trả về count
            $question = Question::withCount('likes')->where('id', $request->question_id)->get();

            return $question;
        }
    }
}
