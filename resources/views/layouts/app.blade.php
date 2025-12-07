<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Notification Bell -->
<div class="relative">
    <button id="notificationDropdown" class="p-2 text-gray-600 hover:text-gray-900 focus:outline-none">
        <i class="fas fa-bell text-xl"></i>
        @auth
            @if(auth()->user()->unreadNotifications->count() > 0)
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            @endif
        @endauth
    </button>
    
    <!-- Dropdown -->
    <div id="notificationPanel" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border py-2 z-50">
        <div class="px-4 py-2 border-b">
            <h3 class="font-semibold text-gray-900">Notifications</h3>
        </div>
        
        @auth
            <div class="max-h-96 overflow-y-auto">
                @forelse(auth()->user()->notifications->take(10) as $notification)
                    <a href="{{ $notification->data['url'] ?? '#' }}" 
                       class="block px-4 py-3 hover:bg-gray-50 {{ $notification->read_at ? '' : 'bg-blue-50' }} border-b">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="{{ $notification->data['icon'] ?? 'fas fa-bell' }} text-blue-500 mt-1"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-900">{{ $notification->data['message'] ?? 'Notification' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="px-4 py-8 text-center">
                        <p class="text-sm text-gray-500">No notifications</p>
                    </div>
                @endforelse
            </div>
            
            @if(auth()->user()->notifications->count() > 0)
                <div class="px-4 py-2 border-t">
                    <a href="{{ route('notifications.index') }}" class="text-sm text-blue-600 hover:text-blue-900">
                        View all notifications
                    </a>
                </div>
            @endif
        @endauth
    </div>
</div>

<script>
    // Toggle notification dropdown
    document.getElementById('notificationDropdown').addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('notificationPanel').classList.toggle('hidden');
    });

    // Close when clicking outside
    document.addEventListener('click', function() {
        document.getElementById('notificationPanel').classList.add('hidden');
    });
</script>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
