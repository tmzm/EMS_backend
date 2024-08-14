<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoothCreateRequest;
use App\Http\Requests\BoothEditRequest;
use App\Models\Activity;
use App\Models\Booth;
use App\Models\Event;
use Illuminate\Http\Request;

class BoothController extends Controller
{
    public function create(BoothCreateRequest $request, $event_id)
    {
        $data = $request->validated();

        $event = Event::find($event_id);

        if(!$event){
            self::UnHandledError('Event not found');
        }

        $booth = Booth::create([
           "event_id" => $event_id,
           "size" => $data['size'],
           "price" => $data['price'],
           "status" => "available"
        ]);

        Activity::create([
            'user_id' => $request->user()->id,
            'description' => 'Create booth for ' + $event->name
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

    public function index($event_id)
    {
        self::ok(Booth::where('event_id',$event_id)->latest()->get());
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
