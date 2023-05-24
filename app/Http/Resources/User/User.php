<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Role\Role as RoleResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email
        ];

        if ( ($include = $request->query('include')) != null ) {
            $includes = explode(',', $include);

            if(in_array('roles', $includes)) {
                $response += [ 'roles' => RoleResource::make($this->roles) ];
            }
        }

        return $response;
    }

    public $preserveKeys = true;
}
