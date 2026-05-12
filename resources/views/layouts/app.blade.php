<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'BakeryApp') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden bg-gray-50">

            {{-- Mobile overlay --}}
            <div x-show="sidebarOpen"
                 x-transition:enter="transition-opacity ease-linear duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 z-20 bg-black/50 sm:hidden"></div>

            @include('layouts.sidebar')

            {{-- Main area --}}
            <div class="flex flex-1 flex-col overflow-hidden">

                {{-- Top bar --}}
                <header class="flex h-16 shrink-0 items-center justify-between border-b border-gray-200 bg-white px-6">
                    {{-- Hamburger (mobile only) --}}
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="rounded-md p-1.5 text-gray-500 hover:bg-gray-100 hover:text-gray-700 sm:hidden">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                    </button>

                    {{-- Page heading --}}
                    <div class="text-lg font-semibold text-gray-800">
                        @isset($header){{ $header }}@endisset
                    </div>

                    {{-- User dropdown --}}
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 rounded-lg px-2 py-1.5 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-600 text-xs font-bold text-white">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden font-medium sm:block">{{ Auth::user()->name }}</span>
                                <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </header>

                {{-- Page content --}}
                <main class="flex-1 overflow-y-auto">
                    {{ $slot }}
                </main>

            </div>
        </div>
        @stack('scripts')
    </body>
</html>
