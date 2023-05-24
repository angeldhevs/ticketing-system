<?php

namespace App\Http\Controllers\Manage;

use App\Models\Manage\User;
use App\Models\Manage\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;

class UsersController extends Controller
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
            'users' => User::all()
        ];

        return view('manage.users.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'roles' => Role::all()->toArray()
        ];

        return view('manage.users.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Users\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        if($request->persist(new User())) {
            $data = [
                'alert' => [
                    'type' => 'success',
                    'message' => 'User successfully added!'
                ]
            ];
            return redirect()->route('manage.users.index')->with($data);
        } else {
            $data = [
                'alert' => [
                    'type' => 'error',
                    'message' => 'There was an error creating the user.'
                ]
            ];

            return redirect()->back()->with($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $data = [
            'user' => $user
        ];

        return view('manage.users.view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Manage\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data = [
            'roles' => Role::all()->toArray(),
            'user' => $user
        ];

        return view('manage.users.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Users\UpdateUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if($request->persist($user)) {
            $data = [
                'alert' => [
                    'type' => 'success',
                    'message' => 'User successfully updated!'
                ]
            ];

            return redirect()
                ->route('manage.users.show', [ 'id' => $user->id ])
                ->with($data);
        } else {
            $data = [
                'alert' => [
                    'type' => 'error',
                    'message' => 'There was an error updating the user.'
                ]
            ];

            return redirect()->back()->with($data);
        }
    }
}
