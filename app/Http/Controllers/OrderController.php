<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('search');
        
        $orders = Order::with(['customer' => function($query) {
            // Eager load customer with default values if deleted
            $query->withDefault([
                'name' => 'Deleted Customer',
                'email' => 'N/A',
            ]);
        }])
        ->when($status, function ($query, $status) {
            return $query->where('status', $status);
        })
        ->when($search, function ($query, $search) {
            return $query->where('order_number', 'like', "%{$search}%")
                        ->orWhereHas('customer', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%");
                        });
        })
        ->latest()
        ->paginate(10);

        // Check if it's an AJAX request
        if ($request->ajax() || $request->has('ajax')) {
            return response()->json([
                'html' => view('orders.partials.table', compact('orders'))->render(),
                'statistics' => view('orders.partials.statistics', compact('orders'))->render()
            ]);
        }

        return view('orders.index', compact('orders', 'status', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $customers = Customer::orderBy('name')->get();
        $selectedCustomer = $request->input('customer');
        
        return view('orders.create', compact('customers', 'selectedCustomer'));
    }

    /**
     * Create order for specific customer.
     */
    public function createFromCustomer(Customer $customer)
    {
        return view('orders.create', [
            'customers' => Customer::orderBy('name')->get(),
            'selectedCustomer' => $customer->id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'order_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['order_number'] = Order::generateOrderNumber();
        
        Order::create($validated);

        return redirect()->route('orders.index')
            ->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Load customer with default values if deleted
        $order->load(['customer' => function($query) {
            $query->withDefault([
                'name' => 'Deleted Customer',
                'email' => 'N/A',
            ]);
        }]);
        
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        // Load customer with default values if deleted
        $order->load(['customer' => function($query) {
            $query->withDefault([
                'name' => 'Deleted Customer',
                'email' => 'N/A',
            ]);
        }]);
        
        $customers = Customer::orderBy('name')->get();
        
        return view('orders.edit', compact('order', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'order_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $order->update($validated);

        return redirect()->route('orders.index')
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }

        /**
     * Export orders to CSV
     */
    public function exportCsv(Request $request)
    {
        $fileName = 'orders-' . date('Y-m-d') . '.csv';
        
        // Base query with customer relationship
        $query = Order::with(['customer' => function($query) {
            $query->withDefault([
                'name' => 'Deleted Customer',
                'email' => 'N/A',
            ]);
        }]);
        
        // Check if user is staff - only show orders from their customers
        if (auth()->user()->isStaff()) {
            $query->whereHas('customer', function ($q) {
                $q->where('created_by', auth()->id());
            });
        }
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('order_date', [
                $request->start_date,
                $request->end_date
            ]);
        }
        
        $orders = $query->latest()->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'Order Number', 'Customer Name', 'Customer Email', 
                'Amount', 'Status', 'Order Date', 'Notes', 'Created At'
            ]);
            
            // Add data rows
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->customer->name,
                    $order->customer->email,
                    $order->amount,
                    ucfirst($order->status),
                    $order->order_date,
                    $order->notes ?? 'N/A',
                    $order->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export orders to PDF
     */
    public function exportPdf(Request $request)
    {
        // Base query with customer relationship
        $query = Order::with(['customer' => function($query) {
            $query->withDefault([
                'name' => 'Deleted Customer',
                'email' => 'N/A',
            ]);
        }]);
        
        // Check if user is staff - only show orders from their customers
        if (auth()->user()->isStaff()) {
            $query->whereHas('customer', function ($q) {
                $q->where('created_by', auth()->id());
            });
        }
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('order_date', [
                $request->start_date,
                $request->end_date
            ]);
        }
        
        $orders = $query->latest()->get();
        
        // Calculate totals
        $totalAmount = $orders->sum('amount');
        $pendingCount = $orders->where('status', 'pending')->count();
        $completedCount = $orders->where('status', 'completed')->count();
        
        $pdf = \PDF::loadView('exports.orders-pdf', [
            'orders' => $orders,
            'title' => 'Orders Report',
            'date' => now()->format('F d, Y'),
            'totalAmount' => $totalAmount,
            'totalOrders' => $orders->count(),
            'pendingCount' => $pendingCount,
            'completedCount' => $completedCount,
            'statusFilter' => $request->status ?? 'All',
            'startDate' => $request->start_date,
            'endDate' => $request->end_date,
        ]);
        
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('orders-' . date('Y-m-d') . '.pdf');
    }
}
