<!DOCTYPE html>
<html>
<head>
    <title>EDUCONNECT</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }

        .sidebar {
            width: 220px;
            height: 100vh;
            background: #111827;
            color: white;
            padding: 20px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin: 12px 0;
        }

        .sidebar a:hover {
            color: #60a5fa;
        }

        .main {
            flex: 1;
            padding: 20px;
            background: #f3f4f6;
            min-height: 100vh;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>EDUCONNECT PLATFORM</h2>

        @if(auth()->user()->role === 'lecturer')
    <a href="{{ route('lecturer.dashboard') }}">🏠 Dashboard</a>
@elseif(auth()->user()->role === 'admin')
    <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
@else
    <a href="{{ route('student.dashboard') }}">🏠 Dashboard</a>
@endif
        <a href="/discussions">💬 Discussions</a>
        <a href="/quizzes">📝 Quizzes</a>
        <a href="/logout"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
           🚪 Logout
        </a>

        <form id="logout-form" method="POST" action="/logout" style="display:none;">
            @csrf
        </form>
    </div>

    <div class="main">
        {{ $slot }}
    </div>

</body>
</html>