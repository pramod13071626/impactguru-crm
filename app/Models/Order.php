<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_number',
        'amount',
        'status',
        'order_date',
        'notes'
    ];

    protected $casts = [
        'order_date' => 'date',
        'amount' => 'decimal:2',
    ];

    // Relationship with customer
    public function customer()
    {
        return $this->belongsTo(Customer::class)->withDefault([
            'name' => 'Deleted Customer',
            'email' => 'N/A',
            'profile_image_url' => asset('images/default-avatar.png'),
        ]);
    }

    // Generate unique order number
    public static function generateOrderNumber()
    {
        $prefix = 'ORD-';
        $date = date('Ymd');
        $lastOrder = Order::where('order_number', 'like', $prefix . $date . '%')
            ->orderBy('order_number', 'desc')
            ->first();
        
        if ($lastOrder) {
            $lastNumber = intval(substr($lastOrder->order_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return $prefix . $date . $newNumber;
    }

    // Accessor for status badge class
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'completed' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    // Accessor for status label
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'completed' => 'Completed',
            'pending' => 'Pending',
            'processing' => 'Processing',
            'cancelled' => 'Cancelled',
            default => 'Unknown'
        };
    }

    protected static function booted()
{
    static::created(function ($order) {
        \Log::info('Order created event triggered for order #' . $order->order_number);
        
        // Send notification to all admin users
        $adminUsers = \App\Models\User::where('role', 'admin')->get();
        
        foreach ($adminUsers as $admin) {
            // Check if this is your test email
            $isTestEmail = $admin->email === 'sandipdeore1664@gmail.com';
            
            // Send notification with appropriate channels
            $admin->notify(new \App\Notifications\NewOrderNotification($order, $isTestEmail));
            
            // Log what happened
            if ($isTestEmail) {
                \Log::info('Email + Database notification sent to: ' . $admin->email);
            } else {
                \Log::info('Database-only notification stored for: ' . $admin->email);
            }
        }
    });
}
}