<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BakersGoods') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

<div class="min-h-screen flex">

    {{-- Left branding panel --}}
    <div class="hidden lg:flex lg:w-1/2 bg-stone-900 flex-col justify-between p-12">
        <div class="flex items-center gap-3">
            <span class="text-3xl leading-none">🍞</span>
            <span class="text-2xl font-bold tracking-tight text-white">BakersGoods</span>
        </div>

        <div>
            <h1 class="text-4xl font-bold text-white leading-snug">
                Smarter baking<br>starts here.
            </h1>
            <p class="mt-4 text-stone-400 text-lg leading-relaxed max-w-sm">
                AI-powered ingredient management and product recommendations for Filipino bakers and their suppliers.
            </p>

            <div class="mt-10 grid grid-cols-3 gap-6">
                <div>
                    <div class="text-2xl font-bold text-amber-400">AI</div>
                    <div class="mt-1 text-xs text-stone-400">Smart product recommendations</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-amber-400">Live</div>
                    <div class="mt-1 text-xs text-stone-400">Inventory & low-stock alerts</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-amber-400">Data</div>
                    <div class="mt-1 text-xs text-stone-400">Sales analytics & reports</div>
                </div>
            </div>
        </div>

        <p class="text-xs text-stone-600">© {{ date('Y') }} BakersGoods · Cebu Technological University</p>
    </div>

    {{-- Right form panel --}}
    <div class="flex flex-1 flex-col justify-center items-center px-6 py-12 bg-gray-50">
        {{-- Mobile logo --}}
        <div class="flex items-center gap-2 mb-8 lg:hidden">
            <span class="text-2xl">🍞</span>
            <span class="text-xl font-bold text-stone-800">BakersGoods</span>
        </div>

        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
    </div>

</div>

</body>
</html>
