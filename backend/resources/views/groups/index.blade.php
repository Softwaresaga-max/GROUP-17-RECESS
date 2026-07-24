<h2>Discussion Groups</h2>

@if(session('success'))
    <div style="color:green; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

{{-- Admin Button --}}
@if(auth()->user()->role == 'admin')

<p>
    <a href="{{ route('admin.groups.create') }}">
        ➕ Create New Group
    </a>
</p>

@endif


@forelse($groups as $group)

<div style="border:1px solid #ccc; padding:15px; margin-bottom:15px;">

    <h3>{{ $group->name }}</h3>

    <p>{{ $group->description }}</p>


    {{-- Student Actions --}}
    @if(auth()->user()->role == 'student')

        @if(in_array($group->id, $joinedGroups))

            <strong style="color:green;">
                ✓ Joined
            </strong>

        @else

            <form method="POST"
                  action="{{ route('groups.join', $group->id) }}">

                @csrf

                <button type="submit">
                    Join Group
                </button>

            </form>

        @endif

    @endif


    {{-- Admin Actions --}}
    @if(auth()->user()->role == 'admin')

        <a href="{{ route('admin.groups.edit', $group->id) }}">
            Edit
        </a>

        |

        <form
            action="{{ route('admin.groups.destroy', $group->id) }}"
            method="POST"
            style="display:inline;">

            @csrf
            @method('DELETE')

            <button
                type="submit"
                onclick="return confirm('Delete this group?')">

                Delete

            </button>

        </form>

    @endif

</div>

@empty

<p>No groups have been created yet.</p>

@endforelse