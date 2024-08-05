<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function create(Request $request)
    {
        self::ok(Activity::create([
            "user_id" => $request->user()->id,
            "description" => $request['description']
        ]));
    }

    public function index(Request $request)
    {
        self::ok(Activity::latest()->where('user_id',$request->user()->id)->get());
    }

    public function show($activity_id)
    {
        $activity = Activity::find($activity_id);
        $activity ? self::ok($activity) : self::notFound();
    }

    public function destroy($activity_id)
    {
        $activity = Activity::find($activity_id);

        if($activity){
            $activity->delete();

            self::ok();
        }

        self::notFound();
    }
}
