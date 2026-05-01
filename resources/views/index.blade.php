<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Cases
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow">

        <form method="GET" action="/cases" class="mb-4 flex gap-4">

    <select name="priority" class="border px-2 py-1">
        <option value="" {{ request('priority') == '' ? 'selected' : '' }}>All Priorities</option>
        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
    </select>

    <select name="status" class="border px-2 py-1">
        <option value="" {{ request('status') == '' ? 'selected' : '' }}>All Status</option>
        <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
        <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
        <option value="Closed" {{ request('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
    </select>

    <button type="submit" class="bg-blue-500 text-black px-3 py-1 rounded">
        Filter
    </button>
    
    @if($cases->isEmpty())
    <p class="text-gray-500">No cases match your filters.</p>
    
@endif

</form>
        
            @foreach($cases as $case)

            <div class="border-b py-3 space-y-1">

    <strong>{{ $case->case_title }}</strong>

    <div>{{ $case->case_description }}</div>
    <div>Priority: {{ $case->case_priority }}</div>
    <div>Status: {{ $case->case_status }}</div>

    <a href="/cases/{{ $case->id }}" class="text-blue-500 hover:underline">
        Read More
    </a>

    @if($case->user_id === auth()->id() || auth()->user()->role === 'admin')
        <div class="flex gap-4 mt-2 items-center">
            <a href="/cases/{{ $case->id }}/edit" class="text-blue-600">Edit</a>

            <form method="POST" action="/cases/{{ $case->id }}">
                @csrf
                @method('DELETE')
                
                <button type="submit" class="text-red-500">Delete</button>
                
            </form>
        </div>
    @endif

</div>
                
            @endforeach

            @if(session('success'))
    <p class="text-green-600">{{ session('success') }}</p>
@endif

        </div>
    </div>
</x-app-layout>