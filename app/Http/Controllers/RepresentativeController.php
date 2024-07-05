<?php

namespace App\Http\Controllers;

use App\Http\Requests\RepresentativeCreateRequest;
use App\Http\Requests\RepresentativeEditRequest;
use App\Models\Representative;
use Illuminate\Http\Request;

class RepresentativeController extends Controller
{
    public function create(RepresentativeCreateRequest $request)
    {
        $data = $request->validated();
        $representative = Representative::create([
            "user_id" => $request->user()->id,
            ...$data
        ]);
        self::ok($representative);
    }

    public function index(Request $request)
    {
        self::ok(Representative::latest()->where('user_id',$request->user()->id)->get());
    }

    public function edit(RepresentativeEditRequest $request, $representative_id)
    {
        $data = $request->validated();
        $representative = Representative::where("user_id",$request->user()->id)->firstWhere("id",$representative_id);

        if(!$representative) self::notFound();

        $representative->update($data);
        self::ok($representative);
    }

    public function show(Request $request, $representative_id)
    {
        $representative = Representative::where("user_id",$request->user()->id)->firstWhere("id",$representative_id);
        $representative ? self::ok($representative) : self::notFound();
    }

    public function destroy(Request $request, $representative_id)
    {
        $representative = Representative::where("user_id",$request->user()->id)->firstWhere("id",$representative_id);

        if($representative){
            $representative->delete();

            self::ok();
        }

        self::notFound();
    }
}
