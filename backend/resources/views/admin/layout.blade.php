<!DOCTYPE html>
<html>
<head>
    <title>EDUCONNECT Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="bg-dark text-white p-3" style="width: 250px; min-height: 100vh;">
        <h4>EDUCONNECT PLATFORM</h4>
        <hr>

        <a href="{{ route('admin.dashboard') }}" class="text-white d-block mb-2">Dashboard</a>
        <a href="{{ route('admin.users') }}" class="text-white d-block mb-2">Users</a>

        <hr>
        <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="text-white d-block mb-2" style="background:none; border:none;">
        Logout
    </button>
</form>
    </div>

    <!-- MAIN CONTENT -->
    <div class="p-4 flex-grow-1">
        @yield('content')
    </div>

</div>

</body>
</html>