<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DCFM Features</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-[#0f172a] text-white min-h-screen">

    <div class="max-w-6xl mx-auto px-6 py-16">

        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold">
                DCFM Features
            </h1>

            <p class="text-gray-300 mt-4 text-lg max-w-3xl mx-auto">
                Differentiated Case Flow Management System streamlines court case operations
                through secure role-based workflows for lawyers, judges, and administrators.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">

            <div class="bg-white/10 p-8 rounded-3xl">
                <h2 class="text-2xl font-semibold mb-3">🔐 Authentication & Role Management</h2>
                <p class="text-gray-300">
                    Secure registration, login, role requests, and admin approval system
                    for controlled access.
                </p>
            </div>

            <div class="bg-white/10 p-8 rounded-3xl">
                <h2 class="text-2xl font-semibold mb-3">⚖️ Case Lifecycle Management</h2>
                <p class="text-gray-300">
                    Create, edit, update, and manage legal cases with statuses,
                    verdicts, notes, and hearing schedules.
                </p>
            </div>

            <div class="bg-white/10 p-8 rounded-3xl">
                <h2 class="text-2xl font-semibold mb-3">👨‍⚖️ Judge Assignment</h2>
                <p class="text-gray-300">
                    Admins securely assign judges to cases while maintaining workflow control.
                </p>
            </div>

            <div class="bg-white/10 p-8 rounded-3xl">
                <h2 class="text-2xl font-semibold mb-3">📊 Activity Timeline</h2>
                <p class="text-gray-300">
                    Role-based activity logs show relevant case actions, updates,
                    hearings, and verdict changes.
                </p>
            </div>

            <div class="bg-white/10 p-8 rounded-3xl">
                <h2 class="text-2xl font-semibold mb-3">🔎 Search & Filtering</h2>
                <p class="text-gray-300">
                    Quickly locate cases using search, priority filters,
                    status filters, and sorting.
                </p>
            </div>

            <div class="bg-white/10 p-8 rounded-3xl">
                <h2 class="text-2xl font-semibold mb-3">🛡️ Role-Based Access</h2>
                <p class="text-gray-300">
                    Lawyers only see their cases, judges only see assigned cases,
                    while admins oversee the full system.
                </p>
            </div>

        </div>

        <div class="text-center mt-16">
            <a href="/"
               class="px-8 py-4 bg-indigo-500 hover:bg-indigo-600 rounded-2xl font-semibold">
                Back to Home
            </a>
        </div>

    </div>

</body>
</html>