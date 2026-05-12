<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BakersGoods — AI-Powered Platform for Bakers</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-amber-50">
    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-amber-700">🍞 BakersGoods</h1>
        <div class="space-x-3">
            @auth
                <a href="{{ route('dashboard') }}" class="text-amber-700 font-semibold">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-gray-700">Login</a>
                <a href="{{ route('register') }}" class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700">Register</a>
            @endauth
        </div>
    </nav>

    <section class="max-w-5xl mx-auto px-6 py-20 text-center">
        <h2 class="text-5xl font-bold text-amber-900 mb-6">
            Reliable Goods. Smart Decisions. Better Bakeries.
        </h2>
        <p class="text-lg text-gray-700 max-w-3xl mx-auto mb-8">
            BakersGoods is an AI-powered platform that centralizes baking ingredient
            availability, analyzes daily sales, and recommends what to bake next.
        </p>
        <a href="{{ route('register') }}" class="bg-amber-600 text-white text-lg px-8 py-3 rounded-lg hover:bg-amber-700">
            Get Started
        </a>
    </section>

    <section class="max-w-6xl mx-auto px-6 py-12 grid md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-bold text-amber-700 mb-2">🔍 Centralized Ingredients</h3>
            <p class="text-gray-600">Find baking ingredients across all verified vendors in one dashboard.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-bold text-amber-700 mb-2">📊 Daily Analytics</h3>
            <p class="text-gray-600">Track sales, identify trends, and monitor inventory levels in real time.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-bold text-amber-700 mb-2">🤖 AI Recommendations</h3>
            <p class="text-gray-600">Get intelligent suggestions for what to bake based on your inventory and sales.</p>
        </div>
    </section>
</body>
</html>