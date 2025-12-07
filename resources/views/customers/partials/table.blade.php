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