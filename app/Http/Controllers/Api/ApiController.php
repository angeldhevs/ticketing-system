<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

abstract class ApiController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Returns the current user.
     */
    protected function user() {
        return Auth::guard('api')->user();
    }
}
