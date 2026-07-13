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
</style>

<div class="card">
    <h1>👨‍🏫 Lecturer Dashboard</h1>
    <p>Welcome back, {{ auth()->user()->name }}.</p>
</div>

<div class="grid">

    <a href="{{ route('discussions.create') }}" class="card" style="text-decoration:none; color:inherit;">
        <div class="title">📢 Create Discussion</div>
        <div class="subtitle">Create a new topic for students</div>
    </a>

    <a href="{{ route('quizzes.create') }}" class="card" style="text-decoration:none; color:inherit;">
        <div class="title">📝 Create Quiz</div>
        <div class="subtitle">Set quiz title, description and publish</div>
    </a>

    <a href="{{ route('lecturer.analytics') }}" class="card" style="text-decoration:none; color:inherit;">
        <div class="title">📊 Analytics</div>
        <div class="subtitle">View student performance</div>
    </a>

    <a href="{{ route('materials.create') }}" 
class="card" 
style="text-decoration:none;color:inherit;">

<div class="title">
📄 Upload Materials
</div>

<div class="subtitle">
Upload topic PDFs for students
</div>

</a>

</div>

<div class="grid">

    <a href="{{ route('discussions.index') }}" class="card" style="text-decoration:none; color:inherit;">
        <div class="title">💬 Discussions</div>
        <div class="subtitle">{{ $discussions }} total</div>
    </a>

    <a href="{{ route('quizzes.index') }}" class="card" style="text-decoration:none; color:inherit;">
        <div class="title">📝 Quizzes</div>
        <div class="subtitle">{{ $quizzes }} available</div>
    </a>

    <a href="{{ route('lecturer.grading') }}" class="card" style="text-decoration:none; color:inherit;">
        <div class="title">📋Grading</div>
        <div class="subtitle">Assess participation and quiz performance</div>
    </a>

</div>

</x-app-sidebar>