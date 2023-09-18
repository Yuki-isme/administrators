<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\AdminService;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;

class AdminController extends Controller
{
    private $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = $this->adminService->index();

        return view('admin.admin.index', ['admins' => $admins]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->adminService->getRoles();

        return view('admin.admin.form', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
        $this->adminService->store($request);

        return Redirect::route('admins.index')->with('success', 'Created Success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = $this->adminService->getAdminRoles($id);
        $roles = $this->adminService->getRoles();

        return view('admin.admin.form', ['admin' => $admin, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminUpdateRequest $request, string $id)
    {
        dd($request);
        $this->adminService->update($request, $id);

        return Redirect::route('admins.index')->with('success', 'Updated Success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->adminService->destroy($id);

        return Redirect::route('admins.index')->with('success', 'Deleted Success');
    }

    public function profile()
    {
        return view('admin.admin.profile');
    }
}
