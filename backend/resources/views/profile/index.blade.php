<x-guest-layout>

<div style="max-width:600px; margin:auto; padding:20px;">

    <h2>👤 My Profile</h2>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
    @csrf

    <!-- Name -->
    <div>
        <label>Name</label>
        <input type="text" name="name" value="{{ auth()->user()->name }}">
    </div>

    <!-- Email -->
    <div style="margin-top:10px;">
        <label>Email</label>
        <input type="email" name="email" value="{{ auth()->user()->email }}">
    </div>

    <!-- ✅ THIS IS WHERE YOU ADD NOTIFICATION SECTION -->
    <div style="margin-top:15px;">
        <label>
            <input type="checkbox" name="email_notifications"
                {{ auth()->user()->email_notifications ? 'checked' : '' }}>
            Enable Email Notifications
        </label>
    </div>

    <button type="submit" style="margin-top:15px;">
        Save Changes
    </button>

</form>
</div>

</x-guest-layout>