<x-app-layout>
<x-slot name="header">Compose Message</x-slot>

<div class="py-8 max-w-2xl mx-auto px-6">

    <a href="{{ route('messages.inbox') }}"
       class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 mb-6">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
        </svg>
        Back to Inbox
    </a>

    <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6">
        <form method="POST" action="{{ route('messages.send') }}" class="space-y-5">
            @csrf

            {{-- To --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">To</label>
                <select name="receiver_id"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-amber-500 focus:outline-none">
                    <option value="">Select recipient…</option>
                    @foreach($recipients as $recipient)
                        <option value="{{ $recipient->id }}"
                            {{ (old('receiver_id', $toUser?->id) == $recipient->id) ? 'selected' : '' }}>
                            {{ $recipient->name }} ({{ ucfirst($recipient->role) }})
                        </option>
                    @endforeach
                </select>
                @error('receiver_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Subject --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Subject</label>
                <input type="text" name="subject" value="{{ old('subject', $subject) }}" maxlength="200"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-amber-500 focus:outline-none">
                @error('subject') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Body --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Message</label>
                <textarea name="body" rows="7" maxlength="5000"
                          class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-amber-500 focus:outline-none resize-none">{{ old('body') }}</textarea>
                @error('body') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('messages.inbox') }}"
                   class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-amber-600 px-5 py-2 text-sm font-medium text-white hover:bg-amber-700 transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.269 20.876L5.999 12zm0 0h7.5"/>
                    </svg>
                    Send Message
                </button>
            </div>
        </form>
    </div>

</div>
</x-app-layout>
