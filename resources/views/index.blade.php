<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(auth()->user()->role === 'judge')
        My Assigned Cases
    @elseif(auth()->user()->role === 'lawyer')
        My Filed Cases
    @else
        All Cases
    @endif
        </h2>
    </x-slot>


    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow">

        <form method="GET" action="/cases" class="mb-4 flex gap-4">

        <input 
    type="text" 
    name="search" 
    value="{{ request('search') }}"
    placeholder="Search cases..."
    class="border px-3 py-1 rounded w-48"
/>
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

    <select name="sort" class="border px-2 py-1">
    <option value="">Sort By</option>
    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest</option>
    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
    <option value="priority" {{ request('sort') == 'priority' ? 'selected' : '' }}>Priority</option>
    </select>

    <button type="submit" class="bg-blue-500 text-black px-3 py-1 rounded">
        Filter
    </button>
    @if(request()->hasAny(['priority','status','sort']))
    <a href="/cases" class="bg-gray-300 text-black px-3 py-1 rounded hover:bg-gray-400">
        Reset
    </a>
    @endif

    
    
    

</form>
        
            @foreach($cases as $case)

            <div class="border-b py-3 space-y-1">

    <strong>{{ $case->case_title }}</strong>

    <div>{{ $case->case_description }}</div>
    <div>Priority: {{ $case->case_priority }}</div>
    <div>
    Status:
    <span class="px-2 py-1 rounded text-sm
        @if($case->case_status === 'Open') bg-green-100 text-green-700
        @elseif($case->case_status === 'In Progress') bg-yellow-100 text-yellow-700
        @elseif($case->case_status === 'Closed') bg-gray-200 text-gray-700
        @endif
    ">
        {{ $case->case_status }}
    </span>
</div>
<div>
    Judge: 
    @if($case->judge)
        <span class="text-indigo-600 font-medium">
            {{ $case->judge->name }}
        </span>
    @else
        <span class="text-gray-400 italic">Not assigned</span>
    @endif
</div>

    <a href="/cases/{{ $case->id }}" class="text-blue-500 hover:underline">
        Read More
    </a>

    {{-- @if($case->user_id === auth()->id() || auth()->user()->role === 'admin')
        <div class="flex gap-4 mt-2 items-center">
            <a href="/cases/{{ $case->id }}/edit" class="text-blue-600">Edit</a>

            <form method="POST" action="/cases/{{ $case->id }}">
                @csrf
                @method('DELETE')
                
                <button type="submit" class="text-red-500">Delete</button>
                
            </form>
        </div>
    @endif --}}
    @php
    $user = auth()->user();
    $isOwner = $case->user_id === $user->id;
    $isAdmin = $user->role === 'admin';
    $isAssignedJudge = $user->role === 'judge' && $case->judge_id === $user->id;
@endphp

@if($isOwner || $isAdmin || $isAssignedJudge)
    <div class="flex gap-4 mt-2 items-center">
        <a href="/cases/{{ $case->id }}/edit" class="text-blue-600">Edit</a>

        @if($isOwner || $isAdmin)
            <form method="POST" action="/cases/{{ $case->id }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500">Delete</button>
            </form>
        @endif
    </div>
@endif

</div>
                
            @endforeach

            {{-- {{ $cases->links() }}
              @if($cases->isEmpty())
                    <p class="text-gray-500">No cases match your filters.</p>
                @endif --}}

                {{ $cases->links() }}

@if($cases->isEmpty())
    @php
        $hasFilters = request()->hasAny(['search','priority','status','sort']);
        $role = auth()->user()->role;
    @endphp

    <p class="text-gray-500">
        @if($hasFilters)
            No cases match your filters.
        @elseif($role === 'judge')
            No cases assigned to you yet.
        @elseif($role === 'lawyer')
            You haven't filed any cases yet.
        @else
            No cases found.
        @endif
    </p>
@endif
   

            @if(session('success'))
    <p class="text-green-600">{{ session('success') }}</p>
@endif

        </div>
    </div>
</x-app-layout>