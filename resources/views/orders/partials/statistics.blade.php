<div class="order-statistics">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Statistics</h3>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-blue-50 p-4 rounded-lg">
            <p class="text-sm font-medium text-blue-600">Total Orders</p>
            <p class="text-2xl font-bold text-gray-900">{{ $orders->total() }}</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
            <p class="text-sm font-medium text-green-600">Total Value</p>
            <p class="text-2xl font-bold text-gray-900">${{ number_format($orders->sum('amount'), 2) }}</p>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg">
            <p class="text-sm font-medium text-yellow-600">Avg. Order</p>
            <p class="text-2xl font-bold text-gray-900">${{ number_format($orders->avg('amount'), 2) }}</p>
        </div>
        <div class="bg-purple-50 p-4 rounded-lg">
            <p class="text-sm font-medium text-purple-600">This Page</p>
            <p class="text-2xl font-bold text-gray-900">{{ $orders->count() }} orders</p>
        </div>
    </div>
</div>