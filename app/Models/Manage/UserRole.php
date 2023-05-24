<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Represents the relationship between a user and a role.
 */
class UserRole extends Pivot
{
    protected $table = 'user_role';
    public $incrementing = true;

    protected $fillable = [
        'user_id', 'role_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function role() {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
