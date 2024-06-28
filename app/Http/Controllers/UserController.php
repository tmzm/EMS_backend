<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create the User and Token
     *
     * @param UserCreateRequest $request
     * @return void
     */
    public function create(UserCreateRequest $request): void
    {
        self::register_user($request);
    }

    /**
     * Show user details
     *
     * @param Request $request
     * @return void
     */
    public function show(Request $request): void
    {
        $user = $request->user();
        self::ok($user);
    }

    /**
     * Login the User
     *
     * @param UserStoreRequest $request
     * @return void
     */
    public function store(UserStoreRequest $request): void
    {
        self::login_user($request);
    }

//    public function refresh_token(Request $request)
//    {
//        $token = $request->user()->createToken('User Token')->accessToken;
//        $refreshToken = $request->user()->createToken('User Refresh Token')->accessToken;
//
//        self::ok(["accessToken" => $token, "refreshToken" => $refreshToken]);
//        self::ok($request->user());
//    }

    /**
     * Revoke User Token
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        self::logout_user($request);
    }
}
