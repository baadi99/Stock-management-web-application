<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShipmentRequest;
use App\Models\Shipment;
use App\Models\ShipmentTypes;
use App\Models\Product;
use App\Models\Invoice;
class ShipmentController extends Controller
{
    /**
     * Displaying a list of the shipments
    */
    function index(){
        $shipments = Shipment::with(['product:id,label', 'shipment_type:id,type'])
                                ->orderBy('date', 'DESC')
                                ->paginate(4);
        return view('shipments.index', ['shipments' => $shipments]);
    }

    /**
     * Displaying the form for adding a new shipment
    */
    function add(){ 
        // Retrieving shipment types
        $shipmentTypes = ShipmentTypes::get();
        // Retrieving products
        $products = Product::get();
        //Passing Data to the view                                 
        return view('shipments.add', ['shipmentTypes' => $shipmentTypes, 'products' => $products]);
    }

    /**
     * Storing the newly added shipment
     */
    function store(ShipmentRequest $request){

        //When the quantity available in stock is insufficient when making an outgoing shipment
        $shipment_type = ShipmentTypes::find($request->shipment_type_id);
        if($shipment_type->type === "Outgoing"){
            $product = Product::select('quantity')->where('id',$request->product_id)->first();
            if($request->quantity > $product->quantity){
                return back()->withErrors('The quantity available in stock is insufficient (in stock : '.$product->quantity.')');
            }
        }

        try {

            //store the newly added product and return a success message
            Shipment::create($request->all());

        } catch(\Exception $e) {
            return back()->withErrors('Something went wrong!');
        }

        return back()->with('success', 'Shipment added successfully!');
        
    }

    /**
     * Displaying the form for updating a shipment
    */
    function edit(Shipment $shipment){
        // Retrieving shipment types
        $shipmentTypes = ShipmentTypes::get();
        // Retrieving products
        $products = Product::get();

        return view('shipments.edit', ['shipment' => $shipment, 'shipmentTypes' => $shipmentTypes, 'products' => $products]);
    }

    /**
     * Updating a shipment
    */
    function update(ShipmentRequest $request, Shipment $shipment){

        //Determine if the shipment is completed
        if($shipment->finalized === 1) {
            return back()->withErrors('This shipment is completed and can\'t be modified!');
        }

        //Updating the fields
        $shipment->date = $request->date;
        $shipment->shipment_type_id = $request->shipment_type_id;
        $shipment->product_id = $request->product_id;
        //display an error when the quantity available in stock is insufficient
        // when making an outgoing shipment
        if($shipment->shipment_type->type === "Outgoing"){
            
            if($request->quantity > $shipment->product->quantity + $shipment->quantity){
                return back()->withErrors('The quantity available in stock is insufficient(in stock : '.$shipment->product->quantity.')');
            }
        }

        $shipment->quantity = $request->quantity;
        $shipment->total_price = $request->total_price;

        try {
            $shipment->save();
        } catch(\Exception $e) {
            return back()->withErrors('Something went wrong!');
        }
        
        //If updated successully redirect back with success message
        return back()->with('success', 'Shipment updated successfully!');
    }

    /**
     * Marking a shipment as complete and change database data accordingly
     */
    function markAsComplete(Shipment $shipment){

        //Check if the shipment is already completed
        // to avoid re"completion"
        if($shipment->finalized === 1) {
            return back();
        }
        //updating database
        if($shipment->shipment_type->type === "Outgoing"){
            //Subtract the quantity from stock
            $shipment->product->quantity -= $shipment->quantity;
            $shipment->product->save();

        }else if($shipment->shipment_type->type === "Incoming"){
            //Add the quantity to stock
            $shipment->product->quantity += $shipment->quantity;
            $shipment->product->save();
            //Create an invoice
            $invoice = new Invoice;
            $invoice->supplier_id = $shipment->product->supplier_id;
            $invoice->amount = $shipment->total_price;
            $invoice->save();
        }
        //mark the shipment as complete in database
        $shipment->finalized = 1;
        $shipment->save();
        return back();
    }

    /**
     * Deleting a shipment 
    */
    function delete(Shipment $shipment){

        $shipment->delete();
        return back();
    }
}
