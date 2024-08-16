<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function pay(Request $request, $invoice_id)
    {
        $invoice = Invoice::find($invoice_id);

        if($invoice){

            if(User::find($request->user()->id)->wallet() - $invoice->price < 0)
                self::unHandledError('Not enough money');

            $invoice->status = 'paid';
            $invoice->save();

            self::ok();
        }else{
            self::notFound();
        }
    }
}
