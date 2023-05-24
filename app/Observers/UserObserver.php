<?php

namespace App\Observers;

use App\Models\Manage\User;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    /**
     * Handle the user "creating" event.
     *
     * @param  \App\Models\Manage\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        $this->hashPassword($user);
        $user->api_token = str_random(60);
    }

    /**
     * Handle the user "created" event.
     *
     * @param  \App\Models\Manage\User  $user
     * @return void
     */
    public function created(User $user)
    {

    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\Models\Manage\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        $this->hashPassword($user);
        $user->api_token = bin2hex(str_random(40));
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\Models\Manage\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\Models\Manage\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\Models\Manage\User  $user
     * @return void
     */
    public function forceDeleted(User $user) {
        //
    }

    /**
     * Hashes the user password.
     */
    protected function hashPassword(User $user) {
        $user->password =  Hash::make($user->password);
    }
}
