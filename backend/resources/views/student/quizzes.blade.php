@extends('layouts.app')

@section('content')

<div class="container">

@if(session('error'))

<div class="alert alert-danger">

{{ session('error') }}

</div>

@endif

<h2 class="mb-4">
    Available Quizzes
</h2>


@if(session('success'))

<div class="alert alert-success">
    {{ session('success') }}
</div>

@endif



@forelse($quizzes as $quiz)


<div class="card mb-3 p-4">


<h4>
{{ $quiz->title }}
</h4>


<p>
{{ $quiz->description }}
</p>


<p>
<strong>Duration:</strong>
{{ $quiz->duration }} minutes
</p>


<p>
<strong>Questions:</strong>
{{ $quiz->questions->count() }}
</p>



<a href="{{ route('quiz.start',$quiz->id) }}"
class="btn btn-primary">

Start Quiz

</a>


</div>


@empty


<div class="alert alert-info">

No quizzes available yet.

</div>


@endforelse


</div>


@endsection