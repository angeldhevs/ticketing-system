<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\ApiRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\Manage\Role;

class UpdateUserRequest extends ApiRequest
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
                'sometimes',
                'required',
                'max:255'
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                'unique:users,email,'.$this->id.',id,deleted_at,NULL'
            ],
            'role_id' => [
                'sometimes',
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
        
        if ( ($this->password ?? null) != null ) {
            $user->password = Hash::make($this->password);
        }

        if ( ($this->role_id ?? null) != null ) {
            $role = Role::findOrFail($this->role_id);
            $user->roles()->sync($role);
        }

        $model->save();

        return $model;
    }
}
