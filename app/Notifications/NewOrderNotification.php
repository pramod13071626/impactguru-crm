<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    public $sendEmail;
    public $tries = 3; // Max attempts
    public $timeout = 10; // Timeout in seconds

    public function __construct(Order $order, $sendEmail = true)
    {
        $this->order = $order;
        $this->sendEmail = $sendEmail;
    }

    public function via($notifiable)
    {
        // Always include database
        $channels = ['database'];
        
        // Include mail only if sendEmail is true
        if ($this->sendEmail) {
            $channels[] = 'mail';
        }
        
        return $channels;
    }

    public function toMail($notifiable)
    {
        try {
            return (new MailMessage)
                ->subject('New Order Created: ' . $this->order->order_number)
                ->greeting('Hello ' . $notifiable->name . '!')
                ->line('A new order has been created in ImpactGuru CRM.')
                ->line('**Order Details:**')
                ->line('- Order #: ' . $this->order->order_number)
                ->line('- Customer: ' . ($this->order->customer->name ?? 'N/A'))
                ->line('- Amount: $' . number_format($this->order->amount, 2))
                ->line('- Status: ' . ucfirst($this->order->status))
                ->line('- Date: ' . $this->order->order_date->format('M d, Y'))
                ->action('View Order Details', url('/orders/' . $this->order->id))
                ->line('Thank you for using ImpactGuru CRM!');
                
        } catch (\Exception $e) {
            // Log email error but don't fail the entire notification
            Log::error('Failed to send order notification email: ' . $e->getMessage());
            
            // Return a simple mail message or null
            return (new MailMessage)
                ->subject('New Order Created: ' . $this->order->order_number)
                ->line('A new order has been created. Check the CRM for details.');
        }
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'customer_name' => $this->order->customer->name ?? 'Unknown Customer',
            'customer_id' => $this->order->customer_id,
            'amount' => $this->order->amount,
            'status' => $this->order->status,
            'order_date' => $this->order->order_date->toDateString(),
            'message' => 'New order #' . $this->order->order_number . ' has been created.',
            'url' => '/orders/' . $this->order->id,
            'type' => 'new_order',
            'icon' => 'fas fa-shopping-cart',
            'color' => 'bg-blue-500',
            'created_at' => now()->toDateTimeString(),
        ];
    }

    // Handle job failure
    public function failed(\Throwable $exception)
    {
        Log::error('Notification job failed: ' . $exception->getMessage());
        
        // Still store in database even if email fails
        $adminUsers = \App\Models\User::where('role', 'admin')->get();
        
        foreach ($adminUsers as $admin) {
            $isTestEmail = $admin->email === 'sandipdeore1664@gmail.com';
            
            // Manually store in database
            $admin->notifications()->create([
                'id' => \Illuminate\Support\Str::uuid()->toString(),
                'type' => get_class($this),
                'data' => $this->toArray($admin),
                'read_at' => null,
            ]);
            
            Log::info('Database notification stored manually after failure for: ' . $admin->email);
        }
    }
}