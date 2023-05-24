<?php

namespace App\Http\Controllers\Manage;

use App\Models\Manage\Role;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'roles' => Role::all()
        ];
        return view('manage.roles.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        if($request->validated()) {
            Role::create([
                'name' => $request['name']
            ]);

            return redirect()->route('manage.roles.index');
        }

        return redirect()->route('manage.roles.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);

        if($role == null) {
            return Response::json([
                'message' => 'Role with id of '.$id.' was not found.'
            ], 404);
        }

        $data = [
            'role' => Role::find($id)
        ];

        return view('manage.roles.view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);

        if($role == null) {
            return Response::json([
                'message' => 'Role with id of '.$id.' was not found.'
            ], 404);
        }

        $data = [
            'role' => Role::find($id)
        ];

        return view('manage.roles.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        if($request->validated()) {
            $role = Role::find($id);

            if($role == null) {
                return Response::json([
                    'message' => 'Role with id of '.$id.' was not found.'
                ], 404);
            }

            $role->name = $request['name'];
            $role->save();

            return redirect()->route('manage.roles.show', [ 'id' => $id ]);
        }
    }
}
