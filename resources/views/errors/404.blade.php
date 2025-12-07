@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center px-4">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-gray-800 mb-4">404</h1>
        <h2 class="text-3xl font-semibold text-gray-700 mb-6">Page Not Found</h2>
        <p class="text-gray-600 mb-8 max-w-md">
            The page you are looking for might have been removed, had its name changed, 
            or is temporarily unavailable.
        </p>
        <div class="space-x-4">
            <a href="{{ url('/') }}" 
               class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                Go to Homepage
            </a>
            <a href="javascript:history.back()" 
               class="inline-block border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition duration-300">
                Go Back
            </a>
        </div>
    </div>
</div>
@endsection