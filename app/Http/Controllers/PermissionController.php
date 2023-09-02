<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\PermissionService;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Redirect;

class PermissionController extends Controller
{
    private $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = $this->permissionService->index();

        return view('admin.permission.index', ['permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::get();

        return view('admin.permission.form', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        try {
            DB::beginTransaction();
    
            if (isset($request->setofname)) {
                $permissionName = $request->setofname;
                $rolesToSync = $request->roles ?? [];
    
                // Tạo hoặc cập nhật quyền "index_{setofname}"
                $index = Permission::firstOrCreate(['name' => "index_$permissionName"]);
                $index->roles()->sync($rolesToSync);

                $index = Permission::firstOrCreate(['name' => "detail_$permissionName"]);
                $index->roles()->sync($rolesToSync);

                // Tạo hoặc cập nhật quyền "create_{setofname}"
                $create = Permission::firstOrCreate(['name' => "create_$permissionName"]);
                $create->roles()->sync($rolesToSync);
    
                // Tạo hoặc cập nhật quyền "update_{setofname}"
                $update = Permission::firstOrCreate(['name' => "update_$permissionName"]);
                $update->roles()->sync($rolesToSync);
    
                // Tạo hoặc cập nhật quyền "delete_{setofname}"
                $delete = Permission::firstOrCreate(['name' => "delete_$permissionName"]);
                $delete->roles()->sync($rolesToSync);
                
            }

            if(isset($request->name)){
                $rolesToSync = $request->roles ?? [];
                $permission = Permission::firstOrCreate(['name' => $request->name]);
                $permission->roles()->sync($rolesToSync);
            }

            DB::commit();

            return Redirect::route('permissions.index')->with('success', 'Successfully created permissions');
        }
        catch(\Exception $e){
            DB::rollBack();
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}