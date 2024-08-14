<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventEditRequest;
use App\Models\Activity;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function create(EventCreateRequest $request)
    {
        $data = $request->validated();
        $event = Event::create($data);

        Activity::create([
            'user_id' => $request->user()->id,
            'description' => 'create ' + $event->name + ' event'
        ]);

        self::ok($event);
    }

    public function index()
    {
        self::ok(Event::latest()->get());
    }

    public function index_active()
    {
        self::ok(Event::latest()->where('start_date', '<=', Carbon::now())
        ->where('end_date', '>=', Carbon::now())
        ->get());
    }

    public function edit(EventEditRequest $request, $event_id)
    {
        $data = $request->validated();
        $event = Event::find($event_id);
        $event->update($data);

        Activity::create([
            'user_id' => $request->user()->id,
            'description' => 'edit ' + $event->name + ' event'
        ]);

        self::ok($event);
    }

    public function show($event_id)
    {
        $event = Event::find($event_id);
        $event ? self::ok($event) : self::notFound();
    }

    public function destroy(Request $request ,$event_id)
    {
        $event = Event::find($event_id);

        if($event){
            $event->delete();

            Activity::create([
                'user_id' => $request->user()->id,
                'description' => 'create ' + $event->name + ' event'
            ]);

            self::ok();
        }

        self::notFound();
    }
}
