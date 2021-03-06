<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use PDF;

class InvoiceController extends Controller
{
    /**
     * Displaying a list of the invoices
    */
    function index(){
        $invoices = Invoice::orderBy('date', 'DESC')->paginate(4);
        return view('invoices.index', ['invoices' => $invoices]);
    }

    /**
     * Mark an invoice as paid
     */
    function markAsPaid(Invoice $invoice) {

        //Set the finalized column to 1 (true) and save changes
        $invoice->finalized = 1; //1 = true
        $invoice->save();
        //Redirect back
        return back();
    }

    /**
     * Downloading/printing an invoice
     */
    function print(Invoice $invoice) {
        
        $pdf = PDF::loadView('invoices.print', ['invoice' => $invoice]);
        return $pdf->stream('invoice.pdf');
    }
    /**
     * Deleting an invoice
    */
    function delete(Invoice $invoice) {

        $invoice->delete();
        return back();
    }
}
