<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Case
        </h2>
    </x-slot>

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

                    <input 
                        name="case_title"
                        value="{{ $case->case_title }}"
                        placeholder="Case title"
                        class="w-full border rounded px-3 py-2"
                    >
                    <textarea 
                        name="case_description"
                        class="w-full border rounded px-3 py-2 text-gray-900 bg-white"
                        placeholder="Case description"
                    >{{ $case->case_description }}
                        
                    </textarea>
                    <select 
                        name="case_priority"  
                        class="w-full border rounded px-3 py-2" >
                         <option value="" disabled {{  !$case->case_priority ? 'selected' : '' }}>Select priority</option>
                        <option value="low" {{ $case->case_priority === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ $case->case_priority === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ $case->case_priority === 'high' ? 'selected' : '' }}>High</option>
                    </select>
                    {{-- <select name="case_status" class="w-full border rounded px-3 py-2">
                        <option value="Open" {{ $case->case_status == 'Open' ? 'selected' : '' }}>Open</option>
                        <option value="In Progress" {{ $case->case_status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Closed" {{ $case->case_status == 'Closed' ? 'selected' : '' }}>Closed</option>
                    </select> --}}

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