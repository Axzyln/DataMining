<x-app-layout>
<x-slot name="header">Add User</x-slot>

<div class="py-8 max-w-lg mx-auto px-6">

    <div class="mb-5">
        <a href="{{ route('admin.users') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Back to Users
        </a>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
        <h2 class="mb-6 text-lg font-semibold text-gray-900">New User</h2>

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
            @csrf

            {{-- Name --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Full Name</label>
                <input name="name" type="text" value="{{ old('name') }}" required autofocus
                       placeholder="e.g. Maria Santos"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500
                              @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Email Address</label>
                <input name="email" type="email" value="{{ old('email') }}" required
                       placeholder="e.g. user@example.com"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500
                              @error('email') border-red-400 @enderror">
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Role --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Role</label>
                <select name="role" required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500
                               @error('role') border-red-400 @enderror">
                    <option value="">Select a role…</option>
                    <option value="admin"  @selected(old('role') === 'admin')>Admin</option>
                    <option value="vendor" @selected(old('role') === 'vendor')>Vendor</option>
                    <option value="baker"  @selected(old('role') === 'baker')>Baker</option>
                </select>
                @error('role')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Vendor accounts automatically get a store profile created.</p>
            </div>

            {{-- Password --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Password</label>
                <input name="password" type="password" required
                       placeholder="Minimum 8 characters"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500
                              @error('password') border-red-400 @enderror">
                @error('password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Confirm Password</label>
                <input name="password_confirmation" type="password" required
                       placeholder="Repeat password"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500">
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.users') }}"
                   class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="rounded-lg bg-amber-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-amber-700 transition-colors">
                    Create User
                </button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
