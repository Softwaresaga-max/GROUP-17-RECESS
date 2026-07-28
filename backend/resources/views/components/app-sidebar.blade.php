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
        @if(auth()->user()->role === 'student')
    <a href="{{ route('discussions.recommendations') }}">📌 Recommended</a>
@endif
        <a href="/quizzes">📝 Quizzes</a>

 <div style="margin: 15px 0;">
    <a href="#" onclick="document.getElementById('notifDropdown').style.display = document.getElementById('notifDropdown').style.display === 'block' ? 'none' : 'block'; return false;">
        🔔 Notifications
        @php $unreadCount = auth()->user()->notifications()->whereNull('read_at')->count(); @endphp
        @if($unreadCount > 0)
            <span style="background:#ef4444; color:white; padding:1px 6px; border-radius:10px; font-size:11px;">{{ $unreadCount }}</span>
        @endif
    </a>

    <div id="notifDropdown" style="display:none; background:white; color:#111827; border-radius:6px; margin-top:6px; max-height:250px; overflow-y:auto;">
        @forelse(auth()->user()->notifications()->take(10)->get() as $notification)
            <div style="padding:8px; font-size:13px; border-bottom:1px solid #eee; {{ $notification->read_at ? '' : 'background:#eff6ff;' }}">
                {{ $notification->message }}
                <div style="font-size:11px; color:gray;">{{ $notification->created_at->diffForHumans() }}</div>
            </div>
        @empty
            <div style="padding:8px; font-size:13px;">No notifications yet.</div>
        @endforelse
    </div>
</div>        

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