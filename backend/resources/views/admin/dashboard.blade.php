<x-app-sidebar>

<style>
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .card {
        background: white;
        padding: 20px;
        border-radius: 14px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        text-align: center;
        transition: 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .subtitle {
        color: gray;
        font-size: 14px;
    }

    .header-card {
        background: white;
        padding: 20px;
        border-radius: 14px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        margin-bottom: 20px;
        text-align: center;
    }

    .badge {
        display: inline-block;
        padding: 5px 12px;
        background: #e3f2fd;
        border-radius: 20px;
        font-size: 12px;
        margin-top: 8px;
    }
</style>

<!-- HEADER -->
<div class="header-card">
    <h1>🎓 Admin Dashboard</h1>
    <p>Welcome back, {{ auth()->user()->name }}</p>
    <div class="badge">EDUCONNECT System Control Panel</div>
</div>

<!-- GRID -->
<div class="grid">

    <a href="{{ route('admin.users') }}" class="card" style="text-decoration:none; color:inherit;">
    <div class="title">👥 Manage Users</div>
    <div class="subtitle">Change student, lecturer and admin roles</div>
    
    

</a>

    <a href="{{ route('admin.reports') }}" class="card" style="text-decoration:none; color:inherit;">
    <div class="title">📊 Reports</div>
    <div class="subtitle">System analytics & usage data</div>
</a>

    <a href="{{ route('admin.settings') }}" class="card" style="text-decoration:none; color:inherit;">
    <div class="title">⚙️ Settings</div>
    <div class="subtitle">Configure system rules</div>
</a>
</div>

<div class="grid">


    <a href="{{ route('admin.groups') }}" class="card" style="text-decoration:none; color:inherit;">
    <div class="title">👨‍👩‍👧‍👦 Manage Groups</div>
    <div class="subtitle">Create, edit and delete discussion groups</div>
</a>

    <a href="{{ route('discussions.index') }}" class="card" style="text-decoration:none; color:inherit;">
    <div class="title">💬 Discussions</div>
    <div class="subtitle">{{ $discussions }} discussions</div>
</a>

    <a href="{{ route('quizzes.index') }}" class="card" style="text-decoration:none; color:inherit;">
    <div class="title">📝 Quizzes</div>
    <div class="subtitle">{{ $quizzes }} quizzes</div>
</a>

</div>

</x-app-sidebar>