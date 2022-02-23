<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listTags = Tag::withCount('questions')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('admin.tag.index', compact('listTags'));
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
