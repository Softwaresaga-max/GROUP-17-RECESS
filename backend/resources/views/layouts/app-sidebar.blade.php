<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EDUCONNECT</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            height: 100vh;
            background: #1f2937;
            color: white;
            padding: 20px;
            position: fixed;
        }

        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 5px;
        }

        .sidebar a:hover {
            background: #374151;
        }

        /* MAIN CONTENT */
        .main {
            margin-left: 240px;
            padding: 20px;
            width: 100%;
            background: #f3f4f6;
            min-height: 100vh;
        }

        .topbar {
            background: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>🎓 EDUCONNECT</h2>

        <a href="{{ route('student.dashboard') }}">🏠 Dashboard</a>
        <a href="#">💬 Discussions</a>
        <a href="#">📚 Courses</a>
        <a href="#">📝 Quizzes</a>

        @if(auth()->user()->role === 'lecturer')
            <hr>
            <a href="#">📢 Create Discussion</a>
            <a href="#">📊 Grade Students</a>
        @endif

        @if(auth()->user()->role === 'admin')
            <hr>
            <a href="{{ route('admin.users') }}">⚙️ Manage Users</a>
        @endif

        <hr>
        <a href="/logout"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
           🚪 Logout
        </a>

        <form id="logout-form" method="POST" action="/logout" style="display:none;">
            @csrf
        </form>
    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="topbar">
            👋 Welcome, {{ auth()->user()->name }}
        </div>

        {{ $slot }}

    </div>

</body>
</html>