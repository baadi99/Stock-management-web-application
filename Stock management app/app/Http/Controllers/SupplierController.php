<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display all suppliers 
     */
    function index(){
        $suppliers = Supplier::paginate(2);
        return view('suppliers.index', ['suppliers' => $suppliers]);
    }
    
    /**
     * Display the form of adding a new supplier
     */
    function add(){
        return view('suppliers.add');
    }

    /**
     * Store the newly added supplier
     */
    function store(SupplierRequest $request){

        Supplier::create($request->all());
        return back()->with('success', 'Supplier added successfully!');
    }

    /**
     * Displaying the form for updating supplier info
    */
    function edit(Supplier $supplier) {

        return view('suppliers.edit', ['supplier' => $supplier]);
    }

    /**
     * Updating supplier info
    */
    function update(SupplierRequest $request, Supplier $supplier) {

        //Updating the fields
        $supplier->first_name =  $request->first_name;
        $supplier->last_name = $request->last_name;
        $supplier->email = $request->email;
        $supplier->address->address = $request->address;
        $supplier->phone_number = $request->phone_number;
        $supplier->save();
        //If updated successully redirect back with success message
        return back()->with('success', 'Supplier information updated successfully!');
    }

    /**
     * Deleting supplier
    */
    function delete(Supplier $supplier) {

        $supplier->delete();
        return back()->with('succees','Supplier deleted successfully!');
    }
}
