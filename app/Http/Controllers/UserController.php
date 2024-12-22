<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use \Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('have-permission', ['user-management']);
        $users = User::with('permissions')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Gate::authorize('have-permission', ['user-management']);
        $permissions = Permission::pluck('name')->toArray();
        return view('users.create')->with('permissions', 'Available Permissions: ' .implode(', ', $permissions));
    }

    /**
     * @desc Store a newly created resource in storage.
     * @route POST /users
     */
    public function store(Request $request)
    {
        Gate::authorize('have-permission', ['user-management']);
        //Validation
        $data = $request->validate([
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required',
            'permissions'=> 'nullable'
        ]);
        //Create user
        $user = User::create($data);
        //Attach permissions to user
        $permissions = convertPermissionsToArray($data['permissions']);
        $user->permissions()->attach($permissions);
        //Redirect
        return redirect()->route('users.index')->with(['success' => 'User created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        Gate::authorize('have-permission', ['user-management']);
        $permissions = Permission::pluck('name')->toArray();
        return view('users.edit')->with(
            [
                'user' => $user,
                'permissions' => 'Available Permissions: ' . convertPermissionsToString($permissions)
            ]
        );
    }

    /**
     * @desc Update the user data.
     * @route PUT /users/{user}/edit
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize('have-permission', ['user-management']);
        $data = $request->validate([
            'permissions'=> 'nullable'
        ]);

        $permissions = convertPermissionsToArray($data['permissions']);
        $user->permissions()->detach();
        $user->permissions()->attach($permissions);
        return redirect()->route('users.index')->with(['success' => 'User updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}