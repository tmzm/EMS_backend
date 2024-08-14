<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function pay($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);

        if($invoice){
            $invoice->status = 'paid';
            $invoice->save();

            self::ok();
        }else{
            self::notFound();
        }
    }
}
