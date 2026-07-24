<x-app-sidebar>

<div style="padding:20px;">

    <h1 style="margin-bottom:20px;">👥 User Management</h1>

    @if(session('success'))
        <div style="
            background:#d4edda;
            color:#155724;
            padding:10px;
            margin-bottom:20px;
            border-radius:8px;">
            {{ session('success') }}
        </div>
    @endif

    <table style="
        width:100%;
        border-collapse:collapse;
        background:white;
        box-shadow:0 4px 10px rgba(0,0,0,.1);">

        <thead style="background:#2563eb;color:white;">
            <tr>
                <th style="padding:12px;">Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Change Role</th>
                <th>Delete</th>
            </tr>
        </thead>

        <tbody>

        @foreach($users as $user)

            <tr style="border-bottom:1px solid #ddd;">

                <td style="padding:10px;">{{ $user->name }}</td>

                <td>{{ $user->email }}</td>

                <td>{{ ucfirst($user->role) }}</td>

                <td>

                    <form method="POST"
                          action="{{ route('admin.users.role',$user) }}">

                        @csrf

                        <select name="role">

                            <option value="student"
                                {{ $user->role=='student'?'selected':'' }}>
                                Student
                            </option>

                            <option value="lecturer"
                                {{ $user->role=='lecturer'?'selected':'' }}>
                                Lecturer
                            </option>

                            <option value="admin"
                                {{ $user->role=='admin'?'selected':'' }}>
                                Admin
                            </option>

                        </select>

                        <button type="submit">
                            Update
                        </button>

                    </form>

                </td>

                <td>

                    <form method="POST"
                          action="{{ route('admin.users.delete',$user) }}">

                        @csrf
                        @method('DELETE')

                        <button
                            onclick="return confirm('Delete this user?')">

                            Delete

                        </button>

                    </form>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

</x-app-sidebar>