<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventParticipateCreateRequest;
use App\Models\Activity;
use App\Models\Booth;
use App\Models\EventParticipate;
use App\Models\EventParticipateProduct;
use App\Models\EventParticipateRepresentative;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Representative;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventParticipateController extends Controller
{
    public function participate(EventParticipateCreateRequest $request, $event_id)
    {
        $data = $request->validated();

        $booth = Booth::where('event_id',$event_id)->firstWhere('id',$data['booth_id']);

        if(!$booth){
            self::unHandledError('requested booth not found');
        }

        $event_participate = EventParticipate::create([
            'user_id' => $request->user()->id,
            'event_id' => $event_id,
            'booth_id' => $data['booth_id']
        ]);

        $booth->update([
            "status" => "reserved"
        ]);

        $products = is_array($data['products']) ? $data['products'] : json_decode($data['products']);
        $representatives = is_array($data['representatives']) ? $data['representatives'] : json_decode($data['representatives']);

        foreach($products as $product){
            if(Product::find($product['id']))
                EventParticipateProduct::create([
                    'event_participate_id' => $event_participate->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity']
                ]);
        }

        foreach($representatives as $representative_id){
            if(Representative::find($representative_id))
                EventParticipateRepresentative::create([
                    'event_participate_id' => $event_participate->id,
                    'representative_id' => $representative_id
                ]);
        }

        Invoice::create([
            "event_participate_id" => $event_participate->id,
            "amount" => $booth->price + 200000
        ]);

        self::ok(EventParticipate::find($event_participate->id));
    }

    public function index(Request $request)
    {
        self::ok(EventParticipate::latest()->where('user_id',$request->user()->id)->get());
    }

    public function index_active(Request $request)
    {
        self::ok(EventParticipate::latest()
        ->whereHas('event',
            fn($query) => $query->where('start_date', '<=', Carbon::now())
                                ->where('end_date', '>=', Carbon::now()))
                                ->get());
    }

    public function index_ended(Request $request)
    {
        self::ok(EventParticipate::latest()
        ->whereHas('event',
            fn($query) => $query->where('start_date', '>=', Carbon::now())
                                ->orWhere('end_date', '<=', Carbon::now()))
                                ->get());
    }

    public function show($event_participate_id)
    {
        $event_participate = EventParticipate::find($event_participate_id);

        if($event_participate){
            self::ok($event_participate);
        }

        self::notFound();
    }
}
