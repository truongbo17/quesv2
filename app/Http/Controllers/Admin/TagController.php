<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $listTags = Tag::withCount('questions')
            ->orderBy('created_at', 'DESC')
            ->get();

        if ($request->ajax()) {
            return Datatables::of($listTags)
                ->addIndexColumn()
                ->addColumn('total_question', function ($tag) {
                    return $tag->questions_count;
                })
                ->addColumn('status', function ($tag) {
                    $status = '';
                    if ($tag->status == 1)
                        $status = '<span class="badge bg-success text-white">Active</span>';
                    elseif ($tag->status == 0)
                        $status = '<span class="badge bg-warning text-white">Pending</span>';
                    else
                        $status = '<span class="badge bg-danger text-white">Deleted</span>';

                    return $status;
                })
                ->editColumn('action', function ($tag) {
                    $action = '<a href="' . route('admin.tag.edit', $tag->id) . '"
                                                    class="btn btn-sm btn-warning btn-circle"><i class="fas fa-edit"></i></a>';
                    if ($tag->status != 2) {
                        $action .= "<a onclick='deleteTag($tag->id)'
                                href='#' data-toggle='modal' data-target='#deleteTag'
                                class='btn btn-sm btn-danger btn-circle'><i class='fas fa-trash'></i></a>";
                    }

                    return $action;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.tag.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tag.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->slug) {
            $request->slug = \Str::slug($request->name);
        }

        $question = Tag::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
        ]);

        return redirect(url()->previous() . '#success')->with('success', 'Add new tag success !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $tag = Tag::withCount('questions')->where('id', $request->id)->get();

        return view('admin.tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $tag = Tag::findOrFail($id);

        if (!$tag) {
            return false;
        }

        if (!$request->slug) {
            $request->slug = \Str::slug($request->name);
        }

        Tag::whereId($request->id)
            ->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status,
            ]);

        return redirect(url()->previous() . '#success')->with('success', 'Edit tag success !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $checkQuestionOfTag = Tag::whereId($request->id)->withCount('questions')->get();
        if ($checkQuestionOfTag[0]->questions_count > 0) {
            return redirect(url()->previous() . '#error')->with('error', 'Please delete all question of this tag !');
        }

        Tag::whereId($request->id)->update(['status' => 2]);
        return redirect(url()->previous() . '#success')->with('success', 'Delete tag success !');
    }
}
