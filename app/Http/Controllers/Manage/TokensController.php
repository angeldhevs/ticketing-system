<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokensController extends Controller
{
    public function refresh(Request $request) {
        $token = str_random(40);

        $this->user()
                ->forceFill([ 'api_token' => bin2hex($token) ])
                ->save();

        return [ 'token' => $token ];
    }
}
