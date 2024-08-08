<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventEditRequest;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function create(EventCreateRequest $request)
    {
        $data = $request->validated();
        $event = Event::create($data);
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
        self::ok($event);
    }

    public function show($event_id)
    {
        $event = Event::find($event_id);
        $event ? self::ok($event) : self::notFound();
    }

    public function destroy($event_id)
    {
        $event = Event::find($event_id);

        if($event){
            $event->delete();

            self::ok();
        }

        self::notFound();
    }
}
