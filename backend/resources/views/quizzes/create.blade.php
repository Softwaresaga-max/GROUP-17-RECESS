@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Create Quiz</h2>

    <form method="POST" action="{{ route('quizzes.store') }}">
        @csrf

        <div class="card p-4 shadow-sm">

            <!-- TITLE -->
            <div class="mb-3">
                <label class="form-label">Quiz Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <!-- DESCRIPTION -->
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <div class="mb-3">
    <label>Course</label>
    <select name="course_id" class="form-control" required>
        @foreach($courses as $course)
            <option value="{{ $course->id }}">{{ $course->name }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Class</label>
    <select name="class_room_id" class="form-control" required>
        @foreach($classes as $class)
            <option value="{{ $class->id }}">{{ $class->name }} ({{ $class->year }})</option>
        @endforeach
    </select>
</div>

            <!-- DATE TIME SECTION -->
            <div class="row">

                <!-- START -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Start Date & Time</label>
                    <input type="datetime-local" name="start_datetime" class="form-control" required>
                </div>

                <!-- END -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">End Date & Time</label>
                    <input type="datetime-local" name="end_datetime" class="form-control" required>
                </div>

            </div>

            <!-- CATEGORY -->
            <div class="mb-3">
                <label class="form-label">Student Category</label>
                <select name="student_category" class="form-control" required>
                    <option value="">-- Select Category --</option>
                    <option value="Year 1">Year 1</option>
                    <option value="Year 2">Year 2</option>
                    <option value="Year 3">Year 3</option>
                    <option value="Year 4">Year 4</option>
                </select>
            </div>

            <!-- SUBMIT -->
            <button type="submit" class="btn btn-primary">
                Create Quiz
            </button>

        </div>
    </form>
</div>

@endsection