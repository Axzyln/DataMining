<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Users</h2></x-slot>

<div class="py-8 max-w-7xl mx-auto px-6">
    <table class="w-full bg-white shadow rounded">
        <thead class="bg-amber-100">
            <tr>
                <th class="p-3 text-left">Name</th>
                <th class="p-3 text-left">Email</th>
                <th class="p-3">Role</th>
                <th class="p-3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $u)
        <tr class="border-t">
            <td class="p-3">{{ $u->name }}</td>
            <td class="p-3">{{ $u->email }}</td>
            <td class="p-3 text-center capitalize">{{ $u->role }}</td>
            <td class="p-3 text-center">
                @if(!$u->isAdmin())
                <form method="POST"
                      action="{{ route('admin.users.delete', $u) }}"
                      onsubmit="return confirm('Delete this user?')">
                    @csrf @method('DELETE')
                    <button class="bg-red-600 text-white px-3 py-1 rounded">
                        Delete
                    </button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $users->links() }}</div>
</div>
</x-app-layout>