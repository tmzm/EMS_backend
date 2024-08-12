<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function create(Request $request)
    {
        $transfer = Transfer::create([
            'user_id' => $request->user()->id,
            'amount' => $request['amount'],
        ]);

        self::ok($transfer);
    }

    public function edit(Request $request, $transfer_id)
    {
        $transfer = Transfer::find($transfer_id);

        if($request['amount']){
            $transfer->update([
                'amount' => $request['amount']
            ]);
        }

        self::ok($transfer);
    }
}
