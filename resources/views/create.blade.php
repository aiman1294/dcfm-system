<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Register Case
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow">

            <form method="POST" action="/cases" class="space-y-4">
                @csrf

                <input 
                    name="case_title"
                    placeholder="Case title"
                    class="w-full border rounded px-3 py-2"
                >
                <input 
                    name="case_description"
                    placeholder="Case description"
                    class="w-full border rounded px-3 py-2"     
                    >
                <select 
                    name="case_priority"  
                    class="w-full border rounded px-3 py-2" >
                     <option value="" disabled selected>Select priority</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>

                <button 
                    type="submit"
                    class="bg-indigo-600 text-black px-4 py-2 rounded hover:bg-indigo-700"
                >
                    Save
                </button>
            </form>

        </div>
    </div>
</x-app-layout>