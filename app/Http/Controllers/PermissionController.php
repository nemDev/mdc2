<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PermissionController extends Controller
{

    //@desc Display all permissions
    //@route GET /permissions
    public function index():View
    {
        Gate::authorize('have-permission', ['user-management']);
        $permissions = Permission::paginate(10);
        return view('permissions.index')->with(['permissions' => $permissions]);
    }

    //@desc Store new permissions
    //@route POST /permissions
    public function store(Request $request):RedirectResponse
    {
        Gate::authorize('have-permission', ['user-management']);
        $data = $request->validate([
            'name' => 'required|unique:permissions'
        ]);

        Permission::create($data);

        return redirect()->route('permissions.index')->with(['status' => 'Permission successfuly create.']);
    }

    //@desc Display permission create form
    //@route GET /permissions/create
    public function create():View
    {
        Gate::authorize('have-permission', ['user-management']);
        return view('permissions.create');
    }

    //@desc Show edit permission form
    //@route GET /permissions/{permission}/edit
    public function edit(Permission $permission): View
    {
        Gate::authorize('have-permission', ['user-management']);
        return view('permissions.edit')->with(['permission' => $permission]);
    }

    //@desc Update  permission details
    //@route POST /permissions/{permission}/edit
    public function update(Request $request,Permission $permission): RedirectResponse
    {
        Gate::authorize('have-permission', ['user-management']);
        $data = $request->validate([
            'name' => [
                'required',
                Rule::unique('permissions')->ignore($permission->id),
            ]
        ]);

        $permission->update($data);

        return redirect()->route('permissions.index')->with(['success' => 'Permission successfully updated.']);
    }

    //@desc Delete permission
    //@route DELETE /permissions
    public function destroy(Permission $permission)
    {
        Gate::authorize('have-permission', ['user-management']);
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
