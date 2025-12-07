<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if user is staff - only show their customers
        if (auth()->user()->isStaff()) {
            $customers = Customer::where('created_by', auth()->id())
                ->withCount('orders')
                ->latest()
                ->paginate(10);
        } else {
            // Admin sees all customers
            $customers = Customer::withCount('orders')
                ->latest()
                ->paginate(10);
        }

        return response()->json([
            'success' => true,
            'data' => $customers,
            'message' => 'Customers retrieved successfully.'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $data['profile_image'] = $path;
        }
        
        // Set created_by for staff users
        if (auth()->user()->isStaff()) {
            $data['created_by'] = auth()->id();
        }

        $customer = Customer::create($data);

        return response()->json([
            'success' => true,
            'data' => $customer,
            'message' => 'Customer created successfully.'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customer = Customer::with(['orders', 'creator'])->find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.'
            ], 404);
        }

        // Check if staff user can view this customer
        if (auth()->user()->isStaff() && $customer->created_by != auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to view this customer.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $customer,
            'message' => 'Customer retrieved successfully.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.'
            ], 404);
        }

        // Check permissions
        if (auth()->user()->isStaff() && $customer->created_by != auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this customer.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:customers,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $data['profile_image'] = $path;
            
            // Delete old image if exists
            if ($customer->profile_image) {
                \Storage::disk('public')->delete($customer->profile_image);
            }
        }

        $customer->update($data);

        return response()->json([
            'success' => true,
            'data' => $customer,
            'message' => 'Customer updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.'
            ], 404);
        }

        // Check permissions - only admin can delete
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Only administrators can delete customers.'
            ], 403);
        }

        // Delete profile image if exists
        if ($customer->profile_image) {
            \Storage::disk('public')->delete($customer->profile_image);
        }

        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully.'
        ]);
    }
}