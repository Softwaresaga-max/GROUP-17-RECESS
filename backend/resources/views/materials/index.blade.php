<x-app-sidebar>

<h2>📄 Learning Materials</h2>


@if(session('success'))

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