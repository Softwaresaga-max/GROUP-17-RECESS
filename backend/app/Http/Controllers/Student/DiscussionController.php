<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    //
}

public function store(Request $request)
{
    Discussion::create([
        'title' => $request->title,
        'content' => $request->content,
        'user_id' => auth()->id(),
        'group_id' => $request->group_id
    ]);

    return back();
}
