<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Cases
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow">

            @foreach($cases as $case)
                <div class="border-b py-2">
                    {{ $case->case_title }}
                </div>
            @endforeach
            
            @if(session('success'))
    <p class="text-green-600">{{ session('success') }}</p>
@endif

        </div>
    </div>
</x-app-layout>