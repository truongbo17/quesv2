<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listPermission = Permission::with('roles')->with('permissionParent')->get();

        return view('admin.permission.index', compact('listPermission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listPermission = Permission::all();
        return view('admin.permission.add', compact('listPermission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Permission::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'parent_id' => $request->parent_id,
            'key_code' => $request->key_code,
        ]);
        return redirect(url()->previous() . '#success')->with('success', 'Add new permission success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $listPermission = Permission::all();
        $permission = Permission::with('permissionParent')->where('id', $request->id)->get();

        return view('admin.permission.edit', compact('permission', 'listPermission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $checkRole = Permission::whereId($request->id)
            ->withCount('roles')
            ->get();

        if ($checkRole[0]->roles_count > 0) {
            return redirect(url()->previous() . '#error')->with('error', 'Please delete all role of this permission !');
        }

        Permission::find($request->id)->delete();

        return redirect(url()->previous() . '#success')->with('success', 'Delete permission success !');
    }
}
