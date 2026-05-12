<x-app-layout>
<x-slot name="header">System Settings</x-slot>

<div class="py-8 max-w-3xl mx-auto px-6 space-y-6">

    {{-- Flash --}}
    @foreach(['success' => 'green', 'error' => 'red'] as $type => $color)
        @if(session($type))
            <div class="flex items-center gap-3 rounded-lg bg-{{ $color }}-50 border border-{{ $color }}-200 px-4 py-3 text-sm text-{{ $color }}-800">
                {{ session($type) }}
            </div>
        @endif
    @endforeach

    <form method="POST" action="{{ route('admin.settings.save') }}" class="space-y-6">
        @csrf @method('PUT')

        {{-- General --}}
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6 space-y-5">
            <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-3">General</h2>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Application Name</label>
                <input type="text" name="app_name" value="{{ old('app_name', $settings['app_name']) }}"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-amber-500 focus:outline-none">
                @error('app_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">AI Max Recommendations per Generation</label>
                <input type="number" name="ai_max_recommendations" min="1" max="20"
                       value="{{ old('ai_max_recommendations', $settings['ai_max_recommendations']) }}"
                       class="w-32 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-amber-500 focus:outline-none">
                <p class="mt-1 text-xs text-gray-400">Number of AI product recommendations generated per request (1–20).</p>
                @error('ai_max_recommendations') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Registration --}}
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-3">Registration Controls</h2>

            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="allow_baker_registration" value="1"
                       {{ $settings['allow_baker_registration'] === '1' ? 'checked' : '' }}
                       class="h-4 w-4 rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                <div>
                    <div class="text-sm font-medium text-gray-800">Allow Baker Registration</div>
                    <div class="text-xs text-gray-400">When unchecked, new bakers cannot self-register.</div>
                </div>
            </label>

            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="allow_vendor_registration" value="1"
                       {{ $settings['allow_vendor_registration'] === '1' ? 'checked' : '' }}
                       class="h-4 w-4 rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                <div>
                    <div class="text-sm font-medium text-gray-800">Allow Vendor Registration</div>
                    <div class="text-xs text-gray-400">When unchecked, new vendors cannot self-register.</div>
                </div>
            </label>
        </div>

        {{-- Maintenance --}}
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-3">System</h2>

            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="maintenance_mode" value="1"
                       {{ $settings['maintenance_mode'] === '1' ? 'checked' : '' }}
                       class="h-4 w-4 rounded border-gray-300 text-red-500 focus:ring-red-400">
                <div>
                    <div class="text-sm font-medium text-gray-800">Maintenance Mode</div>
                    <div class="text-xs text-gray-400">Display a maintenance notice to non-admin users.</div>
                </div>
            </label>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="rounded-lg bg-amber-600 px-5 py-2 text-sm font-medium text-white hover:bg-amber-700 transition-colors">
                Save Settings
            </button>
        </div>
    </form>

</div>
</x-app-layout>
