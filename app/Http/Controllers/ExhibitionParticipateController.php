<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionParticipateCreateRequest;
use App\Models\Activity;
use App\Models\Booth;
use App\Models\ExhibitionParticipate;
use App\Models\ExhibitionParticipateProduct;
use App\Models\ExhibitionParticipateRepresentative;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Representative;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExhibitionParticipateController extends Controller
{
    public function participate(ExhibitionParticipateCreateRequest $request, $exhibition_id)
    {
        $data = $request->validated();

        $booth = Booth::where('exhibition_id',$exhibition_id)->firstWhere('id',$data['booth_id']);

        if(!$booth){
            self::unHandledError('requested booth not found');
        }

        $products = is_array($data['products']) ? $data['products'] : json_decode($data['products']);
        $representatives = is_array($data['representatives']) ? $data['representatives'] : json_decode($data['representatives']);

        foreach($representatives as $representative_id){
            $r = Representative::find($representative_id);
            if(!$r || $r->visa_state != 'accepted'){
                self::unHandledError('representative not found or visa state is not accepted');
            }
        }

        foreach($products as $product_id){
            $p = Representative::find($product_id);
            if(!$p){
                self::unHandledError('requested representative not found');
            }
        }

        $exhibition_participate = ExhibitionParticipate::create([
            'user_id' => $request->user()->id,
            'exhibition_id' => $exhibition_id,
            'booth_id' => $data['booth_id']
        ]);

        $booth->update([
            "status" => "reserved"
        ]);


        foreach($products as $product){
            ExhibitionParticipateProduct::create([
                'participate_id' => $exhibition_participate->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity']
            ]);
        }

        foreach($representatives as $representative_id){
            ExhibitionParticipateRepresentative::create([
                'participate_id' => $exhibition_participate->id,
                'representative_id' => $representative_id
            ]);
        }

        Invoice::create([
            "participate_id" => $exhibition_participate->id,
            "amount" => $booth->price + 200000
        ]);

        self::ok(ExhibitionParticipate::find($exhibition_participate->id));
    }

    public function index(Request $request)
    {
        self::ok(ExhibitionParticipate::latest()->where('user_id',$request->user()->id)->get());
    }

    public function index_active(Request $request)
    {
        self::ok(ExhibitionParticipate::latest()
        ->whereHas('exhibition',
            fn($query) => $query->where('start_date', '<=', Carbon::now())
                                ->where('end_date', '>=', Carbon::now()))
                                ->get());
    }

    public function index_ended(Request $request)
    {
        self::ok(ExhibitionParticipate::latest()
        ->whereHas('exhibition',
            fn($query) => $query->where('start_date', '>=', Carbon::now())
                                ->orWhere('end_date', '<=', Carbon::now()))
                                ->get());
    }

    public function show($participate_id)
    {
        $exhibition_participate = ExhibitionParticipate::find($participate_id);

        if($exhibition_participate){
            self::ok($exhibition_participate);
        }

        self::notFound();
    }
}
