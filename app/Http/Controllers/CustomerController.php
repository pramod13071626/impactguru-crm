<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $search = $request->input('search');
    
    $customers = Customer::when($search, function ($query, $search) {
        return $query->search($search);
    })
    ->latest()
    ->paginate(10);

    // Check if it's an AJAX request
    if ($request->ajax() || $request->has('ajax')) {
        return response()->json([
            'html' => view('customers.partials.table', compact('customers'))->render()
        ]);
    }

    return view('customers.index', compact('customers', 'search'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
 public function store(StoreCustomerRequest $request)
{
    $data = $request->validated();
    
    // Handle profile image upload
    if ($request->hasFile('profile_image')) {
        $path = $request->file('profile_image')->store('profile_images', 'public');
        $data['profile_image'] = $path;
    }
    
    // Set created_by to current user's ID
    $data['created_by'] = auth()->id();
    
    Customer::create($data);
    
    return redirect()->route('customers.index')
        ->with('success', 'Customer created successfully.');
}
    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $data = $request->validated();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($customer->profile_image) {
                Storage::disk('public')->delete($customer->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('customers', 'public');
        }

        $customer->update($data);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        // Delete profile image if exists
        if ($customer->profile_image) {
            Storage::disk('public')->delete($customer->profile_image);
        }

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

    /**
     * Restore soft deleted customer.
     */
    public function restore($id)
    {
        $customer = Customer::withTrashed()->findOrFail($id);
        $customer->restore();

        return redirect()->route('customers.index')
            ->with('success', 'Customer restored successfully.');
    }

    /**
     * Permanently delete customer.
     */
    public function forceDelete($id)
    {
        $customer = Customer::withTrashed()->findOrFail($id);
        
        // Delete profile image if exists
        if ($customer->profile_image) {
            Storage::disk('public')->delete($customer->profile_image);
        }

        $customer->forceDelete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer permanently deleted.');
    }

    // Add these methods to the CustomerController class

/**
 * Export customers to CSV
 */
public function exportCsv(Request $request)
{
    $fileName = 'customers-' . date('Y-m-d') . '.csv';
    
    // Get customers based on role
    $query = Customer::query();
    
    if (auth()->user()->isStaff()) {
        $query->where('created_by', auth()->id());
    }
    
    $customers = $query->get();
    
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
    ];

    $callback = function() use ($customers) {
        $file = fopen('php://output', 'w');
        
        // Add CSV headers
        fputcsv($file, [
            'ID', 'Name', 'Email', 'Phone', 'Address', 
            'Total Orders', 'Created By', 'Created At'
        ]);
        
        // Add data rows
        foreach ($customers as $customer) {
            fputcsv($file, [
                $customer->id,
                $customer->name,
                $customer->email,
                $customer->phone ?? 'N/A',
                $customer->address ?? 'N/A',
                $customer->orders()->count(),
                $customer->creator->name ?? 'N/A',
                $customer->created_at->format('Y-m-d H:i:s')
            ]);
        }
        
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

/**
 * Export customers to PDF
 */
/**
 * Export customers to PDF
 */
public function exportPdf(Request $request)
{
    // Get customers based on role
    $query = Customer::with('creator')->withCount('orders');
    
    if (auth()->user()->isStaff()) {
        $query->where('created_by', auth()->id());
    }
    
    $customers = $query->get();
    
    // Generate PDF with proper headers
    $pdf = \PDF::loadView('exports.customers-pdf', [
        'customers' => $customers,
        'title' => 'Customers Report',
        'date' => now()->format('F d, Y')
    ]);
    
    // Set paper size and orientation
    $pdf->setPaper('A4', 'landscape');
    
    // Return PDF with proper headers
    return $pdf->download('customers-' . date('Y-m-d') . '.pdf');
}
}