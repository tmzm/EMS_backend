<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCreateRequest;
use App\Models\Event;

class EventController extends Controller
{
    public function create(EventCreateRequest $request)
    {
        $data = $request->validated();
        $event = Event::create($data);
        self::ok($event);
    }
}
