<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $listPermission = Permission::with('roles')->with('permissionParent')->get();

        if ($request->ajax()) {
            return Datatables::of($listPermission)
                ->addIndexColumn()
                ->addColumn('roles', function ($permission) {
                    $roleName = '';
                    foreach ($permission->roles as $role) {
                        $roleName .= $role->name . ',';
                    }
                    return $roleName;
                })
                ->addColumn('parent', function ($permission) {
                    if (isset($permission->permissionParent->name)) {
                        return $permission->permissionParent->name;
                    }
                })
                ->editColumn('action', function ($permission) {
                    $action = '<a href="' . route('admin.permission.edit', $permission->id) . '"
                                                        class="btn btn-sm btn-warning btn-circle"><i class="fas fa-edit"></i></a>';
                    if ($permission->status != 2) {
                        $action .= "<a onclick='deletePermission($permission->id)'
                                    href='#' data-toggle='modal' data-target='#deletePermission'
                                    class='btn btn-sm btn-danger btn-circle'><i class='fas fa-trash'></i></a>";
                    }

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.permission.index');
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
        Permission::whereId($request->id)
            ->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'parent_id' => $request->parent_id,
                'key_code' => $request->key_code,
            ]);

        return redirect(url()->previous() . '#success')->with('success', 'Edit permission success !');
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
            ->withCount('permissionsChild')
            ->get();

        if ($checkRole[0]->roles_count > 0 || $checkRole[0]->permissions_child_count > 0) {
            return redirect(url()->previous() . '#error')->with('error', 'Please delete all role of this permission !');
        }

        Permission::find($request->id)->delete();

        return redirect(url()->previous() . '#success')->with('success', 'Delete permission success !');
    }
}
