<x-app-layout>
    <h2 class="text-xl font-bold mb-4">Pending Role Requests</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-2 rounded mb-3">
            {{ session('error') }}
        </div>
    @endif

    @forelse($users as $user)
        <div class="border p-3 mb-2 flex justify-between items-center">
            <div>
                <strong>{{ $user->name }}</strong>  
                requested <b>{{ $user->requested_role }}</b>
            </div>

            <div class="flex gap-2">
                <form method="POST" action="/admin/approve/{{ $user->id }}">
                    @csrf
                    <button class="bg-green-500 text-black px-3 py-1 rounded">
                        Approve
                    </button>
                </form>

                <form method="POST" action="/admin/reject/{{ $user->id }}">
                    @csrf
                    <button class="bg-red-500 text-black px-3 py-1 rounded">
                        Reject
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p>No pending requests</p>
    @endforelse
</x-app-layout>