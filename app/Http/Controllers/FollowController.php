<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function create(Request $request)
    {
        self::ok(Follow::create([
            "follower_id" => $request->user()->id,
            "followed_id" => $request['user_id']
        ]));
    }

    public function index(Request $request)
    {
        self::ok(Follow::latest()->where('followed_id',$request->user()->id)->get());
    }

    public function destroy(Request $request, $follow_id)
    {
        $follow = Follow::find($follow_id);

        if($follow){
            $follow->delete();

            self::ok();
        }

        self::notFound();
    }
}
