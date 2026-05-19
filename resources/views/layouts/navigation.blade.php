<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    @php
        $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();

        $notifications = \App\Models\Notification::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();
    @endphp

    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between h-16">

            
            <div class="flex items-center">

                
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('gavel.png') }}" alt="Logo" style="height:30px; width:30px;">
                    </a>
                </div>

                
                <div class="hidden space-x-8 sm:ms-10 sm:flex">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    @if(auth()->user()->role !== 'pending')
                        <x-nav-link :href="route('cases')" :active="request()->routeIs('cases')">
                            Cases
                        </x-nav-link>
                    @endif

                    @if(auth()->user()->role === 'admin')
                        <x-nav-link :href="url('/admin/role-requests')" :active="request()->is('admin/role-requests')">
                            Role Requests
                        </x-nav-link>
                    @endif

                </div>
            </div>

            
            <div class="hidden sm:flex sm:items-center sm:space-x-4">

                
                <div class="relative">

                    <button id="notifButton"
                        class="relative px-3 py-2 rounded-lg hover:bg-gray-100 transition">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6 text-gray-600 hover:text-indigo-500 transition"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032
                                2.032 0 0118 14.158V11a6.002
                                6.002 0 00-4-5.659V5a2
                                2 0 10-4 0v.341C7.67
                                6.165 6 8.388 6 11v3.159
                                c0 .538-.214 1.055-.595
                                1.436L4 17h5m6 0v1a3
                                3 0 11-6 0v-1m6 0H9"/>
                        </svg>

                        @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full animate-pulse shadow">
                                {{ $unreadCount }}
                            </span>
                        @endif

                    </button>

                    
                    <div id="notifDropdown"
                        class="hidden absolute right-0 mt-3 w-96 bg-white shadow-2xl rounded-2xl border border-gray-200 z-50 overflow-hidden">

                        <div class="px-5 py-4 font-semibold text-gray-800 border-b bg-gray-50">
                            Notifications
                        </div>

                        @forelse($notifications as $notif)
                            <form method="POST" action="/notifications/{{ $notif->id }}/read">
                                @csrf

                                <button type="submit"
                                    class="w-full text-left px-5 py-4 hover:bg-indigo-50 border-b transition">

                                    <div class="text-sm text-gray-800">
                                        {{ $notif->message }}
                                    </div>
                                </button>
                            </form>
                        @empty
                            <div class="p-6 text-sm text-gray-500 text-center">
                                No notifications
                            </div>
                        @endforelse

                    </div>
                </div>

              
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 transition">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">

                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10
                                        10.586l3.293-3.293a1 1 0
                                        111.414 1.414l-4 4a1 1 0
                                        01-1.414 0l-4-4a1 1 0
                                        010-1.414z"
                                        clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>

                </x-dropdown>

            </div>

            
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">

                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">

                        <path :class="{ 'hidden': open, 'inline-flex': !open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"/>

                        <path :class="{ 'hidden': !open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

  
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            @if(auth()->user()->role !== 'pending')
                <x-responsive-nav-link :href="route('cases')" :active="request()->routeIs('cases')">
                    Cases
                </x-responsive-nav-link>
            @endif

            @if(auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="url('/admin/role-requests')">
                    Role Requests
                </x-responsive-nav-link>
            @endif

        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">

            <div class="px-4">
                <div class="font-medium text-base text-gray-800">
                    {{ Auth::user()->name }}
                </div>

                <div class="font-medium text-sm text-gray-500">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">

                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>

            </div>
        </div>
    </div>
</nav>

<script>
document.getElementById('notifButton')?.addEventListener('click', function () {
    document.getElementById('notifDropdown').classList.toggle('hidden');
});
</script>