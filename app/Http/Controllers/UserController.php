<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Mail\AcceptedUserMail;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
        self::register_user($request, $request->user()->role);
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

    public function accept_trademark(Request $request, $user_id)
    {
        $user = User::find($user_id);

        if($user){
            $user->accepted_by_admin = 1;
            $user->save();

            Mail::to($user->email)
            ->send(new AcceptedUserMail(
                    'http://localhost:3000/TmainPage',
                    $user->email
                )
            );

            Activity::create([
                'user_id' => $request->user()->id,
                'description' => 'Accept ' . $user->name . ', the owner of ' . $user->trademark_name . ' trademark'
            ]);

            self::ok();
        }

        self::notFound();
    }

    public function index_trademarks()
    {
        self::ok(User::latest()->where('role','trademark_owner')->get());
    }

    public function get_wallet(Request $request)
    {
        self::ok([
            "amount" => $request->user()->wallet()
        ]);    
    }

    public function check_on_email()
    {
        $email = request()->input('email');

        if($email)
            if(User::firstWhere('email',$email))
                self::ok();
            else
                self::notFound();
        else
            self::notFound(); 
    }
}
