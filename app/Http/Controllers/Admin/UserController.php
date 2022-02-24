<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listUsers = User::with('roles')
            ->withCount('questions')
            ->withCount('categories')
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('admin.user.index', compact('listUsers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listRole = Role::all();
        return view('admin.user.add', compact('listRole'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $pathImage = $request->file('avatar')->store('public/files/1/avatar');
            $pathImage = str_replace('public/', '', $pathImage);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'status' => $request->status,
                'password' => \Hash::make($request->password),
                'avatar' => $pathImage,
            ]);

            $user->roles()->attach($request->role_id);

            return redirect(url()->previous() . '#success')->with('success', 'Add new user success');
        } catch (\Exception $e) {
            return redirect(url()->previous() . '#error')->with('error', $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $listRole = Role::all();

        $user = User::with('roles')->where('id', $request->id)->get();
        return view('admin.user.edit', compact('user', 'listRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            if (!$user) {
                return false;
            }

            if ($request->has('avatar')) {
                $pathImage = $request->file('avatar')->store('public/files/avatar/imagesquestion');
                $pathImage = str_replace('public/', '', $pathImage);

                $user->image = $pathImage;
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'status' => $request->status,
            ]);

            $user->roles()->sync($request->role_id);

            return redirect(url()->previous() . '#success')->with('success', 'Edit user success !');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect(url()->previous() . '#error')->with('error', $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $checkUser = User::whereId($request->id)
            ->withCount('questions')
            ->withCount('categories')
            ->get();

        if ($checkUser[0]->questions_count > 0 || $checkUser[0]->categories_count) {
            return redirect(url()->previous() . '#error')->with('error', 'Please delete all question and category of that category !');
        }

        User::whereId($request->id)->update(['status' => 2]);

        return redirect(url()->previous() . '#success')->with('success', 'Delete user success !');
    }
}
