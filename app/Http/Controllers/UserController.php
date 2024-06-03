<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Http\Request;

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
     * Login the User
     *
     * @param UserStoreRequest $request
     * @return void
     */
    public function store(UserStoreRequest $request): void
    {
        self::login_user($request);
    }

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
