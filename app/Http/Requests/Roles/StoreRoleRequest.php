<?php

namespace App\Http\Requests\Roles;

use App\Http\Requests\ApiRequest;

class StoreRoleRequest extends ApiRequest
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
                'unique:roles'
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Role already exists'
        ];
    }
}
