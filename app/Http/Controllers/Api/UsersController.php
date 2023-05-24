<?php

namespace App\Http\Controllers\Api;

use App\Models\Manage\User;
use App\Http\Resources\User\User as UserResource;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class UsersController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $roles = $request->has('roles') ? explode(',', $request->input('roles')) : null;

        $users = $roles ? User::whereHas('roles', function($q) use($roles) {
            return $q->whereIn('name', $roles);
        })->orderBy('name')->get() : User::all();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request) {
        $user = $request->persist(new User());
        return UserResource::make($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {
        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\User\UpdateUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user) {
        $request->persist($user);
        return UserResource::make($user);
    }

    /**
     * Marks the specified resource as deleted. (soft deletion only)
     * @param \App\Models\Manage\User  $user
     */
    public function destroy(User $user) {
        $user->delete();
        return response()->json(null, 204);
    }
}
