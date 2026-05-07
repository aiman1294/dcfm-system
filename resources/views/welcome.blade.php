<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DCFM System</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#0f172a] text-white min-h-screen overflow-x-hidden">

    <!-- Navbar -->
    <header class="absolute top-0 left-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">

            <h1 class="text-2xl font-bold tracking-wide">
                <span class="text-indigo-400">DCFM</span> System
            </h1>

            <div class="flex gap-4 items-center">

                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="bg-indigo-500 hover:bg-indigo-600 px-5 py-2 rounded-xl font-medium transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="text-gray-300 hover:text-white transition">
                        Log in
                    </a>

                    <a href="{{ route('register') }}"
                       class="bg-white text-black hover:bg-gray-200 px-5 py-2 rounded-xl font-medium transition">
                        Register
                    </a>
                @endauth

            </div>
        </div>
    </header>

    <!-- Hero -->
    <main class="relative min-h-screen flex items-center">

        <!-- Glow Effects -->
        <div class="absolute inset-0 overflow-hidden">

            <div class="absolute top-[-150px] left-[-100px] w-[400px] h-[400px] bg-indigo-500/30 blur-3xl rounded-full"></div>

            <div class="absolute bottom-[-150px] right-[-100px] w-[400px] h-[400px] bg-cyan-500/20 blur-3xl rounded-full"></div>

        </div>

        <div class="relative max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-20 items-center">

            <!-- LEFT -->
            <div>

                <p class="uppercase tracking-[0.3em] text-indigo-400 text-sm font-semibold mb-6">
                    Digital Court File Management
                </p>

                <h1 class="text-6xl font-black leading-tight mb-8">
                    Smarter Legal
                    <span class="text-indigo-400">
                        Case Management
                    </span>
                </h1>

                <p class="text-gray-300 text-xl leading-relaxed mb-10 max-w-2xl">
                    A centralized system for lawyers, judges, and admins
                    to manage legal cases, hearing schedules, verdicts,
                    and activity timelines securely.
                </p>
                <div class="flex gap-5">

    @auth

        <a href="{{ url('/dashboard') }}"
           class="bg-indigo-500 hover:bg-indigo-600 px-8 py-4 rounded-2xl text-lg font-semibold transition shadow-2xl">
            Go to Dashboard
        </a>

    @else

        <a href="#features"
           class="bg-indigo-500 hover:bg-indigo-600 px-8 py-4 rounded-2xl text-lg font-semibold transition shadow-2xl">
            Explore Features
        </a>

    @endauth

</div>

               

            </div>

            <!-- RIGHT -->
            <div class="space-y-6">

                <div class="bg-white/10 border border-white/10 backdrop-blur-lg rounded-3xl p-6 shadow-2xl">

                    <h3 class="text-2xl font-semibold mb-3">
                        ⚖️ Case Tracking
                    </h3>

                    <p class="text-gray-300">
                        Monitor legal cases, status updates, and priorities in real time.
                    </p>

                </div>

                <div class="bg-white/10 border border-white/10 backdrop-blur-lg rounded-3xl p-6 shadow-2xl ml-10">

                    <h3 class="text-2xl font-semibold mb-3">
                        👨‍⚖️ Judge Assignment
                    </h3>

                    <p class="text-gray-300">
                        Securely assign judges and manage hearing schedules efficiently.
                    </p>

                </div>

                <div class="bg-white/10 border border-white/10 backdrop-blur-lg rounded-3xl p-6 shadow-2xl">

                    <h3 class="text-2xl font-semibold mb-3">
                        📈 Activity Timeline
                    </h3>

                    <p class="text-gray-300">
                        Track verdicts, hearings, assignments, and case activity instantly.
                    </p>

                </div>

            </div>

        </div>

    </main>

</body>
</html>