<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermissionController extends Controller
{

    //@desc Display all permissions
    //@route GET /permissions
    public function index():View
    {
        $permissions = Permission::paginate(10);
        return view('permissions.index')->with(['permissions' => $permissions]);
    }

    //@desc Store new permissions
    //@route POST /permissions
    public function store(Request $request):RedirectResponse
    {
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
        return view('permissions.create');
    }

    //@desc Delete permission
    //@route DELETE /permissions
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
