<x-app-sidebar>

<h2>📄 Learning Materials</h2>


@if(session('success'))

@if($errors->any())
    <div style="background:#fdecea; color:#611a15; padding:12px; border-radius:6px; margin-bottom:15px;">
        <ul style="margin:0; padding-left:20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div>
    {{ session('success') }}
</div>

@endif



@foreach($materials as $material)

<div class="card">

    <h3>
        {{ $material->title }}
    </h3>


    <p>
        Group:
        {{ $material->group->name }}
    </p>


    <a href="{{ asset('storage/'.$material->file_path) }}" download>
        Download PDF
    </a>

</div>


<hr>


@endforeach


</x-app-sidebar>