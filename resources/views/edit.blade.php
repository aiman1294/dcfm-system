<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Case
        </h2>
    </x-slot>

    @php
    $user = auth()->user();
    $isAdmin = $user->role === 'admin';
    $isOwner = $case->user_id === $user->id;
    $isAssignedJudge = $user->role === 'judge' && $case->judge_id === $user->id;
@endphp

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow">

         
                <div class="border-b py-2">
                <div>
                <strong>{{ $case->case_title }}</strong>
                </div>
                    
                </div>
                <form method="POST" action="/cases/{{ $case->id }}" class="space-y-4 mt-4">
                    @csrf
                    @method('PUT')
                    @if ($errors->any())
                    <div class="mb-4 text-red-600">
                    <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                    </div>
                    @endif

                     @if($isOwner || $isAdmin)
                      <label class="block text-sm font-medium text-gray-700 mb-1">
                            Case Title
                    </label>
                    <input 
                        name="case_title"
                        value="{{ $case->case_title }}"
                        placeholder="Case title"
                        class="w-full border rounded px-3 py-2"
                    >
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                Case Description
                    </label>
                    <textarea 
                        name="case_description"
                        class="w-full border rounded px-3 py-2 text-gray-900 bg-white"
                        placeholder="Case description"
                    >{{ $case->case_description }}
                        
                    </textarea>

                     <label class="block text-sm font-medium text-gray-700 mb-1">
                            Case Priority
                    </label>
                    <select 
                        name="case_priority"  
                        class="w-full border rounded px-3 py-2" >
                         <option value="" disabled {{  !$case->case_priority ? 'selected' : '' }}>Select priority</option>
                        <option value="low" {{ $case->case_priority === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ $case->case_priority === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ $case->case_priority === 'high' ? 'selected' : '' }}>High</option>
                    </select>

                    @endif

                    @if(auth()->user()->role === 'admin')
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Assign Judge
        </label>

        <select name="judge_id" class="w-full border rounded px-3 py-2">
            <option value="">Select Judge</option>

            @foreach(\App\Models\User::where('role', 'judge')->get() as $judge)
                <option value="{{ $judge->id }}"
                    {{ $case->judge_id == $judge->id ? 'selected' : '' }}>
                    {{ $judge->name }}
                </option>
            @endforeach
        </select>
    </div>
@endif

                    @if($isAssignedJudge)
    <div>
        <label class="block text-sm font-medium text-gray-700">Case Title</label>
        <input value="{{ $case->case_title }}" class="w-full border rounded px-3 py-2 bg-gray-100" disabled>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Description</label>
        <textarea class="w-full border rounded px-3 py-2 bg-gray-100" disabled>
            {{ $case->case_description }}
        </textarea>
    </div>


@endif

                @if(auth()->user()->role === 'judge' || auth()->user()->role === 'admin')
                    <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                            Case Status
                    </label>
                    <select name="case_status" class="w-full border rounded px-3 py-2">
                    <option value="Open" {{ $case->case_status === 'Open' ? 'selected' : '' }}>Open</option>
                    <option value="In Progress" {{ $case->case_status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Closed" {{ $case->case_status === 'Closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                    </div>
                     @endif 
                    
                  <button 
                        type="submit"
                        class="bg-indigo-600 text-black px-4 py-2 rounded hover:bg-indigo-700"
                    >
                        Update
                    </button>
                   

                

                </form>

        </div>
    </div>
</x-app-layout>