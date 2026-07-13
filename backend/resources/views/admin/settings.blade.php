<x-app-sidebar>

<h2>⚙️ System Settings</h2>

<div style="background:white; padding:20px; border-radius:10px;">
    <h3>Platform Rules</h3>
    <p>Configure warning limits, blacklist duration, quiz rules, and discussion controls.</p>
</div>

<br>

<a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>

<a href="{{ route('admin.settings') }}" class="card" style="text-decoration:none; color:inherit;">
    <div class="title">⚙️ Settings</div>
    <div class="subtitle">Configure system rules</div>
</a>
</x-app-sidebar>