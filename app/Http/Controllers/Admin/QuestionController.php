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
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class QuestionController extends Controller
{
    private $disk = 'public';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $listQuestions = Question::with('user')
            ->with('category')
            ->orderBy('created_at', 'DESC')
            ->get();

        if ($request->ajax()) {
            return Datatables::of($listQuestions)
                ->addIndexColumn()
                ->addColumn('category', function ($question) {
                    return $question->category->name;
                })
                ->addColumn('name', function ($question) {
                    return $question->user->name;
                })
                ->addColumn('status', function ($question) {
                    $status = '';
                    if ($question->status == 1)
                        $status = '<span class="badge bg-success text-white">Active</span>';
                    elseif ($question->status == 0)
                        $status = '<span class="badge bg-warning text-white">Pending</span>';
                    else
                        $status = '<span class="badge bg-danger text-white">Deleted</span>';

                    return $status;
                })
                ->editColumn('action', function ($question) {
                    $action = '<a href="' . route('admin.question.show', $question->id) . '"
                                            class="btn btn-sm btn-success btn-circle"><i class="fas fa-eye"></i></a>
                                        <a href="' . route('admin.question.edit', $question->id) . '"
                                            class="btn btn-sm btn-warning btn-circle"><i class="fas fa-edit"></i></a>';
                    if ($question->status != 2) {
                        $action .= "<a onclick='deleteQuestion($question->id)'
                        href='#' data-toggle='modal' data-target='#deleteQuestion'
                        class='btn btn-sm btn-danger btn-circle'><i class='fas fa-trash'></i></a>";
                    }

                    return $action;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.question.index');
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

            // $pathImage = $request->file('imageQuestion')->store('public/files/1/imagesquestion');
            // $pathImage = str_replace('public/', '', $pathImage);

            $fileName = date('mdYHis') . uniqid() . "." . $request->file('imageQuestion')->getClientOriginalExtension();
            $pathImage = $request->file('imageQuestion')->storeAs('files/1/imagesquestion', $fileName, ['disk' => $this->disk]);

            $picture = json_encode([
                "disk" => $this->disk,
                "path" => $pathImage
            ]);

            $question = Question::create([
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'view' => 1,
                'status' => $request->status,
                // 'image' => $pathImage,
                'picture' => $picture,
                'slug' => $request->slug,
                'content' => $request->content,
            ]);

            if ($request->tag_id) {
                foreach ($request->tag_id as $tagId) {
                    $tag = Tag::find($tagId);
                    $tag->questions()->attach($question->id);
                }
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

                $fileName = date('mdYHis') . uniqid() . "." . $request->file('imageQuestion')->getClientOriginalExtension();
                $pathImage = $request->file('imageQuestion')->storeAs('files/1/imagesquestion', $fileName, ['disk' => $this->disk]);

                $picture = json_encode([
                    "disk" => $this->disk,
                    "path" => $pathImage
                ]);

                $question->picture = $picture;
            }
            $question->update([
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
