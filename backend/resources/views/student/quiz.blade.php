@extends('layouts.app')

@section('content')

<div class="container">

    <h3>{{ $quiz->title }}</h3>

    <!-- TIMER -->
    <div class="alert alert-warning">
        Time Remaining: <strong id="timer"></strong>
    </div>

    <form method="POST" action="{{ route('quizzes.submit', $quiz) }}" id="quizForm">
        @csrf

        <input type="hidden" name="attempt_id" value="{{ $attempt->id }}">

        @foreach($quiz->questions as $q)

            <div class="card mb-3 p-3">
                <p><strong>{{ $loop->iteration }}. {{ $q->question_text }}</strong></p>

                <label>
                    <input type="radio" name="answers[{{ $q->id }}]" value="A"> {{ $q->option_a }}
                </label><br>

                <label>
                    <input type="radio" name="answers[{{ $q->id }}]" value="B"> {{ $q->option_b }}
                </label><br>

                <label>
                    <input type="radio" name="answers[{{ $q->id }}]" value="C"> {{ $q->option_c }}
                </label><br>

                <label>
                    <input type="radio" name="answers[{{ $q->id }}]" value="D"> {{ $q->option_d }}
                </label>

            </div>

        @endforeach

        <button type="submit" class="btn btn-success" id="submitBtn">
            Submit Quiz
        </button>

    </form>

</div>



<!-- TIMER SCRIPT -->
<script>

    // Convert Laravel time to JS
    const endTime = new Date("{{ $quiz->end_datetime }}").getTime();

    const timerEl = document.getElementById('timer');
    const form = document.getElementById('quizForm');
    const submitBtn = document.getElementById('submitBtn');

    const interval = setInterval(() => {

        const now = new Date().getTime();
        const distance = endTime - now;

        if (distance <= 0) {

            clearInterval(interval);

            timerEl.innerHTML = "TIME UP";

            submitBtn.disabled = true;

            alert("Time is up! Submitting your quiz...");

            form.submit(); // AUTO SUBMIT

            return;
        }

        // Time calculations
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        timerEl.innerHTML = minutes + "m " + seconds + "s";

    }, 1000);

</script>

@endsection