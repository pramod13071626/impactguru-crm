@extends('layouts.app')

@section('title', 'Server Error')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center px-4">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-gray-800 mb-4">500</h1>
        <h2 class="text-3xl font-semibold text-gray-700 mb-6">Internal Server Error</h2>
        <p class="text-gray-600 mb-8 max-w-md">
            Something went wrong on our end. We're working to fix the issue.
            Please try again later.
        </p>
        <div class="space-x-4">
            <a href="{{ url('/') }}" 
               class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                Go to Homepage
            </a>
            <button onclick="location.reload()" 
               class="inline-block border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition duration-300">
                Try Again
            </button>
        </div>
        @if(app()->environment('local'))
        <div class="mt-8 p-4 bg-gray-100 rounded-lg text-left max-w-2xl mx-auto">
            <p class="text-sm font-semibold text-gray-700 mb-2">Error Details (Development Only):</p>
            <pre class="text-xs text-gray-600 overflow-auto">{{ $exception->getMessage() }}</pre>
        </div>
        @endif
    </div>
</div>
@endsection