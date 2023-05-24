<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\ApiRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\Manage\Role;

class StoreUserRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'max:255'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email,'.$this->id.',id,deleted_at,NULL'
            ],
            'password' => [
                'required',
                'min:6',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'role_id' => [
                'required'
            ]
        ];
    }

    public function messages()
    {
        return [
            'role_id.required' => 'Please select a role for the user'
        ];
    }

    public function persist(Model $model)
    {
        $user = parent::persist($model);
        $role = Role::findOrFail($this->role_id);
        $user->password = Hash::make($this->password);
        $user->save();

        $user->roles()->attach($role);

        return $model;
    }
}
