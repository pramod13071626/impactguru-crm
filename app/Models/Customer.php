<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'profile_image',
        'created_by',
    ];

    // Relationship with orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relationship with user who created the customer
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessor for profile image URL - ADD THIS
    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return asset('images/default-avatar.png');
    }

    // Count orders
    public function getOrdersCountAttribute()
    {
        return $this->orders()->count();
    }

    // Append accessors to JSON
    protected $appends = ['profile_image_url', 'orders_count'];
}