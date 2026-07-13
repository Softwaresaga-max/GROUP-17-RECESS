<x-app-sidebar>

<div class="container">

    <h2>💬 Discussion Forum</h2>


    <a href="{{ route('discussions.create') }}"
       class="btn btn-primary mb-3">

        ➕ Create Discussion

    </a>



    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif




    @forelse($discussions as $discussion)


        <div class="card mb-3 p-3">


            <h3>

                {{ $discussion->title }}

            </h3>



            <p>

                {{ Str::limit($discussion->content,150) }}

            </p>




            <small>

                👤 By:
                {{ $discussion->user->name ?? 'Unknown' }}

            </small>


            <br>


            <small>

                📚 Category:
                {{ $discussion->category ?? 'General' }}

            </small>


            <br>


            <small>

                👁 Views:
                {{ $discussion->views }}

            </small>



            <br><br>



            <a href="{{ route('discussions.show',$discussion->id) }}"
               class="btn btn-success">

                Open Discussion

            </a>


        </div>


    @empty


        <p>

            No discussions available yet.

        </p>


    @endforelse


</div>


</x-app-sidebar>