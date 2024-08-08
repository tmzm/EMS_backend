<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Passport\Token;

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

    public function refresh_token(Request $request) {
        if(!$request->user()->id)
            self::unAuth();

        if($request->user()->tokenCan('user-refresh-token')){
            $tokens = Token::where('user_id', $request->user()->id)->get();

            foreach ($tokens as $token) {
                if (in_array('user-access-token', $token->scopes)) {
                    $token->revoke();
                }
            }

            $token = $request->user()->createToken('user_access_token',['user-access-token'])->accessToken;

            self::ok(null,['accessToken' => $token]);
        }

        self::unAuth();
    }
}
