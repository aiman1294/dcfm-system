<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                @if(auth()->user()->role !== 'pending')
                    <a href="/cases/create" style="padding:10px 20px; background:#4f46e5; color:white; border-radius:6px; text-decoration:none;">
    Register a Case
</a>
                @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
