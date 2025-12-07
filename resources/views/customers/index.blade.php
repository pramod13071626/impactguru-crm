<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Customer Management') }}
            </h2>
            <a href="{{ route('customers.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Add New Customer
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search Bar -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form action="{{ route('customers.index') }}" method="GET" class="flex items-center">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search customers by name or email..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('customers.index') }}" class="ml-2 text-gray-600 hover:text-gray-900">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Customers Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($customers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profile</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($customers as $customer)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <img src="{{ $customer->profile_image_url }}" alt="{{ $customer->name }}" 
                                                 class="h-10 w-10 rounded-full object-cover">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $customer->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $customer->phone }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('customers.show', $customer) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                            <a href="{{ route('customers.edit', $customer) }}" class="text-green-600 hover:text-green-900 mr-3">Edit</a>
                                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $customers->links() }}
                        </div>

                     <!-- Statistics with Export Button -->
<div class="mt-8 pt-8 border-t border-gray-200">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Customer Statistics</h3>
        
        <!-- Export Dropdown -->
        <div class="relative inline-block text-left" id="customer-export-container">
            <div>
                <button type="button" 
                        class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" 
                        id="customer-export-button">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                    Export Customers
                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            
            <!-- Dropdown menu -->
            <div class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50" 
                 id="customer-export-dropdown"
                 style="display: none;">
                <div class="py-1">
                    <!-- CSV Export -->
                    <a href="{{ url('/customers/export/csv?' . http_build_query(request()->query())) }}" 
                       class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                        <svg class="w-5 h-5 mr-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-medium text-gray-900">Export as CSV</p>
                            <p class="text-xs text-gray-500">Download as CSV file</p>
                        </div>
                    </a>
                    
                    <!-- PDF Export -->
                    <a href="{{ url('/customers/export/pdf?' . http_build_query(request()->query())) }}" 
                       class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 border-t border-gray-100">
                        <svg class="w-5 h-5 mr-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-medium text-gray-900">Export as PDF</p>
                            <p class="text-xs text-gray-500">Download as PDF file</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-blue-50 p-4 rounded-lg">
            <p class="text-sm font-medium text-blue-600">Total Customers</p>
            <p class="text-2xl font-bold text-gray-900">{{ $customers->total() }}</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
            <p class="text-sm font-medium text-green-600">With Orders</p>
            <p class="text-2xl font-bold text-gray-900">
                {{-- Use a different approach to count customers with orders --}}
                @php
                    // This counts customers with orders on the current page only
                    $withOrders = 0;
                    foreach($customers as $customer) {
                        if($customer->orders_count > 0) {
                            $withOrders++;
                        }
                    }
                    echo $withOrders;
                @endphp
            </p>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg">
            <p class="text-sm font-medium text-yellow-600">Active</p>
            <p class="text-2xl font-bold text-gray-900">{{ $customers->count() }}</p>
        </div>
        <div class="bg-purple-50 p-4 rounded-lg">
            <p class="text-sm font-medium text-purple-600">This Page</p>
            <p class="text-2xl font-bold text-gray-900">{{ $customers->count() }} customers</p>
        </div>
    </div>
</div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No customers found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new customer.</p>
                            <div class="mt-6">
                                <a href="{{ route('customers.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Add New Customer
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Export Dropdown -->
    <script>
    // Wait for page to load
    document.addEventListener('DOMContentLoaded', function() {
        // Customer Export Dropdown
        const customerExportButton = document.getElementById('customer-export-button');
        const customerExportDropdown = document.getElementById('customer-export-dropdown');
        
        if (customerExportButton && customerExportDropdown) {
            // Toggle dropdown when button is clicked
            customerExportButton.addEventListener('click', function(e) {
                e.stopPropagation();
                if (customerExportDropdown.style.display === 'block') {
                    customerExportDropdown.style.display = 'none';
                } else {
                    customerExportDropdown.style.display = 'block';
                }
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!customerExportButton.contains(e.target) && !customerExportDropdown.contains(e.target)) {
                    customerExportDropdown.style.display = 'none';
                }
            });
            
            // Close dropdown with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    customerExportDropdown.style.display = 'none';
                }
            });
        }
        
        // Search functionality
        const searchInput = document.querySelector('input[name="search"]');
        const customerTable = document.querySelector('tbody');
        
        if (searchInput) {
            let debounceTimer;
            
            searchInput.addEventListener('input', function(e) {
                clearTimeout(debounceTimer);
                
                debounceTimer = setTimeout(() => {
                    const searchTerm = e.target.value;
                    
                    if (searchTerm.length >= 2 || searchTerm.length === 0) {
                        fetch(`{{ route('customers.index') }}?search=${encodeURIComponent(searchTerm)}&ajax=1`)
                            .then(response => response.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const newTableBody = doc.querySelector('tbody');
                                
                                if (newTableBody) {
                                    customerTable.innerHTML = newTableBody.innerHTML;
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                }, 500); // 500ms debounce
            });
        }
    });
    </script>

    <style>
        /* Ensure dropdown is above other elements */
        #customer-export-dropdown {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        #customer-export-dropdown a {
            cursor: pointer;
            text-decoration: none;
            display: block;
        }
        
        #customer-export-dropdown a:hover {
            background-color: #f9fafb;
        }
        
        .z-50 {
            z-index: 50;
        }
    </style>
</x-app-layout>