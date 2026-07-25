@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Per-Group Statistics</h2>

    <table class="table" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align:left; border-bottom:2px solid #ccc;">
                <th>Group</th>
                <th>Members</th>
                <th>Discussions</th>
                <th>Total Posts</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groups as $group)
                <tr style="border-bottom:1px solid #eee;">
                    <td>{{ $group['name'] }}</td>
                    <td>{{ $group['member_count'] }}</td>
                    <td>{{ $group['discussion_count'] }}</td>
                    <td>{{ $group['post_count'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection