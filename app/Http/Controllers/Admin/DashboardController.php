<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // User statistics
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $staffCount = User::where('role', 'staff')->count();
        
        // Customer statistics
        $totalCustomers = Customer::count();
        $weeklyCustomers = Customer::where('created_at', '>=', now()->subDays(7))->count();
        
        // Order statistics
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('amount');
        $weeklyOrders = Order::where('created_at', '>=', now()->subDays(7))->count();
        $weeklyRevenue = Order::where('created_at', '>=', now()->subDays(7))->sum('amount');
        
        // Recent Activity
        $recentCustomers = Customer::withCount('orders')->latest()->take(10)->get();
        $recentOrders = Order::with('customer')->latest()->take(10)->get();
        $recentUsers = User::latest()->take(5)->get();
        
        // Order Status Distribution
        $orderStatuses = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];
        
        // Monthly Revenue Chart Data
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenue = Order::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');
            $monthlyRevenue[] = [
                'month' => $month->format('M Y'),
                'revenue' => $revenue
            ];
        }
        
        return view('admin.dashboard.index', compact(
            'totalUsers',
            'adminCount',
            'staffCount',
            'totalCustomers',
            'totalOrders',
            'totalRevenue',
            'weeklyCustomers',
            'weeklyOrders',
            'weeklyRevenue',
            'recentCustomers',
            'recentOrders',
            'recentUsers',
            'orderStatuses',
            'monthlyRevenue'
        ));
    }
    
    public function statistics()
    {
        // Advanced statistics page with charts
        return view('admin.dashboard.statistics');
    }
    
    public function activityLogs()
    {
        // Activity logs page
        return view('admin.dashboard.activity-logs');
    }
}