<x-app-layout>
    <x-slot name="header">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Staff Dashboard
            </h2>
            <span class="badge badge-success">
                <i class="fas fa-user-tie"></i> Staff Account
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="card border-left-primary shadow mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="text-primary mb-1">Welcome back, {{ Auth::user()->name }}!</h4>
                            <p class="mb-0">Here's an overview of your assigned customers and their orders.</p>
                            <p class="text-muted small mt-2">
                                <i class="fas fa-info-circle"></i> You have access to manage your assigned customers and their orders.
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <i class="fas fa-user-tie fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row">
                <!-- My Customers -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        My Customers</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $myCustomers }}</div>
                                    <div class="mt-2 mb-0 text-muted text-xs">
                                        <a href="{{ route('staff.my.customers') }}" class="text-info">Manage Customers</a>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- My Orders -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        My Orders</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $myOrders }}</div>
                                    <div class="mt-2 mb-0 text-muted text-xs">
                                        <span class="text-warning mr-2">
                                            <i class="fas fa-clock"></i> {{ $pendingOrders }} pending
                                        </span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- My Revenue -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        My Revenue</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($myRevenue, 2) }}</div>
                                    <div class="mt-2 mb-0 text-muted text-xs">
                                        <span>Generated from your customers</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Average Order Value -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Avg. Order Value</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        ${{ $myOrders > 0 ? number_format($myRevenue / $myOrders, 2) : '0.00' }}
                                    </div>
                                    <div class="mt-2 mb-0 text-muted text-xs">
                                        <span>Per order average</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-bar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <!-- Recent Customers -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">My Recent Customers</h6>
                        </div>
                        <div class="card-body">
                            @if($recentCustomers->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($recentCustomers as $customer)
                                <div class="list-group-item d-flex align-items-center">
                                    <img class="rounded-circle mr-3" src="{{ $customer->profile_image_url ?? asset('images/default-avatar.png') }}" alt="{{ $customer->name }}" width="40" height="40">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $customer->name }}</h6>
                                        <small class="text-muted">{{ $customer->email }}</small>
                                    </div>
                                    <div class="text-right">
                                        <span class="badge badge-info">{{ $customer->orders_count ?? 0 }} orders</span>
                                        <br>
                                        <small class="text-muted">{{ $customer->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                                <p class="text-muted">No customers assigned yet</p>
                                <a href="{{ route('customers.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add First Customer
                                </a>
                            </div>
                            @endif
                            <div class="mt-3">
                                <a href="{{ route('customers.index') }}" class="btn btn-outline-primary btn-block">View All Customers</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Orders from My Customers</h6>
                        </div>
                        <div class="card-body">
                            @if($recentOrders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                   <tbody>
    @foreach($recentOrders as $order)
    <tr>
        <td><small>{{ $order->order_number }}</small></td>
        <td><small>{{ $order->customer->name }}</small></td>
        <td><strong>${{ number_format($order->amount, 2) }}</strong></td>
        <td>
            @php
                // Get status with fallback
                $status = $order->status ?? 'unknown';
                $badgeColor = match($status) {
                    'completed' => 'success',
                    'pending' => 'warning',
                    'processing' => 'info',
                    'cancelled' => 'danger',
                    default => 'secondary'
                };
            @endphp
            <span class="badge badge-{{ $badgeColor }}">
                {{ ucfirst($status) }}
            </span>
        </td>
    </tr>
    @endforeach
</tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="fas fa-shopping-cart fa-3x text-gray-300 mb-3"></i>
                                <p class="text-muted">No orders from your customers yet</p>
                                <a href="{{ route('orders.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Create First Order
                                </a>
                            </div>
                            @endif
                            <div class="mt-3">
                                <a href="{{ route('orders.index') }}" class="btn btn-outline-success btn-block">View All Orders</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('customers.create') }}" class="btn btn-primary btn-block py-3">
                                        <i class="fas fa-user-plus fa-2x mb-2"></i><br>
                                        Add Customer
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('orders.create') }}" class="btn btn-success btn-block py-3">
                                        <i class="fas fa-cart-plus fa-2x mb-2"></i><br>
                                        Create Order
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('customers.index') }}" class="btn btn-info btn-block py-3">
                                        <i class="fas fa-users fa-2x mb-2"></i><br>
                                        View Customers
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('orders.index') }}" class="btn btn-warning btn-block py-3">
                                        <i class="fas fa-clipboard-list fa-2x mb-2"></i><br>
                                        Manage Orders
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Staff Guidelines -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-left-info shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">
                                <i class="fas fa-info-circle"></i> Staff Guidelines
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="font-weight-bold text-primary">What You Can Do:</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> Add new customers</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> Edit customer information</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> Create and manage orders</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> Update order status</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> View your customer statistics</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="font-weight-bold text-danger">Restrictions:</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-times-circle text-danger mr-2"></i> Cannot delete customers/orders</li>
                                        <li class="mb-2"><i class="fas fa-times-circle text-danger mr-2"></i> Cannot manage other staff's customers</li>
                                        <li class="mb-2"><i class="fas fa-times-circle text-danger mr-2"></i> No access to user management</li>
                                        <li class="mb-2"><i class="fas fa-times-circle text-danger mr-2"></i> Cannot view system-wide statistics</li>
                                        <li class="mb-2"><i class="fas fa-times-circle text-danger mr-2"></i> No access to admin settings</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>