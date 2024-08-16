<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoothCreateRequest;
use App\Http\Requests\BoothEditRequest;
use App\Models\Activity;
use App\Models\Booth;
use App\Models\Exhibition;
use Illuminate\Http\Request;

class BoothController extends Controller
{
    public function create(BoothCreateRequest $request, $exhibition_id)
    {
        $data = $request->validated();

        $exhibition = Exhibition::find($exhibition_id);

        if(!$exhibition){
            self::UnHandledError('Exhibition not found');
        }

        $booth = Booth::create([
           "exhibition_id" => $exhibition_id,
           "size" => $data['size'],
           "price" => $data['price'],
           "status" => "available"
        ]);

        Activity::create([
            'user_id' => $request->user()->id,
            'description' => 'Create booth for ' . $exhibition->name
        ]);

        self::ok($booth);
    }

    public function edit(BoothEditRequest $request, $booth_id)
    {
        $data = $request->validated();
        $booth = Booth::find($booth_id);
        $booth->update($data);
        self::ok($booth);
    }

    public function index($exhibition_id)
    {
        self::ok(Booth::where('exhibition_id',$exhibition_id)->latest()->get());
    }

    public  function show($booth_id)
    {
        $booth = Booth::find($booth_id);
        $booth ? self::ok($booth) : self::notFound();
    }

    public function destroy($booth_id)
    {
        $booth = Booth::find($booth_id);

        if($booth){
            $booth->delete();

            self::ok();
        }

        self::notFound();
    }
}
