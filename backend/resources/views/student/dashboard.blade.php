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

    <h1>
        🎓 Student Dashboard
    </h1>

    <p>
        Welcome to your learning space, {{ auth()->user()->name }}.
    </p>

</div>



<div class="grid">


    <!-- Courses -->

    <a href="{{ route('courses.index') }}"
       class="card"
       style="text-decoration:none;color:inherit;">

        <div class="title">
            📚 Courses
        </div>

        <div class="subtitle">
            Access your enrolled courses
        </div>

    </a>



    <!-- Discussion Groups -->

    <a href="{{ route('groups.index') }}" 
   class="card"
   style="text-decoration:none;color:inherit;">

    <div class="title">
        👥 Discussion Groups
    </div>

    <div class="subtitle">
        Join course groups and collaborate
    </div>

</a>




    <!-- Discussions -->

    <a href="{{ route('discussions.index') }}"
       class="card"
       style="text-decoration:none;color:inherit;">

        <div class="title">
            💬 Discussions
        </div>

        <div class="subtitle">
            Join academic conversations
        </div>

    </a>




    <!-- Materials -->

    <a href="{{ route('student.materials') }}"
       class="card"
       style="text-decoration:none;color:inherit;">

        <div class="title">
            📄 Materials
        </div>

        <div class="subtitle">
            Download lecture notes and PDFs
        </div>

    </a>




    <!-- Quizzes -->

    <a href="{{ route('quizzes.index') }}"
       class="card"
       style="text-decoration:none;color:inherit;">

        <div class="title">
            📝 Quizzes
        </div>

        <div class="subtitle">
            Attempt available quizzes
        </div>

    </a>


</div>


</x-app-sidebar>