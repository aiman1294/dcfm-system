<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Register Case
        </h2>
    </x-slot>

    <div class="py-6">
        <form method="POST" action="/cases">
            @csrf

            <input name="case_title" placeholder="Case title">
            <button type="submit">Save</button>
        </form>
    </div>
</x-app-layout>