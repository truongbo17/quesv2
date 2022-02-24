<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listRole = Role::with('users')->with('permissions')->get();
        return view('admin.role.index', compact('listRole'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissionsParent = Permission::where('parent_id', 0)->get();
        return view('admin.role.add', compact('permissionsParent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
        ]);

        $role->permissions()->attach($request->permission_id);

        return redirect(url()->previous() . '#success')->with('success', 'Add new role success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $permissionsParent = Permission::where('parent_id', 0)->get();
        $role = Role::where('id', $request->id)->get();

        return view('admin.role.edit', compact('role', 'permissionsParent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
        ]);

        $role->permissions()->sync($request->permission_id);

        return redirect(url()->previous() . '#success')->with('success', 'Update role success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $checkRole = Role::whereId($request->id)
            ->withCount('users')
            ->withCount('permissions')
            ->get();

        if ($checkRole[0]->users_count > 0 || $checkRole[0]->permissions_count) {
            return redirect(url()->previous() . '#error')->with('error', 'Please delete all user and permission of this role !');
        }

        Role::find($request->id)->delete();

        return redirect(url()->previous() . '#success')->with('success', 'Delete role success !');
    }
}
