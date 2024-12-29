<?php

namespace App\Http\Controllers;

use App\Models\Import;
use App\Models\Permission;
use App\Models\User;
use \Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
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
            'password' => 'required|min:6',
            'permissions'=> 'nullable'
        ]);
        //Create user
        $user = User::create($data);
        //Attach permissions to user
        if($data['permissions']){
            $permissions = convertPermissionsToArray($data['permissions']);
            $user->permissions()->attach($permissions);
        }

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
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed'
            ],
            'permissions'=> 'nullable',
            'passwordChange' => 'nullable'
        ]);

        //Handle permissions
        $user->permissions()->detach();
        if($data['permissions']){
            $permissions = convertPermissionsToArray($data['permissions']);
            $user->permissions()->attach($permissions);
        }

        // Update user details
        $user->update([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'] && isset($data['passwordChange']) ? Hash::make($data['password']) : $user->password,
        ]);

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
