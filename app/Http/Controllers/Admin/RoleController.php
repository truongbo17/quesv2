<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $listRole = Role::with('users')->with('permissions')->get();

        if ($request->ajax()) {
            return Datatables::of($listRole)
                ->addIndexColumn()
                ->addColumn('username', function ($role) {
                    $userName = '';
                    foreach ($role->users as $user) {
                        $userName .= $user->name . ',';
                    }
                    return $userName;
                })
                ->addColumn('permissions', function ($role) {
                    $permissionName = '';
                    foreach ($role->permissions as $permission) {
                        $permissionName .= $permission->name . ',';
                    }
                    return $permissionName;
                })
                ->editColumn('action', function ($role) {
                    $action = '<a href="' . route('admin.role.edit', $role->id) . '"
                                                class="btn btn-sm btn-warning btn-circle"><i class="fas fa-edit"></i></a>';
                    if ($role->status != 2) {
                        $action .= "<a onclick='deleteRole($role->id)'
                            href='#' data-toggle='modal' data-target='#deleteRole'
                            class='btn btn-sm btn-danger btn-circle'><i class='fas fa-trash'></i></a>";
                    }

                    return $action;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.role.index');
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
