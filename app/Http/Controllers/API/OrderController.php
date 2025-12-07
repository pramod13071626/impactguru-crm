<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if user is staff - only show orders from their customers
        if (auth()->user()->isStaff()) {
            $orders = Order::whereHas('customer', function ($query) {
                $query->where('created_by', auth()->id());
            })
            ->with(['customer' => function($query) {
                $query->withDefault([
                    'name' => 'Deleted Customer',
                    'email' => 'N/A',
                ]);
            }])
            ->latest()
            ->paginate(10);
        } else {
            // Admin sees all orders
            $orders = Order::with(['customer' => function($query) {
                $query->withDefault([
                    'name' => 'Deleted Customer',
                    'email' => 'N/A',
                ]);
            }])
            ->latest()
            ->paginate(10);
        }

        return response()->json([
            'success' => true,
            'data' => $orders,
            'message' => 'Orders retrieved successfully.'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'order_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if staff user can create order for this customer
        if (auth()->user()->isStaff()) {
            $customer = Customer::find($request->customer_id);
            if ($customer->created_by != auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to create order for this customer.'
                ], 403);
            }
        }

        $data = $request->all();
        $data['order_number'] = Order::generateOrderNumber();
        
        $order = Order::create($data);

        return response()->json([
            'success' => true,
            'data' => $order,
            'message' => 'Order created successfully.'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with(['customer' => function($query) {
            $query->withDefault([
                'name' => 'Deleted Customer',
                'email' => 'N/A',
            ]);
        }])->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        // Check permissions
        if (auth()->user()->isStaff()) {
            if (!$order->customer || $order->customer->created_by != auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to view this order.'
                ], 403);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $order,
            'message' => 'Order retrieved successfully.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        // Check permissions
        if (auth()->user()->isStaff()) {
            if (!$order->customer || $order->customer->created_by != auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to update this order.'
                ], 403);
            }
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'sometimes|required|exists:customers,id',
            'amount' => 'sometimes|required|numeric|min:0',
            'status' => 'sometimes|required|in:pending,processing,completed,cancelled',
            'order_date' => 'sometimes|required|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if staff user can update order for this customer
        if (auth()->user()->isStaff() && $request->has('customer_id')) {
            $customer = Customer::find($request->customer_id);
            if ($customer->created_by != auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to assign order to this customer.'
                ], 403);
            }
        }

        $order->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $order,
            'message' => 'Order updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        // Check permissions - only admin can delete
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Only administrators can delete orders.'
            ], 403);
        }

        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully.'
        ]);
    }
}