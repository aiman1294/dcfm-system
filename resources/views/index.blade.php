<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Cases
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow">

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