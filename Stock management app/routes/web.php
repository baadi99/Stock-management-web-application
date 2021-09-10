<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\InvoiceController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('login', [UserAuthController::class, 'login'])->name('login')->middleware('isAlreadyLoggedIn');
Route::post('login', [UserAuthController::class, 'checkCredentials'])->name('checkCredentials');



Route::middleware('isLoggedIn')->group(function () {
    
    Route::get('profile', [UserAuthController::class, 'profile'])->name('profile');
    Route::patch('profile/{user}', [UserAuthController::class, 'update'])->name('profile.update');
    Route::get('logout', [UserAuthController::class, 'logout'])->name('logout');

    // Shipments CRUD operations
    Route::prefix('shipments')->group(function () {
        Route::get('/index', [ShipmentController::class, 'index'])->name('shipments');
        Route::get('/', [ShipmentController::class, 'add'])->name('shipments.add');
        Route::post('/', [ShipmentController::class, 'store'])->name('shipments.store');
        Route::get('/{shipment}', [ShipmentController::class, 'edit'])->name('shipments.edit');
        Route::patch('/{shipment}', [ShipmentController::class, 'update'])->name('shipments.update');
        Route::patch('/{shipment}/completed', [ShipmentController::class, 'markAsComplete'])->name('shipments.markAsComplete');
        Route::delete('/{shipment}', [ShipmentController::class, 'delete'])->name('shipments.delete');
    });
    
    // Products CRUD operations
    Route::prefix('products')->group(function () {
        Route::get('/index', [ProductController::class, 'index'])->name('products');
        Route::get('/', [ProductController::class, 'add'])->name('products.add');
        Route::post('/', [ProductController::class, 'store'])->name('products.store');
        Route::get('/{product}', [ProductController::class, 'edit'])->name('products.edit');
        Route::patch('/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('{product}', [ProductController::class, 'delete'])->name('products.delete');
    });

    //Reserved to admin
    Route::middleware('isAdmin')->group(function() {

        Route::get('dashboard', [UserAuthController::class, 'dashboard'])->name('dashboard');
        
        // Employees CRUD operations
        Route::prefix('employees')->group(function () {
            Route::get('/index', [EmployeeController::class, 'index'])->name('employees');
            Route::get('/', [EmployeeController::class, 'add'])->name('employees.add');
            Route::post('/', [EmployeeController::class, 'store'])->name('employees.store');
            Route::get('/{employee}', [EmployeeController::class, 'edit'])->name('employees.edit');
            Route::patch('/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
            Route::delete('{employee}', [EmployeeController::class, 'delete'])->name('employees.delete');
        });

        // Suppliers CRUD operations
        Route::prefix('suppliers')->group(function () {
            Route::get('/index', [SupplierController::class, 'index'])->name('suppliers');
            Route::get('/', [SupplierController::class, 'add'])->name('suppliers.add');
            Route::post('/', [SupplierController::class, 'store'])->name('suppliers.store');
            Route::get('/{supplier}', [SupplierController::class, 'edit'])->name('suppliers.edit');
            Route::patch('/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
            Route::delete('/{supplier}', [SupplierController::class, 'delete'])->name('suppliers.delete');
        });

        //Invoices operations
        Route::prefix('invoices')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('invoices');
            Route::patch('/{invoice}', [InvoiceController::class, 'markAsPaid'])->name('invoice.markAsPaid');
            Route::get('/{invoice}', [InvoiceController::class, 'print'])->name('invoice.print');
            Route::delete('/{invoice}', [InvoiceController::class, 'delete'])->name('invoice.delete');
        });
    });

});
