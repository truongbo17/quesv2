<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $listCategories = Category::with('user')
            ->withCount('questions')
            ->orderBy('created_at', 'DESC')
            ->get();

        if ($request->ajax()) {
            return Datatables::of($listCategories)
                ->addIndexColumn()
                ->addColumn('user', function ($category) {
                    return $category->user->name;
                })
                ->addColumn('total_question', function ($category) {
                    return $category->questions_count;
                })
                ->addColumn('status', function ($category) {
                    $status = '';
                    if ($category->status == 1)
                        $status = '<span class="badge bg-success text-white">Active</span>';
                    else
                        $status = '<span class="badge bg-danger text-white">Deleted</span>';

                    return $status;
                })
                ->editColumn('action', function ($category) {
                    $action = '<a href="' . route('admin.category.show', $category->id) . '"
                                                class="btn btn-sm btn-success btn-circle"><i class="fas fa-eye"></i></a>
                                            <a href="' . route('admin.category.edit', $category->id) . '"
                                                class="btn btn-sm btn-warning btn-circle"><i class="fas fa-edit"></i></a>';
                    if ($category->status != 2) {
                        $action .= "<a onclick='deleteCategory($category->id)'
                            href='#' data-toggle='modal' data-target='#deleteCategory'
                            class='btn btn-sm btn-danger btn-circle'><i class='fas fa-trash'></i></a>";
                    }

                    return $action;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listUser = User::where('status', 1)->get();

        return view('admin.category.add', compact('listUser'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        try {
            if (!$request->slug) {
                $request->slug = \Str::slug($request->name);
            }

            $question = Category::create([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'status' => $request->status,
                'slug' => $request->slug,
            ]);

            return redirect(url()->previous() . '#success')->with('success', 'Add new category success !');
        } catch (\Exception $e) {
            return redirect(url()->previous() . '#error')->with('error', $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $category = Category::with('user')
            ->withCount('questions')
            ->where('id', $request->id)
            ->get();

        return view('admin.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $category = Category::with('user')
            ->withCount('questions')
            ->where('id', $request->id)
            ->get();

        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $category = Category::findOrFail($id);

        if (!$category) {
            return false;
        }

        if (!$request->slug) {
            $request->slug = \Str::slug($request->name);
        }

        try {
            Category::whereId($request->id)
                ->update([
                    'name' => $request->name,
                    'status' => $request->status,
                    'slug' => $request->slug,
                ]);
            return redirect(url()->previous() . '#success')->with('success', 'Edit Category success !');
        } catch (\Exception $e) {
            return redirect(url()->previous() . '#error')->with('error', $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $checkQuestionOfCategory = Category::whereId($request->id)->withCount('questions')->get();

        if ($checkQuestionOfCategory[0]->questions_count > 0) {
            return redirect(url()->previous() . '#error')->with('error', 'Please delete all question of that category !');
        }

        Category::whereId($request->id)->update(['status' => 2]);
        return redirect(url()->previous() . '#success')->with('success', 'Delete category success !');
    }
}
