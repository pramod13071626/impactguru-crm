<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('orders.edit', $order) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit
                </a>
                <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to Orders
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Left Column - Order Details -->
                        <div class="md:col-span-2">
                            <div class="mb-8">
                                <div class="flex justify-between items-center mb-4">
                                    <h1 class="text-2xl font-bold text-gray-900">Order #{{ $order->order_number }}</h1>
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $order->status_badge }}">
                                        {{ $order->status_label }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h3 class="text-sm font-medium text-gray-500 mb-2">Order Information</h3>
                                        <div class="space-y-2">
                                            <div>
                                                <p class="text-xs text-gray-600">Order Date</p>
                                                <p class="font-medium">{{ $order->order_date->format('F d, Y') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-600">Amount</p>
                                                <p class="text-2xl font-bold text-green-600">${{ number_format($order->amount, 2) }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-600">Created</p>
                                                <p class="font-medium">{{ $order->created_at->format('F d, Y h:i A') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-600">Last Updated</p>
                                                <p class="font-medium">{{ $order->updated_at->format('F d, Y h:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h3 class="text-sm font-medium text-gray-500 mb-2">Customer Information</h3>
                                        <div class="flex items-center">
                                            <img class="h-12 w-12 rounded-full mr-3" src="{{ $order->customer->profile_image_url }}" alt="{{ $order->customer->name }}">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $order->customer->name }}</p>
                                                <p class="text-sm text-gray-600">{{ $order->customer->email }}</p>
                                                <p class="text-sm text-gray-600">{{ $order->customer->phone }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('customers.show', $order->customer) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                                View Customer Profile →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            @if($order->notes)
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Order Notes</h3>
                                <div class="bg-yellow-50 p-4 rounded-lg">
                                    <p class="text-gray-700">{{ $order->notes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Right Column - Actions & Stats -->
                        <div class="md:col-span-1">
                            <!-- Actions -->
                            <div class="bg-gray-50 p-6 rounded-lg mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                                <div class="space-y-3">
                                    <a href="{{ route('orders.edit', $order) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit Order
                                    </a>
                                    
                                    <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete Order
                                        </button>
                                    </form>
                                    
                                    <a href="{{ route('customers.show', $order->customer) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        View Customer
                                    </a>
                                </div>
                            </div>

                            <!-- Status History -->
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Timeline</h3>
                                <div class="space-y-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">Order Created</p>
                                            <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                                <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">Current Status</p>
                                            <p class="text-sm font-semibold {{ $order->status == 'completed' ? 'text-green-600' : ($order->status == 'cancelled' ? 'text-red-600' : 'text-yellow-600') }}">
                                                {{ $order->status_label }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>