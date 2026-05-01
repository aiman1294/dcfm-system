<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Case Details
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow space-y-4">

         <div class="flex justify-between items-center" >
            <h1 class="text-2xl font-bold text-gray-900">
                {{ $case->case_title }}
            </h1>
            <span class="text-xs text-gray-400">
            Case #{{ $case->id }}
            </span>
        </div>
        
            <div class="border-t pt-4">
                <p class="text-gray-700">
                {{ $case->case_description ?? 'No description provided.' }}
                </p>
            </div>

            
            <div class="border-t pt-4 grid grid-cols-2 gap-4 text-sm text-gray-600">
                <div>
                    <span class="font-semibold">Priority:</span>
                    {{ ucfirst($case->case_priority) }}
                </div>

                <div>
                    <span class="font-semibold">Status:</span>
                    <span class="px-2 py-1 rounded 
                        {{ $case->case_status === 'Open' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $case->case_status === 'In Progress' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $case->case_status === 'Closed' ? 'bg-gray-200 text-gray-700' : '' }}">
                        {{ $case->case_status }}
                    </span>
                </div>

                <div>
                    <span class="font-semibold">Filed On:</span>
                    {{ $case->created_at->format('d M Y') }}
                </div>

                <div>
                    <span class="font-semibold">Last Updated:</span>
                    {{ $case->updated_at->format('d M Y') }}
                </div>
            </div>

            
            @if($case->user_id === auth()->id() || auth()->user()->role === 'admin')
                <div class="flex gap-4 pt-4 border-t">

                    <a href="/cases/{{ $case->id }}/edit"
                       class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Edit
                    </a>

                    <form method="POST" action="/cases/{{ $case->id }}">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Delete
                        </button>
                    </form>

                </div>
            @endif

            
            <div class="pt-4">
                <a href="/cases" class="text-blue-500 hover:underline">
                    ← Back to Cases
                </a>
            </div>

        </div>
    </div>
</x-app-layout>