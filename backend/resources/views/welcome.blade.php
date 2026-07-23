<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educonnect - Collaborative Learning Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <!-- Header Navigation -->
    <header class="w-full bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="h-10 w-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                    E
                </div>
                <span class="text-2xl font-bold text-gray-900 tracking-tight">Educonnect</span>
            </div>

            <nav class="flex items-center space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 transition">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition">
                                Get Started
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-20 text-center">
        <span class="inline-block px-3 py-1 text-xs font-semibold uppercase tracking-wider text-indigo-700 bg-indigo-100 rounded-full mb-4">
            Academic & Discussion Forum
        </span>
        <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 tracking-tight leading-tight">
            Streamlining Communication Between <br class="hidden md:inline"/>
            <span class="text-indigo-600">Students & Lecturers</span>
        </h1>
        <p class="mt-6 text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
            Welcome to Educonnect. Access course materials, take quizzes, collaborate on discussions, and get real-time feedback from lecturers all in one platform.
        </p>

        <div class="mt-8 flex justify-center gap-4">
            <a href="{{ route('register') }}" class="px-6 py-3 text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-md transition">
                Create Account
            </a>
            <a href="{{ route('login') }}" class="px-6 py-3 text-base font-semibold text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg transition">
                Sign In
            </a>
        </div>
    </section>

    <!-- Feature Grid -->
    <section class="max-w-7xl mx-auto px-6 pb-20">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="h-12 w-12 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center font-bold text-lg mb-4">
                    📚
                </div>
                <h3 class="text-lg font-bold text-gray-900">Course Materials</h3>
                <p class="mt-2 text-gray-600 text-sm">Access lecture notes, assignments, and study resources uploaded by course instructors.</p>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="h-12 w-12 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center font-bold text-lg mb-4">
                    📝
                </div>
                <h3 class="text-lg font-bold text-gray-900">Quizzes & Assessments</h3>
                <p class="mt-2 text-gray-600 text-sm">Attempt interactive quizzes and monitor academic progress directly from the dashboard.</p>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="h-12 w-12 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center font-bold text-lg mb-4">
                    💬
                </div>
                <h3 class="text-lg font-bold text-gray-900">Interactive Forum</h3>
                <p class="mt-2 text-gray-600 text-sm">Engage in peer-to-peer discussion threads, clear doubts, and connect with lecturers.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-gray-200 bg-white py-6 text-center text-sm text-gray-500">
        <p>&copy; {{ date('Y') }} Educonnect System. All rights reserved.</p>
    </footer>

</body>
</html>