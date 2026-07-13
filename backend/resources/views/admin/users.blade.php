<h1>User Management</h1>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Change Role</th>
        <th>Actions</th>
    </tr>

    @foreach($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->role }}</td>

        <td>
            <form method="POST" action="{{ route('admin.users.role', $user) }}">
                @csrf
                <select name="role">
                    <option value="student">Student</option>
                    <option value="lecturer">Lecturer</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit">Update</button>
            </form>
        </td>

        <td>
            <form method="POST" action="{{ route('admin.users.delete', $user) }}">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Delete user?')">
                    Delete
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>