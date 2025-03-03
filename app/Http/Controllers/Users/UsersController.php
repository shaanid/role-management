<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersStoreRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{
    public function index()
    {
        return view('Users.list');
    }

    public function list()
    {
        $data = User::get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $view = '<a href="' . route('users.edit', $data->id) . '" class="btn btn-primary"><i class="fe fe-eye"></i></a>';
                $delete = '<a href="' . route('users.destroy', $data->id) . '" class="btn btn-primary"><i class="fe fe-trash-2"></i></a>';

                return $view . ' ' . $delete;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $roles = Role::get();

        return view('Users.create', compact('roles'));
    }

    public function store(UsersStoreRequest $request)
    {
        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'address' => $request->address,
                'phone' => $request->phone,
                'age' => $request->age,
            ]);
            $user->assignRole($request->role);

            return redirect()->back()->with('success', "Successfully creeated the user");
        } catch (\Throwable $th) {
            info($th);
            return redirect()->back()->with('error', "Something went wrong");
        }
    }

    public function edit(User $user)
    {
        $roles = Role::get();

        return view('Users.edit', compact('user', 'roles'));
    }

    public function update(UsersUpdateRequest $request, User $user)
    {
        try {
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone,
                'age' => $request->age,
            ]);
            if ($request->role) {
                $user->roles()->detach();
                $user->assignRole($request->role);
            }

            return redirect()->back()->with('success', "User updated successfully");
        } catch (\Throwable $th) {
            info($th);
            return redirect()->back()->with('error', "Something went wrong");
        }
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', "Successfully deleted");
    }
}
