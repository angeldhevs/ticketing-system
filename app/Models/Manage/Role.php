<?php

namespace App\Models\Manage;

use App\Models\Manage\UserRole;
use App\Models\ModelBase;

class Role extends ModelBase
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'display_name' ];

    /**
     * The users that were assigned to this role.
     *
     * @var array
     */
    public function users() {
        return $this->belongsToMany(User::class, 'user_role')
                    ->using(UserRole::class)
                    ->withTimestamps();
    }
}
