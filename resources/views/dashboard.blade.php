<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                @if(auth()->user()->role !== 'pending' &&  auth()->user()->role !== 'judge')
                
                    <a href="/cases/create" style="padding:10px 20px; background:#4f46e5; color:white; border-radius:6px; text-decoration:none;">
    Register a Case
</a>

                @endif

                 {{-- Recent Activity --}}
                    <div class="bg-white rounded-lg shadow p-6 mt-6">

                        <h2 class="text-xl font-semibold mb-4">
                            Recent Activity
                        </h2>

                        <p class="text-sm text-gray-500 mb-4">
    Showing activity from the last 7 days.
</p>

                        <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2">

                            @forelse($logs as $log)

                                <div class="border-l-4 border-indigo-500 pl-4 py-3 bg-gray-50 rounded-r-lg">

                                    <p class="text-sm font-medium text-gray-800">
                                        {{ $log->action }}
                                    </p>
                                     <div class="text-xs text-gray-500 mt-1 flex gap-2 items-center">

                                        <span>
                                            by {{ $log->user->name }}
                                        </span>

                                        <span>•</span>

                                        <a href="/cases/{{ $log->case_file_id }}"
                                        class="text-blue-600 hover:underline font-medium">
                                            View Case #{{ $log->case_file_id }}
                                        </a>

                                        <span>•</span>
                                        <span>
                                            {{ $log->created_at->format('d M Y h:i A') }}
                                        </span>

                                    </div>

                                </div>

                            @empty

                                <div class="text-sm text-gray-500">
                                    No recent activity.
                                </div>

                            @endforelse

                        </div>

                    </div>

                </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
