@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">
        📊 My Quiz Results
    </h2>


    @if($results->count() > 0)

    <div class="card shadow-sm p-4">

        <div class="card-header mb-3">
            <h4>
                Completed Quizzes
            </h4>
        </div>


        <table class="table">

            <thead>
                <tr>
                    <th>Quiz</th>
                    <th>Score</th>
                    <th>Status</th>
                    <th>Date Completed</th>
                </tr>
            </thead>


            <tbody>

            @foreach($results as $result)

                <tr>

                    <td>
                        {{ $result->quiz->title }}
                    </td>


                    <td>
                        {{ $result->score }}
                    </td>


                    <td>

                        @if($result->completed)

                            <span class="badge bg-success">
                                Completed
                            </span>

                        @else

                            <span class="badge bg-warning">
                                Incomplete
                            </span>

                        @endif

                    </td>


                    <td>
                        {{ $result->updated_at->format('d M Y H:i') }}
                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>


    </div>


    @else


    <div class="card shadow-sm p-4">

        <div class="alert alert-info mb-0">

            You have not completed any quizzes yet.

        </div>

    </div>


    @endif


</div>


@endsection