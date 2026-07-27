<!DOCTYPE html>
<html>
<head>
    <title>Discussion Report</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }

        h1 {
            text-align: center;
        }

        .box {
            border:1px solid #ddd;
            padding:15px;
            margin-bottom:15px;
        }

        .reply {
            margin-left:20px;
            border-left:3px solid #555;
            padding-left:10px;
        }
    </style>
</head>

<body>

<h1>Discussion Report</h1>


<div class="box">

<h2>
{{ $discussion->title }}
</h2>

<p>
<strong>Posted by:</strong>
{{ $discussion->user->name ?? 'Unknown' }}
</p>

<p>
{{ $discussion->content }}
</p>

</div>


<h3>Replies</h3>


@forelse($discussion->replies as $reply)

<div class="reply">

<p>
<strong>
{{ $reply->user->name ?? 'Unknown' }}
</strong>
</p>

<p>
{{ $reply->content }}
</p>

</div>

@empty

<p>No replies yet.</p>

@endforelse


</body>
</html>