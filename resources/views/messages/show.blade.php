<x-app-layout>
<x-slot name="header">Message</x-slot>

<div class="py-8 max-w-2xl mx-auto px-6 space-y-5">

    {{-- Flash --}}
    @if(session('success'))
        <div class="flex items-center gap-3 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('messages.inbox') }}"
       class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
        </svg>
        Back to Inbox
    </a>

    {{-- Message --}}
    <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6 space-y-4">
        <div class="border-b border-gray-100 pb-4">
            <h1 class="text-lg font-bold text-gray-900">{{ $message->subject }}</h1>
            <div class="mt-2 flex items-center gap-4 text-xs text-gray-400">
                <span>From: <span class="font-medium text-gray-600">{{ $message->sender->name }}</span> ({{ ucfirst($message->sender->role) }})</span>
                <span>To: <span class="font-medium text-gray-600">{{ $message->receiver->name }}</span></span>
                <span>{{ $message->created_at->format('M d, Y \a\t g:i A') }}</span>
            </div>
        </div>

        <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $message->body }}</div>
    </div>

    {{-- Reply form --}}
    @php $userId = auth()->user()->id; @endphp
    @if($message->receiver_id === $userId || $message->sender_id === $userId)
    <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6">
        <h2 class="text-sm font-semibold text-gray-700 mb-4">Reply</h2>
        <form method="POST" action="{{ route('messages.reply', $message) }}" class="space-y-4">
            @csrf
            <textarea name="body" rows="5" maxlength="5000"
                      placeholder="Write your reply…"
                      class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-amber-500 focus:outline-none resize-none">{{ old('body') }}</textarea>
            @error('body') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
            <div class="flex justify-end">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-amber-600 px-5 py-2 text-sm font-medium text-white hover:bg-amber-700 transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.269 20.876L5.999 12zm0 0h7.5"/>
                    </svg>
                    Send Reply
                </button>
            </div>
        </form>
    </div>
    @endif

</div>
</x-app-layout>
