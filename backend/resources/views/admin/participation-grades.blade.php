@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Participation Grades</h2>
    <p style="color:gray;">Score = (Discussions × 3) + (Replies × 1)</p>

    <table style="width:100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align:left; border-bottom:2px solid #ccc;">
                <th>Student</th>
                <th>Group</th>
                <th>Discussions</th>
                <th>Replies</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grades as $grade)
                <tr style="border-bottom:1px solid #eee;">
                    <td>{{ $grade->user->name }}</td>
                    <td>{{ $grade->group->name }}</td>
                    <td>{{ $grade->discussion_count }}</td>
                    <td>{{ $grade->post_count }}</td>
                    <td><strong>{{ $grade->score }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection