<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Address;
use App\Models\Role;
use App\Http\Requests\EmployeeRequest;

class EmployeeController extends Controller
{
    /**
     * Display all employees
     */
    function index(){
        $employees = User::where('role_id', 2)->paginate(1); 
        return view('employees.index', ['employees' => $employees]);
    }
    /**
     *  Displaying a form for adding a new employee
     */  
    function add(){
        return view('employees.add', ['roles' => Role::get()]);
    }

    /**
     * Store the newly added employee
     */
    function store(EmployeeRequest $request){
        //Validating the request

        //create new user
        $employee = new User; 

        $employee->first_name =  $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->email = $request->email;
        $employee->phone_number = $request->phone_number;
        $employee->role_id = $request->role_id;
        $employee->password = Hash::make($request->password);
        
        $employee->save();
        //Adding address
        $address = new Address;
        $address->address = $request->address;

        //Save the relationship
        $employee->address()->save($address);
        
        return back()->with('success', 'Employee added successfully!');
    }

    /**
     * Displaying the form for updating employee info
    */
    function edit(User $employee){
        return view('employees.edit', ['employee' => $employee]);
    }

    /**
     * Updating employee info
    */
    function update(EmployeeRequest $request, User $employee){
        
        //Updating the fields
        $employee->first_name =  $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->email = $request->email;
        $employee->address->address = $request->address;
        $employee->phone_number = $request->phone_number;
        $employee->role_id = $request->role_id;

        try {
            $employee->save();
        } catch(\Exception $e) {
            return back()->withErrors('Something went wrong!');
        }
        
        //If updated successully redirect back with success message
        return back()->with('success', 'Employee information updated successfully!');
    }

    /**
     * Deleting employee
    */
    function delete(User $employee){
        //Retrieving the employee from database and deleting it
        $employee->delete();
        return back()->with('succees','Employee deleted successfully!');
    }
}
