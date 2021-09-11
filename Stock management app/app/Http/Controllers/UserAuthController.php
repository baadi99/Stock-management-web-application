<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\Product;
use App\Models\Shipment;
use App\Http\Requests\UserRequest;

class UserAuthController extends Controller
{
    /**
     * Showing the log in page
     */
    function login(){
        return view('auth.login');
    }

    /**
     * On form submission check if the credentials entered are valid, 
     * and redirect to dashboard otherwise  redirect back 
     * to the form with the corresponding errors
     */
    function checkCredentials(UserRequest $request){
       
        //if validated check if user exists in database
        $user = User::where('email', $request->email)->first();
        if($user){
            //if the user exists check their password
            if(Hash::check($request->password, $user->password)){
                //if password is correct store the user's id and role id in
                // session variables and redirect to dashboard
                $request->session()->put('LoggedUser', $user->id);
                $request->session()->put('user_role', $user->role->role);
                if($user->role->id === 1){
                    return redirect('dashboard');
                } else {
                    return redirect('products');
                }
                    
            }else {
                //if the passwor is invalid redirect back with the corresponding error
                return back()->withErrors('Incorrect password!');
            }
        }else{
            // if the email doesn't exist in database redirect back with the corresponding error
            return back()->withErrors('Email doesn\'t exist in our records');
        }
    }
    /**
     * Function that handles the dashboard data
     */
    function dashboard(){
        //Getting the dashboard data

        //Total products in stock
        $totalProducts = Product::count(); 
        //Products running out in stock
        $lowInStock = Product::where('quantity', '<=', 200)->count();
        //Pending shipments
        $pendingShipments = Shipment::where('finalized', 0)->count();
        //Latest Shipments
        $lastShipments = Shipment::with(['product:id,label', 'shipment_type:id,type']) //Eager load the model and only the specified columns of its relationship
                                    ->where('finalized', 0)
                                    ->take(5)
                                    ->orderByDesc('date')
                                    ->get();
        //Sales data :
        $currentMonthNbSales = Shipment::where('shipment_type_id', 2) 
                                        ->whereMonth('date', date('m'))
                                        ->whereYear('date', date('Y'))
                                        ->count();  

        // Get the profits of the current year
        $currentYearProfits = $this->getCurrentYearProfits();

        // Calculate growth :

        //Retrieving current month's profit, the date('m') method returns the current month
        //and since collections start at index 0 we need to subtract 1 to get the index of current month's profit
        $currentMonthProfit = $currentYearProfits->get(date('m') - 1);
        $lastMonthProfit = $currentYearProfits->get(date('m') - 2);

        $growth = $this->calculateGrowth($lastMonthProfit, $currentMonthProfit);                       
        
        //Passing data to dashboard 
        return view('dashboard',[
                                    'productsInStock' => $totalProducts,
                                    'lowInStock' => $lowInStock, 
                                    'pendingShipments' => $pendingShipments,
                                    'currentMonthSales' => $currentMonthNbSales,
                                    'lastShipments' => $lastShipments,
                                    'currentMonthProfit' => $currentMonthProfit,
                                    'growth' => $growth,
                                    'currentYearProfits' => $currentYearProfits
                                ]);
    }

    /**
     * Showing the profile view
     */
    function profile(){
       
        $user = User::find(session('LoggedUser'));
        
        //Passing the user data to the profile
        return view('profile', ['user' => $user]);
    }

    /**
     * Updating profile data
     */
    function update(UserRequest $request, User $user){

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->address->address = $request->address;
        $user->phone_number = $request->phone_number;
        
        if(Hash::check($request->password, $user->password)) {
            //If password is correct and new password is empty just save changes
            if($request->newPassword == "") {
                $user->save();
                return back()->with('success', 'Profile updated successfully!');
            //if the new password field isn't empty(changing password) then update the password
            }else {
                $user->password = Hash::make($request->newPassword);
                $user->save();
                return back()->with('success', 'Profile updated successfully!');
            }    
        }else {
            return back()->withErrors('Incorrect password!');
        }
        
        
    }
    /**
     * Loging out
     */
    function logout(){
        if(session()->has('LoggedUser')){
            //delete the LoggedUser item from the session
            session()->flush();
        }
        //whether the user is logged in or not redirect to login page
        return redirect('login');
    }

    /**
     * A helper function to calculate the profits of the current year
     * 
     */
    function getCurrentYearProfits(){

        $currentYearProfits = collect([]); //A collection where we will store profits
        //Sales data :
        for($i = 1; $i <= 12; $i++){
            $currentMonthSales = Shipment::with('product:id,buying_cost')
                                            ->where('shipment_type_id', 2)  // 2 = "Outgoing"
                                            ->whereMonth('date', $i)
                                            ->whereYear('date', date('Y'))
                                            ->get(['product_id', 'quantity', 'total_price']);
            
            //Calculating profit :
            $monthProfit = 0;
            //If there are sales in current month calculate its profit otherwise profit is 0                                
            if(!$currentMonthSales->isEmpty()){
                
                foreach($currentMonthSales as $sale){
                    //in each sale we substract the base price(buying cost) from the total price
                    $monthProfit += ( $sale->total_price - ($sale->quantity * $sale->product->buying_cost) );
                    //$monthProfit = number_format($monthProfit, 2); //The data will be displayed in the number k/M format(e.g : 10.0k/10M)
                }   
            }
            //Append profit to profits collection
            $currentYearProfits = $currentYearProfits->concat([$monthProfit]);                               
        }

        return $currentYearProfits;
    }

    /**
     * Calculating growth(how much the profits has been grown)
     */

    function calculateGrowth($lastMonthProfit, $currentMonthProfit){

        // Needs more handling when lastMonthProfit = 0 instead of just returning 1
        $growth = $lastMonthProfit ? (($currentMonthProfit - $lastMonthProfit)*100)/$lastMonthProfit : 100;
        return round($growth, 2);
    }

}
