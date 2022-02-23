<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CommentQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentQuestionController extends Controller
{
    public function historyComment(Request $request)
    {
        $listComments = CommentQuestion::with('user')->where('question_id', $request->question_id)->get();

        $content = '';

        if (count($listComments) < 1) {
            $content .= '<p>Chua co binh luan nao</p>';
        }

        foreach ($listComments as $listComment) {
            $content .= '
            <p><div class="head">
                <div class="name_profile"">
            <img src="' . $listComment->user->avatar . '" class="avatar">
                    <div class="q">
                        <h4>' . $listComment->user->name . '</h4>
                        <p style="margin-top:0px">' . $listComment->created_at . '</p>
                        <h6>' . $listComment->comment . '</h6>
                    </div>
                    <hr/>
                    </div>
                <div class="icon">
                <img src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/64/000000/external-more-multimedia-kiranshastry-lineal-color-kiranshastry.png" class="svg">
                </div>
            </div>
            </p>
            <br/>';
        }

        return $content;
    }

    public function sendComment(Request $request)
    {
        CommentQuestion::create([
            'question_id' => $request->question_id,
            'user_id' => Auth::user()->id,
            'comment' => $request->comment,
        ]);

        return redirect(url()->previous() . '#question' . $request->question_id);
    }
}
