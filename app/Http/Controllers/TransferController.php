<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function create(Request $request)
    {
        $v = validator($request->all(),[
            'email' => 'required|email',
            'amount' => 'required'
        ]);

        $data = $v->validated();

        $user = User::firstWhere('email',$data['email']);

        if($user){
            $transfer = Transfer::create([
                'user_id' => $user->id,
                'amount' => $request['amount'],
            ]);

            Activity::create([
                'user_id' => $request->user()->id,
                'description' => 'Transfer to ' . $user->name
            ]);
    
            self::ok($transfer);
        }

        self::notFound();
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
