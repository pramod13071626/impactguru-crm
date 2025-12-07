<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CustomerController as ApiCustomerController;
use App\Http\Controllers\API\OrderController as ApiOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Customers API
    Route::apiResource('customers', ApiCustomerController::class);
    
    // Orders API
    Route::apiResource('orders', ApiOrderController::class);
    
    // Statistics
    Route::get('/statistics', function () {
        $totalCustomers = \App\Models\Customer::count();
        $totalOrders = \App\Models\Order::count();
        $totalRevenue = \App\Models\Order::sum('amount');
        
        return response()->json([
            'total_customers' => $totalCustomers,
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'average_order_value' => $totalOrders > 0 ? $totalRevenue / $totalOrders : 0,
        ]);
    });
});