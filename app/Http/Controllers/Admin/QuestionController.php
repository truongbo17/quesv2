<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminAddQuestion;
use App\Http\Requests\AdminEditQuestion;
use App\Models\Category;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listQuestions = Question::with('user')
            ->with('category')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('admin.question.index', compact('listQuestions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listCategory = Category::where('status', 1)->get();
        $listUser = User::where('status', 1)->get();
        $listTag = Tag::where('status', 1)->get();

        return view('admin.question.add', compact('listCategory', 'listUser', 'listTag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminAddQuestion $request)
    {
        try {
            if (!$request->slug) {
                $request->slug = \Str::slug($request->title);
            }

            $pathImage = $request->file('imageQuestion')->store('public/files/1/imagesquestion');
            $pathImage = str_replace('public/', '', $pathImage);

            $question = Question::create([
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'view' => 1,
                'status' => $request->status,
                'image' => $pathImage,
                'slug' => $request->slug,
                'content' => $request->content,
            ]);

            foreach ($request->tag_id as $tagId) {
                $tag = Tag::find($tagId);
                $tag->questions()->attach($question->id);
            }

            return redirect(url()->previous() . '#success')->with('success', 'Add new question success !');
        } catch (\Exception $e) {
            return redirect(url()->previous() . '#error')->with('error', $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $question = Question::with('user')
            ->with('category')
            ->with('tags')
            ->where('id', $request->id)
            ->get();

        return view('admin.question.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $question = Question::with('user')
            ->with('category')
            ->with('tags')
            ->orderBy('updated_at', 'DESC')
            ->where('id', $request->id)
            ->get();

        $listCategory = Category::where('status', 1)->get();
        $listTag = Tag::where('status', 1)->get();

        return view('admin.question.edit', compact('question', 'listCategory', 'listTag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update($id, AdminEditQuestion $request)
    {
        try {
            $question = Question::findOrFail($id);

            if (!$question) {
                return false;
            }

            if (!$request->slug) {
                $request->slug = \Str::slug($request->title);
            }

            if ($request->has('imageQuestion')) {
                $pathImage = $request->file('imageQuestion')->store('public/files/1/imagesquestion');
                $pathImage = str_replace('public/', '', $pathImage);

                $question->image = $pathImage;
            }
            Question::whereId($request->id)
                ->update([
                    'title' => $request->title,
                    'category_id' => $request->category_id,
                    'status' => $request->status,
                    'slug' => $request->slug,
                    'content' => $request->content,
                ]);

            $question->tags()->sync($request->tag_id);

            return redirect(url()->previous() . '#success')->with('success', 'Edit question success !');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect(url()->previous() . '#error')->with('error', $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Question::whereId($request->id)->update(['status' => 2]);

        return redirect(url()->previous() . '#success')->with('success', 'Delete question success !');
    }
}
