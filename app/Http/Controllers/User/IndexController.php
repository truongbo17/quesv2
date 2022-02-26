<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddQuestion;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Category;
use App\Models\Tag;
use App\Models\LikeQuestion;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    private $disk = 'public';

    public function index(Request $request)
    {
        $listcategory = Category::where('status', 1)->get();
        $listtag = Tag::where('status', 1)->get();

        $historyLikes = LikeQuestion::with('questions')
            ->where('user_id', Auth::user()->id)->select('question_id')->get();

        $listQuestions = Question::with('user')
            ->with('category')
            ->with('tags')
            ->withCount('likes')
            ->withCount('comments')
            ->orderBy('created_at', 'DESC')
            ->where('status', 1)
            ->paginate(5);

        $content = '';

        // return $listQuestions;

        if ($request->ajax()) {
            foreach ($listQuestions as $question) {
                $tags = '';
                foreach ($question->tags as $tagName) {
                    $tags .= ' #' . $tagName->name;
                }

                $content .= '<div id="question' . $question->id . '" class="files-table">

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
                        <p style="color:blue">
                            ' . $tags . '
                        </p>
                        <img style="width:100%" class="post_image" src="storage/' . json_decode($question->picture)->path . '" />
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
                                <img id="questionCmt_' . $question->id . '" onclick="commentQuestion(' . $question->id . ')" src="https://img.icons8.com/material-rounded/24/000000/comments--v1.png"
                                    class="svg margin" />
                                ' . $question->comments_count . '
                                <img src="https://img.icons8.com/ios-glyphs/30/000000/share--v1.png" class="svg margin" />
                            </div>
                            <div class="right_icon">
                                ' . $question->category->name . '
                            </div>
                        </div>
                        <form class="form" action="' . route("user.comment.send") . '" method="POST">
                        ' . csrf_field() . '
                            <div class="flex">
                                <img src="' . Auth::user()->avatar . '" class="ico" />
                                <input type="text" name="comment" style="width:100%" placeholder="Enter Text..." class="in" />
                                <input name="question_id" value="' . $question->id . '" hidden />
                            </div>
                            <button><img src="https://img.icons8.com/fluency/48/000000/filled-sent.png" class="svg margin" /></button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            </div>
            <br/>
            ';
            }

            return $content;
        }

        return view('home.index', compact('listcategory', 'listtag'));
    }

    public function store(AddQuestion $request)
    {
        try {
            // $pathImage = $request->file('imageQuestion')->store('public/files/1/imagesquestion');
            // $pathImage = str_replace('public/', '', $pathImage);

            $fileName = date('mdYHis') . uniqid() . "." . $request->file('imageQuestion')->getClientOriginalExtension();
            $pathImage = $request->file('imageQuestion')->storeAs('files/1/imagesquestion', $fileName, ['disk' => $this->disk]);

            $picture = json_encode([
                "disk" => $this->disk,
                "path" => $pathImage
            ]);

            $slug = \Str::slug($request->title);

            $question = Question::create([
                'user_id' => Auth::user()->id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'content' => $request->title,
                'view' => 1,
                'status' => 0,
                'picture' => $picture,
                'slug' => $slug,
            ]);

            if ($request->has('tag_id')) {
                foreach ($request->tag_id as $tagId) {
                    $tag = Tag::find($tagId);
                    $tag->questions()->attach($question->id);
                }
            }

            return redirect(url()->previous() . '#success')->with('success', 'Add new question success , Please wait for approval !');
        } catch (\Exception $e) {
            return redirect(url()->previous() . '#error')->with('error', $e);
        }
    }
}
