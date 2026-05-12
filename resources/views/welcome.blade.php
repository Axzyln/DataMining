<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BakersGoods — AI-Powered Platform for Bakers</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-amber-50 font-sans antialiased">

    {{-- Nav --}}
    <nav class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <span class="text-2xl leading-none">🍞</span>
            <span class="text-xl font-bold text-amber-700">BakersGoods</span>
        </div>
        <div class="flex items-center gap-3">
            @auth
                <span class="hidden sm:block text-sm text-gray-500">
                    Signed in as <span class="font-medium text-gray-700">{{ Auth::user()->name }}</span>
                </span>
                <a href="{{ route('dashboard') }}"
                   class="rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-700 transition-colors">
                    Go to Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                        Sign Out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Sign In
                </a>
                <a href="{{ route('register') }}"
                   class="rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-700 transition-colors">
                    Register
                </a>
            @endauth
        </div>
    </nav>

    {{-- Hero --}}
    <section class="max-w-4xl mx-auto px-6 py-24 text-center">
        <h1 class="text-5xl font-bold text-amber-900 leading-tight mb-6">
            Reliable Goods.<br>Smart Decisions.<br>Better Bakeries.
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-10">
            BakersGoods is an AI-powered platform that centralizes baking ingredient
            availability, analyzes daily sales, and recommends what to bake next.
        </p>
        @auth
            <a href="{{ route('dashboard') }}"
               class="inline-block rounded-lg bg-amber-600 text-white text-base font-semibold px-8 py-3.5 hover:bg-amber-700 transition-colors shadow-sm">
                Go to Dashboard
            </a>
        @else
            <div class="flex items-center justify-center gap-3">
                <a href="{{ route('register') }}"
                   class="inline-block rounded-lg bg-amber-600 text-white text-base font-semibold px-8 py-3.5 hover:bg-amber-700 transition-colors shadow-sm">
                    Get Started
                </a>
                <a href="{{ route('login') }}"
                   class="inline-block rounded-lg border border-gray-300 bg-white text-gray-700 text-base font-medium px-8 py-3.5 hover:bg-gray-50 transition-colors">
                    Sign In
                </a>
            </div>
        @endauth
    </section>

    {{-- Feature cards --}}
    <section class="max-w-6xl mx-auto px-6 pb-20 grid md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-3xl mb-3">🔍</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Centralized Ingredients</h3>
            <p class="text-sm text-gray-500 leading-relaxed">Find baking ingredients across all verified vendors in one searchable dashboard.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-3xl mb-3">📊</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Sales Analytics</h3>
            <p class="text-sm text-gray-500 leading-relaxed">Track daily sales, identify trends, and monitor inventory levels in real time.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-3xl mb-3">🤖</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">AI Recommendations</h3>
            <p class="text-sm text-gray-500 leading-relaxed">Get intelligent suggestions for what to bake next based on your inventory and sales history.</p>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-gray-200 bg-white py-6 text-center text-xs text-gray-400">
        © {{ date('Y') }} BakersGoods · Cebu Technological University Capstone Project
    </footer>

</body>
</html>
