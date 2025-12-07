<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Admin Dashboard
                </h2>
                <p class="text-sm text-gray-600 mt-1">System overview and management</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-900 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-users mr-2"></i> Manage Users
                </a>
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-home mr-2"></i> Main Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Banner -->
            <div class="mb-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row items-center justify-between">
                        <div class="text-black">
                            <h1 class="text-2xl md:text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                            <p class="text-blue-100 mb-4">You're managing the ImpactGuru CRM System as an administrator.</p>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    <span>{{ now()->format('l, F j, Y') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-2"></i>
                                    <span>{{ now()->format('h:i A') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-red">{{ $totalUsers }}</div>
                                    <div class="text-blue-100 text-sm">Total Users</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats - OPTIMIZED FOR LAPTOPS -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Customers -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Customers</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalCustomers ?? 0 }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-green-500 text-sm font-medium">
                                        <i class="fas fa-arrow-up mr-1"></i> {{ $weeklyCustomers ?? 0 }} this week
                                    </span>
                                </div>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-users text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Orders</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalOrders ?? 0 }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-green-500 text-sm font-medium">
                                        <i class="fas fa-arrow-up mr-1"></i> {{ $weeklyOrders ?? 0 }} this week
                                    </span>
                                </div>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Revenue</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">${{ number_format($totalRevenue ?? 0, 2) }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-green-500 text-sm font-medium">
                                        <i class="fas fa-arrow-up mr-1"></i> ${{ number_format($weeklyRevenue ?? 0, 2) }} this week
                                    </span>
                                </div>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Users -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">System Users</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalUsers ?? 0 }}</p>
                                <div class="flex items-center space-x-4 mt-2">
                                    <span class="text-sm text-red-600">
                                        <i class="fas fa-user-shield mr-1"></i> {{ $adminCount ?? 0 }} Admin
                                    </span>
                                    <span class="text-sm text-blue-600">
                                        <i class="fas fa-user-tie mr-1"></i> {{ $staffCount ?? 0 }} Staff
                                    </span>
                                </div>
                            </div>
                            <div class="bg-orange-100 p-3 rounded-full">
                                <i class="fas fa-user-cog text-orange-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid - OPTIMIZED FOR LAPTOPS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Recent Orders -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Recent Orders</h3>
                                <a href="{{ route('orders.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    View All <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            @if(isset($recentOrders) && $recentOrders->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentOrders as $order)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-receipt text-blue-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">{{ $order->order_number }}</p>
                                            <p class="text-sm text-gray-500">{{ $order->customer->name ?? 'Customer Deleted' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-gray-900">${{ number_format($order->amount, 2) }}</p>
                                        @php
                                            $badgeColor = match($order->status) {
                                                'completed' => 'bg-green-100 text-green-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'processing' => 'bg-blue-100 text-blue-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $badgeColor }}">
                                            <i class="fas fa-circle text-[10px] mr-1"></i>
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-8">
                                <div class="text-gray-400 mb-4">
                                    <i class="fas fa-shopping-cart fa-3x"></i>
                                </div>
                                <p class="text-gray-500">No orders yet</p>
                                <a href="{{ route('orders.create') }}" class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Create First Order
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Customers -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Recent Customers</h3>
                                <a href="{{ route('customers.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    View All <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            @if(isset($recentCustomers) && $recentCustomers->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($recentCustomers as $customer)
                                <div class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <img class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-sm" 
                                             src="{{ $customer->profile_image_url ?? asset('images/default-avatar.png') }}" 
                                             alt="{{ $customer->name }}">
                                        <div class="ml-4">
                                            <p class="text-sm font-semibold text-gray-900">{{ $customer->name }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ $customer->email }}</p>
                                            <div class="flex items-center mt-1">
                                                <span class="text-xs text-gray-500">
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    {{ $customer->created_at->diffForHumans() }}
                                                </span>
                                                <span class="mx-2 text-gray-300">•</span>
                                                <span class="text-xs text-blue-600 font-medium">
                                                    <i class="fas fa-shopping-cart mr-1"></i>
                                                    {{ $customer->orders_count ?? 0 }} orders
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-8">
                                <div class="text-gray-400 mb-4">
                                    <i class="fas fa-users fa-3x"></i>
                                </div>
                                <p class="text-gray-500">No customers yet</p>
                                <a href="{{ route('customers.create') }}" class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Add First Customer
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- System Status -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">System Status</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-shield-alt text-green-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Authentication</p>
                                            <p class="text-xs text-gray-500">Active & Secure</p>
                                        </div>
                                    </div>
                                    <span class="text-green-600">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-users-cog text-blue-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Role Management</p>
                                            <p class="text-xs text-gray-500">RBAC Enabled</p>
                                        </div>
                                    </div>
                                    <span class="text-green-600">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-database text-purple-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Database</p>
                                            <p class="text-xs text-gray-500">Connected & Healthy</p>
                                        </div>
                                    </div>
                                    <span class="text-green-600">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-server text-orange-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Laravel {{ app()->version() }}</p>
                                            <p class="text-xs text-gray-500">Framework Version</p>
                                        </div>
                                    </div>
                                    <span class="text-green-600">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <a href="{{ route('customers.create') }}" 
                                   class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200 group">
                                    <div class="h-8 w-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors duration-200">
                                        <i class="fas fa-user-plus text-blue-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Add New Customer</p>
                                        <p class="text-xs text-gray-500">Create customer profile</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </a>

                                <a href="{{ route('orders.create') }}" 
                                   class="flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-200 group">
                                    <div class="h-8 w-8 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors duration-200">
                                        <i class="fas fa-cart-plus text-green-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Create New Order</p>
                                        <p class="text-xs text-gray-500">Process customer order</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </a>

                                <a href="{{ route('admin.users') }}" 
                                   class="flex items-center p-3 bg-red-50 hover:bg-red-100 rounded-lg transition-colors duration-200 group">
                                    <div class="h-8 w-8 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 transition-colors duration-200">
                                        <i class="fas fa-user-cog text-red-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Manage Users</p>
                                        <p class="text-xs text-gray-500">Admin & Staff accounts</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </a>

                                <a href="{{ route('admin.statistics') }}" 
                                   class="flex items-center p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors duration-200 group">
                                    <div class="h-8 w-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-200 transition-colors duration-200">
                                        <i class="fas fa-chart-line text-purple-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">View Statistics</p>
                                        <p class="text-xs text-gray-500">Advanced analytics</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Order Status Distribution -->
                    @if(isset($orderStatuses))
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Order Status</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($orderStatuses as $status => $count)
                                @php
                                    $statusConfig = match($status) {
                                        'pending' => ['color' => 'yellow', 'icon' => 'clock'],
                                        'processing' => ['color' => 'blue', 'icon' => 'sync'],
                                        'completed' => ['color' => 'green', 'icon' => 'check-circle'],
                                        'cancelled' => ['color' => 'red', 'icon' => 'times-circle'],
                                        default => ['color' => 'gray', 'icon' => 'question-circle']
                                    };
                                @endphp
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 bg-{{ $statusConfig['color'] }}-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-{{ $statusConfig['icon'] }} text-{{ $statusConfig['color'] }}-600"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 capitalize">{{ $status }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-sm font-bold text-gray-900 mr-2">{{ $count }}</span>
                                        <div class="h-2 w-16 bg-gray-200 rounded-full overflow-hidden">
                                            @php
                                                $total = array_sum($orderStatuses);
                                                $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                                            @endphp
                                            <div class="h-full bg-{{ $statusConfig['color'] }}-500 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Font Awesome for icons -->
    @push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @endpush
</x-app-layout> 