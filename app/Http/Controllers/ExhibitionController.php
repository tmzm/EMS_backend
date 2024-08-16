<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionCreateRequest;
use App\Http\Requests\ExhibitionEditRequest;
use App\Models\Activity;
use App\Models\Exhibition;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExhibitionController extends Controller
{
    public function create(ExhibitionCreateRequest $request)
    {
        $data = $request->validated();
        $exhibition = Exhibition::create($data);

        Activity::create([
            'user_id' => $request->user()->id,
            'description' => 'create ' . $exhibition->name . ' exhibition'
        ]);

        self::ok($exhibition);
    }

    public function index(Request $request)
    {
        if(isset($request['take'])){
            $exhibitions = Exhibition::latest()->take($request['take'])->get();
            self::ok($exhibitions);
        }

        self::ok(Exhibition::latest()->get());
    }

    public function index_active()
    {
        self::ok(Exhibition::latest()->where('start_date', '<=', Carbon::now())
        ->where('end_date', '>=', Carbon::now())
        ->get());
    }

    public function edit(ExhibitionEditRequest $request, $exhibition_id)
    {
        $data = $request->validated();
        $exhibition = Exhibition::find($exhibition_id);
        $exhibition->update($data);

        Activity::create([
            'user_id' => $request->user()->id,
            'description' => 'edit ' . $exhibition->name . ' exhibition'
        ]);

        self::ok($exhibition);
    }

    public function show($exhibition_id)
    {
        $exhibition = Exhibition::find($exhibition_id);
        $exhibition ? self::ok($exhibition) : self::notFound();
    }

    public function destroy(Request $request ,$exhibition_id)
    {
        $exhibition = Exhibition::find($exhibition_id);

        if($exhibition){
            $exhibition->delete();

            Activity::create([
                'user_id' => $request->user()->id,
                'description' => 'create ' . $exhibition->name . ' exhibition'
            ]);

            self::ok();
        }

        self::notFound();
    }
}
