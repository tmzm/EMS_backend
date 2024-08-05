<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function create(Request $request, $product_id)
    {
        self::ok(Rate::create([
            "user_id" => $request->user()->id,
            "product_id" => $product_id,
            "number" => $request['number'],
            "comment" => $request['comment']
        ]));
    }

    public function index(Request $request)
    {
        self::ok(Rate::latest()->where('user_id',$request->user()->id)->get());
    }

    public function destroy($rate_id)
    {
        $rate = Rate::find($rate_id);

        if($rate){
            $rate->delete();

            self::ok();
        }

        self::notFound();
    }
}
