<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Staff-specific statistics (only their customers/orders)
        $myCustomers = Customer::where('created_by', $user->id)->count();
        
        $myOrders = Order::whereHas('customer', function($query) use ($user) {
            $query->where('created_by', $user->id);
        })->count();
        
        $myRevenue = Order::whereHas('customer', function($query) use ($user) {
            $query->where('created_by', $user->id);
        })->sum('amount');
        
        // Recent customers created by this staff
        $recentCustomers = Customer::where('created_by', $user->id)
            ->withCount('orders')
            ->latest()
            ->take(5)
            ->get();
            
        // Recent orders from their customers - WITH NULL PROTECTION
        $recentOrders = Order::whereHas('customer', function($query) use ($user) {
            $query->where('created_by', $user->id);
        })
        ->with(['customer' => function($query) {
            // Use withDefault to handle deleted customers
            $query->withDefault([
                'name' => 'Customer Deleted',
                'email' => 'N/A',
            ]);
        }])
        ->latest()
        ->take(5)
        ->get();
        
        // Pending orders
        $pendingOrders = Order::whereHas('customer', function($query) use ($user) {
            $query->where('created_by', $user->id);
        })
        ->where('status', 'pending')
        ->count();
        
        return view('staff.dashboard.index', compact(
            'myCustomers',
            'myOrders',
            'myRevenue',
            'recentCustomers',
            'recentOrders',
            'pendingOrders'
        ));
    }
    
    public function myCustomers()
    {
        $user = Auth::user();
        $customers = Customer::where('created_by', $user->id)
            ->withCount('orders')
            ->latest()
            ->paginate(10);
            
        return view('staff.customers.index', compact('customers'));
    }
}