<x-guest-layout>

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Create your account</h2>
        <p class="mt-1 text-sm text-gray-500">Join BakersGoods as a baker or supplier</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Full name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                   required autofocus autocomplete="name"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm text-gray-900
                          focus:border-amber-500 focus:ring-amber-500 focus:outline-none
                          @error('name') border-red-400 @enderror">
            @error('name')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autocomplete="username"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm text-gray-900
                          focus:border-amber-500 focus:ring-amber-500 focus:outline-none
                          @error('email') border-red-400 @enderror">
            @error('email')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Role --}}
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700 mb-1.5">I am a…</label>
            <select id="role" name="role" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm text-gray-900
                           focus:border-amber-500 focus:ring-amber-500 focus:outline-none
                           @error('role') border-red-400 @enderror">
                <option value="baker"  {{ old('role') === 'baker'  ? 'selected' : '' }}>Baker / Bakery Owner</option>
                <option value="vendor" {{ old('role') === 'vendor' ? 'selected' : '' }}>Vendor (Baking Supply Store)</option>
            </select>
            @error('role')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
            <input id="password" type="password" name="password"
                   required autocomplete="new-password"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm text-gray-900
                          focus:border-amber-500 focus:ring-amber-500 focus:outline-none
                          @error('password') border-red-400 @enderror">
            @error('password')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   required autocomplete="new-password"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm text-gray-900
                          focus:border-amber-500 focus:ring-amber-500 focus:outline-none">
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full rounded-lg bg-amber-600 px-4 py-2.5 text-sm font-semibold text-white
                       hover:bg-amber-700 transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
            Create account
        </button>

        <p class="text-center text-sm text-gray-500">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium text-amber-600 hover:text-amber-700 hover:underline">
                Sign in
            </a>
        </p>
    </form>

</x-guest-layout>
