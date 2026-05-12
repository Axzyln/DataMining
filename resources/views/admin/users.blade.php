<x-app-layout>
<x-slot name="header">Users</x-slot>

<div class="py-8 max-w-7xl mx-auto px-6">

    {{-- Flash --}}
    @foreach(['success' => 'green', 'error' => 'red'] as $type => $color)
        @if(session($type))
            <div class="mb-5 flex items-center gap-3 rounded-lg bg-{{ $color }}-50 border border-{{ $color }}-200 px-4 py-3 text-sm text-{{ $color }}-800">
                {{ session($type) }}
            </div>
        @endif
    @endforeach

    {{-- Header --}}
    <div class="mb-5 flex items-center justify-between">
        <p class="text-sm text-gray-500">{{ $users->total() }} user{{ $users->total() !== 1 ? 's' : '' }}</p>
        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-amber-600 px-4 py-2 text-sm font-medium text-white hover:bg-amber-700 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Add User
        </a>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-5 py-3 text-left">Name</th>
                    <th class="px-5 py-3 text-left">Email</th>
                    <th class="px-5 py-3 text-left">Last Login</th>
                    <th class="px-5 py-3 text-center">Role</th>
                    <th class="px-5 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $u)
                <tr class="hover:bg-gray-50 transition-colors" x-data="{ editing: false }">

                    {{-- Name --}}
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2.5">
                            @php
                                $avatarColor = match($u->role) {
                                    'admin'  => 'bg-purple-100 text-purple-700',
                                    'vendor' => 'bg-blue-100 text-blue-700',
                                    default  => 'bg-amber-100 text-amber-700',
                                };
                            @endphp
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full {{ $avatarColor }} text-xs font-bold">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-900">{{ $u->name }}</span>
                        </div>
                    </td>

                    {{-- Email --}}
                    <td class="px-5 py-3 text-gray-500">{{ $u->email }}</td>

                    {{-- Last login --}}
                    <td class="px-5 py-3 text-gray-400 text-xs">
                        {{ $u->last_login_at ? $u->last_login_at->diffForHumans() : 'Never' }}
                    </td>

                    {{-- Role (view + inline edit) --}}
                    <td class="px-5 py-3 text-center">
                        @php
                            $badge = match($u->role) {
                                'admin'  => 'bg-purple-100 text-purple-700',
                                'vendor' => 'bg-blue-100 text-blue-700',
                                'baker'  => 'bg-amber-100 text-amber-700',
                                default  => 'bg-gray-100 text-gray-600',
                            };
                        @endphp

                        {{-- Static badge --}}
                        <span x-show="!editing"
                              class="inline-block rounded-full {{ $badge }} px-2.5 py-0.5 text-xs font-semibold capitalize">
                            {{ $u->role }}
                        </span>

                        {{-- Inline edit form --}}
                        <form x-show="editing"
                              method="POST"
                              action="{{ route('admin.users.role', $u) }}"
                              class="inline-flex items-center gap-1.5">
                            @csrf @method('PATCH')
                            <select name="role"
                                    class="rounded border border-gray-300 py-1 pl-2 pr-6 text-xs focus:border-amber-500 focus:ring-amber-500">
                                <option value="admin"  @selected($u->role === 'admin')>Admin</option>
                                <option value="vendor" @selected($u->role === 'vendor')>Vendor</option>
                                <option value="baker"  @selected($u->role === 'baker')>Baker</option>
                            </select>
                            <button type="submit"
                                    class="rounded bg-amber-600 px-2 py-1 text-xs font-medium text-white hover:bg-amber-700">
                                Save
                            </button>
                            <button type="button" @click="editing = false"
                                    class="rounded bg-gray-100 px-2 py-1 text-xs text-gray-600 hover:bg-gray-200">
                                ✕
                            </button>
                        </form>
                    </td>

                    {{-- Actions --}}
                    <td class="px-5 py-3 text-center">
                        <div class="inline-flex items-center gap-1.5">
                            @if(!$u->isAdmin())
                                <button @click="editing = !editing"
                                        class="rounded-md bg-gray-50 border border-gray-200 px-2.5 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-100 transition-colors">
                                    Edit Role
                                </button>
                            @endif

                            @if(!$u->isAdmin())
                                <form method="POST"
                                      action="{{ route('admin.users.delete', $u) }}"
                                      onsubmit="return confirm('Delete {{ addslashes($u->name) }}? This cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button class="rounded-md bg-red-50 border border-red-100 px-2.5 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100 transition-colors">
                                        Delete
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-300">—</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-5">{{ $users->links() }}</div>
</div>
</x-app-layout>
