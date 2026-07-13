<x-app-sidebar>

<style>
.card {
    background:white;
    padding:20px;
    margin:20px 0;
    border-radius:14px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

button {
    background:#2563eb;
    color:white;
    border:none;
    padding:10px 20px;
    border-radius:8px;
    cursor:pointer;
}
</style>


<div class="card">

<h1>📄 Learning Materials</h1>

<p>
Download lecture notes uploaded by your lecturers.
</p>

</div>


@forelse($materials as $material)

<div class="card">

<h2>
{{ $material->title }}
</h2>


<p>
📚 Group:
{{ $material->group->name ?? 'General' }}
</p>


<a href="{{ route('materials.download',$material->id) }}">

<button>
⬇️ Download PDF
</button>

</a>


</div>


@empty

<div class="card">

<p>
No learning materials available yet.
</p>

</div>

@endforelse


</x-app-sidebar>