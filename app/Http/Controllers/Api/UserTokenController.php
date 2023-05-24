<?php

namespace App\Http\Controllers\Api;

use App\Models\Manage\User;
use Illuminate\Support\Str;

class UserTokenController extends ApiController
{
    /**
     * Refreshes the token of the current user.
     */
    public function refresh(User $user) {
        $token = Str::random(60);

        $user->forceFill([
            'api_token' => $token
        ])->save();

        return [ 'token' => $token ];
    }
}
