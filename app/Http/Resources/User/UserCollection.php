<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Manage\User;
use App\Models\Manage\UserRole;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       

        if($roles !== null) {
            return $this->collection->where(function($q) use($roles) {
                return $q->whereIn('role.name', $roles);
            })->orderBy('id')->get()->toArray();
        } else {
            return $this->collection->sortBy('name')->toArray();
        }
    }
}
