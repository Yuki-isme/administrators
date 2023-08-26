<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoleService;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    private $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = $this->roleService->index();

        return view('admin.role.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = $this->roleService->getPermissions();
        $admins = $this->roleService->getAdmins();

        return view('admin.role.form', ['permissions' => $permissions, 'admins' => $admins]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->roleService->store($request);

        return Redirect::route('roles.index')->with('success', 'Created role successfully!');
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
    public function edit(string $id)
    {
        $role = $this->roleService->getRoleById($id);
        $permissions = $this->roleService->getPermissions();
        $admins = $this->roleService->getAdmins();

        return view('admin.role.form', ['role' => $role, 'permissions' => $permissions, 'admins' => $admins]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->roleService->update($request, $id);

        return Redirect::route('roles.index')->with('success', 'Updated role successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $this->roleService->destroy($id);

        return Redirect::back()->with('alert', 'Deleted product successfully!');
    }
}
