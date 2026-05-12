<x-guest-layout>

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Welcome back</h2>
        <p class="mt-1 text-sm text-gray-500">Sign in to your BakersGoods account</p>
    </div>

    {{-- Session status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm text-gray-900
                          focus:border-amber-500 focus:ring-amber-500 focus:outline-none
                          @error('email') border-red-400 @enderror">
            @error('email')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-xs text-amber-600 hover:text-amber-700 hover:underline">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password"
                   required autocomplete="current-password"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm text-gray-900
                          focus:border-amber-500 focus:ring-amber-500 focus:outline-none
                          @error('password') border-red-400 @enderror">
            @error('password')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember me --}}
        <div class="flex items-center gap-2">
            <input id="remember_me" type="checkbox" name="remember"
                   class="h-4 w-4 rounded border-gray-300 text-amber-600 focus:ring-amber-500">
            <label for="remember_me" class="text-sm text-gray-600">Remember me</label>
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full rounded-lg bg-amber-600 px-4 py-2.5 text-sm font-semibold text-white
                       hover:bg-amber-700 transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
            Sign in
        </button>

        <p class="text-center text-sm text-gray-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-medium text-amber-600 hover:text-amber-700 hover:underline">
                Create one
            </a>
        </p>
    </form>

</x-guest-layout>
