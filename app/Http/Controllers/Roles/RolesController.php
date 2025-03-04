<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RolesController extends Controller
{
    public function index()
    {
        return view('Roles.index');
    }

    public function list()
    {
        $data = Role::get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $edit = '<a href="' . route('roles.edit', $data->id) . '" class="btn btn-primary"><i class="fe fe-edit-2"></i></a>';

                return $edit;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Permissions updated successfully!');
    }
}
