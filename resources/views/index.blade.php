
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Cases') }}
        </h2>
    </x-slot>
<h1>All Cases</h1>

@foreach($cases as $case)
    <p>{{ $case->case_title }}</p>
@endforeach
    </x-app-layout>