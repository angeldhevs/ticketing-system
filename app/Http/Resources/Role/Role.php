<?php

namespace App\Http\Resources\Role;

use Illuminate\Http\Resources\Json\JsonResource;

class Role extends JsonResource
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
            'display_name' => $this->display_name
        ];

        if ( ($include = $request->query('include')) != null ) {
            $includes = explode(',', $include);

            if(in_array('users', $includes)) {
                $response += [ 
                    'users' => $this->users->map(function($user) {
                        return $user->only(['id', 'name', 'email']);
                    })];
            }
        }

        return $response;
    }
}
