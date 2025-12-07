<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        
        if ($customers->isEmpty()) {
            $this->call(CustomerSeeder::class);
            $customers = Customer::all();
        }

        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        
        foreach ($customers as $customer) {
            // Create 2-5 orders for each customer
            $orderCount = rand(2, 5);
            
            for ($i = 1; $i <= $orderCount; $i++) {
                Order::create([
                    'customer_id' => $customer->id,
                    'order_number' => Order::generateOrderNumber(),
                    'amount' => rand(100, 5000) / 10, // Random amount between 10.00 and 500.00
                    'status' => $statuses[array_rand($statuses)],
                    'order_date' => Carbon::now()->subDays(rand(1, 90)),
                    'notes' => 'Test order ' . $i . ' for ' . $customer->name,
                ]);
            }
        }
    }
}