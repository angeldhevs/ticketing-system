<?php

namespace App\Http\Controllers\Api;

use App\Models\Manage\Role;
use App\Http\Resources\Role\RoleCollection;
use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Role\Role as RoleResource;

class RolesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $role = Role::all()->sortBy('name');
        return RoleResource::collection($role);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Roles\StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request) {
        $role = $request->persist(new Role());
        return RoleResource::make($role);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Manage\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role) {
        return RoleResource::make($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Roles\UpdateRoleRequest  $request
     * @param \App\Models\Manage\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role) {
        $request->persist($role);
        return RoleResource::make($role);
    }

    /**
     * Marks the specified resource as deleted. (soft deletion only)
     * @param \App\Models\Manage\Role  $role
     */
    public function destroy(Role $role) {
        $role->delete();
        return response()->json(null, 204);
    }
}
