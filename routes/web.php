<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Main dashboard route - redirects based on role (IMPORTANT: Keep this FIRST)
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('staff.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Test middleware route
    Route::get('/test-admin', function () {
        return 'Admin access granted! You are: ' . auth()->user()->name;
    })->middleware(['auth', 'isAdmin']);
    
    // Admin-only routes
    Route::middleware(['isAdmin'])->group(function () {
        Route::get('/admin/users', function () {
            $users = \App\Models\User::orderBy('created_at', 'desc')->get();
            return view('admin.users', compact('users'));
        })->name('admin.users');
    });
   
    // Customer routes - accessible by both admin and staff
    Route::resource('customers', CustomerController::class);
    
    // Additional customer routes
    Route::get('customers/{id}/restore', [CustomerController::class, 'restore'])
        ->name('customers.restore');
    Route::delete('customers/{id}/force-delete', [CustomerController::class, 'forceDelete'])
        ->name('customers.force-delete');

    // Order routes
    Route::resource('orders', OrderController::class);
    
    // Additional order routes
    Route::get('customers/{customer}/orders/create', [OrderController::class, 'createFromCustomer'])
        ->name('orders.create.from-customer');
    // Export routes for orders
    Route::get('/orders/export/csv', [OrderController::class, 'exportCsv'])->name('orders.export.csv');
    Route::get('/orders/export/pdf', [OrderController::class, 'exportPdf'])->name('orders.export.pdf');
});
    // Role-based dashboard routes
    Route::middleware(['isAdmin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/statistics', [AdminDashboardController::class, 'statistics'])->name('statistics');
        Route::get('/activity-logs', [AdminDashboardController::class, 'activityLogs'])->name('activity.logs');
    });

    Route::middleware(['staff'])->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
        Route::get('/my-customers', [StaffDashboardController::class, 'myCustomers'])->name('my.customers');
    });

    // Test route for middleware - accessible by all authenticated users
    Route::get('/test-role', function () {
        $user = auth()->user();
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_admin' => $user->isAdmin(),
            'is_staff' => $user->isStaff(),
        ]);
    })->name('test.role');


// Export routes for customers
Route::middleware(['auth'])->group(function () {
    Route::get('/customers/export/csv', [CustomerController::class, 'exportCsv'])->name('customers.export.csv');
    Route::get('/customers/export/pdf', [CustomerController::class, 'exportPdf'])->name('customers.export.pdf');
});


Route::get('/test-notification', function () {
    // Find your test user
    $user = \App\Models\User::where('email', 'sandipdeore1664@gmail.com')->first();
    
    if (!$user) {
        return 'Test user not found. Create a user with email: sandipdeore1664@gmail.com';
    }
    
    // Get or create a test order
    $order = \App\Models\Order::first();
    
    if (!$order) {
        // Create a dummy order if none exists
        $order = new \App\Models\Order();
        $order->order_number = 'TEST-123';
        $order->amount = 100.00;
        $order->status = 'pending';
        $order->order_date = now();
        $order->customer_id = \App\Models\Customer::first()->id ?? 1;
        $order->save();
    }
    
    // Send test notification
    $user->notify(new \App\Notifications\NewOrderNotification($order, true));
    
    return 'Test notification sent to: ' . $user->email . '<br>Check your email and database.';
});

Route::middleware(['auth'])->prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/mark-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
});
// routes/web.php (temporary for testing)
Route::get('/test-404', function () {
    abort(404);
});

Route::get('/test-500', function () {
    abort(500);
});
require __DIR__.'/auth.php';