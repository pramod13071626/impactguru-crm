@foreach($orders as $order)
<tr>
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
        {{ $order->order_number }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-10 w-10">
                <img class="h-10 w-10 rounded-full" src="{{ $order->customer->profile_image_url }}" alt="{{ $order->customer->name }}">
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">{{ $order->customer->name }}</div>
                <div class="text-sm text-gray-500">{{ $order->customer->email }}</div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $order->order_date->format('M d, Y') }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        <span class="font-semibold">${{ number_format($order->amount, 2) }}</span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $order->status_badge }}">
            {{ $order->status_label }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
        <div class="flex space-x-2">
            <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </a>
            <a href="{{ route('orders.edit', $order) }}" class="text-green-600 hover:text-green-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </a>
            <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this order?')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </form>
        </div>
    </td>
</tr>
@endforeach