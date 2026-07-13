@extends('layouts.app')


@section('content')

<div class="container">

<h2>
{{ $quiz->title }}
</h2>


<form method="POST"
action="{{ route('student.quiz.submit',$quiz->id) }}">

@csrf


@foreach($quiz->questions as $index=>$question)

<div class="card mb-3 p-3">


<h5>
{{ $index+1 }}.
{{ $question->question }}
</h5>


<label>
<input type="radio"
name="answers[{{ $question->id }}]"
value="A">

{{ $question->option_a }}

</label>


<br>


<label>
<input type="radio"
name="answers[{{ $question->id }}]"
value="B">

{{ $question->option_b }}

</label>


<br>


<label>
<input type="radio"
name="answers[{{ $question->id }}]"
value="C">

{{ $question->option_c }}

</label>


<br>


<label>
<input type="radio"
name="answers[{{ $question->id }}]"
value="D">

{{ $question->option_d }}

</label>


</div>


@endforeach



<button class="btn btn-success">
Submit Quiz
</button>


</form>


</div>


@endsection