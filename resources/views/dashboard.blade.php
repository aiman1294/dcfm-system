
<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">
                Welcome back, {{ auth()->user()->name }}
            </h2>

            <p class="text-gray-500 mt-1">
                Here's what's happening in your legal workspace today.
            </p>
        </div>
    </x-slot>

    <div class="py-12">
    @php
    $user = auth()->user();

    if ($user->role === 'admin') {
        $totalCases = \App\Models\CaseFile::count();
        $pendingRoles = \App\Models\User::where('role', 'pending')->count();
        $totalJudges = \App\Models\User::where('role', 'judge')->count();
        $totalLawyers = \App\Models\User::where('role', 'lawyer')->count();
    }

    elseif ($user->role === 'judge') {
        $assignedCases = \App\Models\CaseFile::where('judge_id', $user->id)->count();
        $upcomingHearings = \App\Models\CaseFile::where('judge_id', $user->id)
            ->whereDate('hearing_date', '>=', now())
            ->count();
        $closedCases = \App\Models\CaseFile::where('judge_id', $user->id)
            ->where('case_status', 'Closed')
            ->count();
        $pendingNotes = \App\Models\CaseFile::where('judge_id', $user->id)
            ->whereDate('hearing_date', '<', now())
            ->whereNull('judge_notes')
            ->count();
    }

    elseif ($user->role === 'lawyer') {
        $myCases = \App\Models\CaseFile::where('user_id', $user->id)->count();
        $openCases = \App\Models\CaseFile::where('user_id', $user->id)
            ->where('case_status', 'Open')
            ->count();
        $upcomingHearings = \App\Models\CaseFile::where('user_id', $user->id)
            ->whereDate('hearing_date', '>=', now())
            ->count();
        $verdicts = \App\Models\CaseFile::where('user_id', $user->id)
            ->whereNotNull('verdict')
            ->count();
    }
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
@if($user->role === 'admin')

<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden">
    <p class="text-gray-500 text-sm">Total Cases</p>
    <h3 class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalCases }}</h3>
</div>

<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden">
    <p class="text-gray-500 text-sm">Pending Roles</p>
    <h3 class="text-3xl font-bold text-amber-500 mt-2">{{ $pendingRoles }}</h3>
</div>

<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden">
    <p class="text-gray-500 text-sm">Judges</p>
    <h3 class="text-3xl font-bold text-emerald-600 mt-2">{{ $totalJudges }}</h3>
</div>

<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden">
    <p class="text-gray-500 text-sm">Lawyers</p>
    <h3 class="text-3xl font-bold text-blue-600 mt-2">{{ $totalLawyers }}</h3>
</div>

@endif
@if($user->role === 'judge')

<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden">
<div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
    <p class="text-gray-500 text-sm">Assigned Cases</p>
    <h3 class="text-3xl font-bold text-emerald-600 mt-2">{{ $assignedCases }}</h3>
</div>

<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden">
<div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
    <p class="text-gray-500 text-sm">Upcoming Hearings</p>
    <h3 class="text-3xl font-bold text-indigo-600 mt-2">{{ $upcomingHearings }}</h3>
</div>

<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden">
<div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
    <p class="text-gray-500 text-sm">Pending Notes</p>
    <h3 class="text-3xl font-bold text-amber-500 mt-2">{{ $pendingNotes }}</h3>
</div>

<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden">
<div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
    <p class="text-gray-500 text-sm">Closed Cases</p>
    <h3 class="text-3xl font-bold text-gray-700 mt-2">{{ $closedCases }}</h3>
</div>

@endif

@if($user->role === 'lawyer')

<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden">
<div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
    <p class="text-gray-500 text-sm">My Cases</p>
    <h3 class="text-3xl font-bold text-blue-600 mt-2">{{ $myCases }}</h3>
</div>

<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden">
<div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
    <p class="text-gray-500 text-sm">Open Cases</p>
    <h3 class="text-3xl font-bold text-indigo-600 mt-2">{{ $openCases }}</h3>
</div>

<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden">
<div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
    <p class="text-gray-500 text-sm">Upcoming Hearings</p>
    <h3 class="text-3xl font-bold text-emerald-600 mt-2">{{ $upcomingHearings }}</h3>
</div>

<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden">
<div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
    <p class="text-gray-500 text-sm">Verdicts</p>
    <h3 class="text-3xl font-bold text-purple-600 mt-2">{{ $verdicts }}</h3>
</div>

@endif

</div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                @if(auth()->user()->role !== 'pending' &&  auth()->user()->role !== 'judge')
                
                    <a href="/cases/create" style="padding:10px 20px; background:#4f46e5; color:white; border-radius:6px; text-decoration:none;">
    Register a Case
</a>

                @endif

                 
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
