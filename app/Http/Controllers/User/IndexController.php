<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddQuestion;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Category;
use App\Models\LikeQuestion;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $listcategory = Category::where('status', 1)->get();
        $historyLikes = LikeQuestion::with('questions')
            ->where('user_id', Auth::user()->id)->select('question_id')->get();

        $listQuestions = Question::with('user')
            ->with('category')
            ->withCount('likes')
            ->withCount('comments')
            ->orderBy('created_at', 'DESC')
            ->where('status', 1)
            ->paginate(5);

        $content = '';

        // return $listQuestions;

        if ($request->ajax()) {
            foreach ($listQuestions as $question) {
                $content .= '<div class="files-table">
                <div>
                <div class="post">
                    <div class="head">
                        <div class="name_profile">
                            <img src="' . $question->user->avatar . '" class="avatar" />
                            <div class="q">
                                <h4>' . $question->user->name . '</h4>
                                <p>' . $question->created_at . '</p>
                            </div>
                        </div>
                        <div class="icon">
                            <img src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/64/000000/external-more-multimedia-kiranshastry-lineal-color-kiranshastry.png"
                                class="svg" />
                        </div>
                    </div>
                    <div class="body">
                        <span>' . $question->title . '</span>
                        <p>
                            ' . $question->content . '
                        </p>
                        <img style="width:100%" class="post_image" src="' . $question->image . '" />
                        <div class="btm_icon">
                            <div class="left_icon">';

                $checkLike = false;
                foreach ($historyLikes as $historyLike) {
                    if ($historyLike->question_id == $question->id) {
                        $checkLike = true;
                    }
                }

                if ($checkLike) {
                    $content .= '<img class="svg margin" id="question_' . $question->id . '" onclick="likeQuestion(' . $question->id . ')" src="https://img.icons8.com/plasticine/100/000000/like--v1.png" />';
                } else {
                    $content .= '<img class="svg margin" id="question_' . $question->id . '" onclick="likeQuestion(' . $question->id . ')" src="https://img.icons8.com/material-outlined/24/000000/filled-like.png" />';
                }

                $content .= '<span id="likeCount_' . $question->id . '">' . $question->likes_count . '</span>
                                <img src="https://img.icons8.com/material-rounded/24/000000/comments--v1.png"
                                    class="svg margin" />
                                ' . $question->comments_count . '
                                <img src="https://img.icons8.com/ios-glyphs/30/000000/share--v1.png" class="svg margin" />
                            </div>
                            <div class="right_icon">
                                ' . $question->category->name . '
                            </div>
                        </div>
                        <form class="form">
                            <div class="flex">
                                <img src="' . Auth::user()->avatar . '" class="ico" />
                                <input type="text" placeholder="Enter Text..." class="in" />
                            </div>
                            <img src="https://img.icons8.com/fluency/48/000000/filled-sent.png" class="svg margin" />
                        </form>
                    </div>
                </div>
            </div>
            </div>
            <br/>';
            }

            return $content;
        }

        return view('home.index', compact('listcategory'));
    }

    public function store(AddQuestion $request)
    {
        try {
            $name = $request->file('imageQuestion')->getClientOriginalName();

            $request->file('imageQuestion')->move(public_path('assets/img'), $name);

            $name = '/assets/img/' . $name;

            $question = Question::create([
                'user_id' => Auth::user()->id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'view' => 1,
                'status' => 0,
                'image' => $name,
            ]);

            return redirect(url()->previous() . '#success')->with('success', 'Add new question success , Please wait for approval !');
        } catch (\Exception $e) {
            return redirect(url()->previous() . '#error')->with('error', $e);
        }
    }
}
