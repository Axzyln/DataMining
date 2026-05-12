<x-app-layout>
<x-slot name="header">Sent Messages</x-slot>

<div class="py-8 max-w-4xl mx-auto px-6 space-y-5">

    {{-- Toolbar --}}
    <div class="flex items-center justify-between">
        <div class="flex gap-2">
            <a href="{{ route('messages.inbox') }}" class="rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-200 transition-colors">Inbox</a>
            <span class="rounded-lg bg-amber-600 px-3 py-1.5 text-xs font-medium text-white">Sent</span>
        </div>
        <a href="{{ route('messages.compose') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-amber-600 px-4 py-2 text-sm font-medium text-white hover:bg-amber-700 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Compose
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm divide-y divide-gray-100">
        @forelse($messages as $msg)
        <a href="{{ route('messages.show', $msg) }}"
           class="flex items-start gap-4 px-5 py-4 hover:bg-gray-50 transition-colors">
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full
                {{ $msg->receiver->role === 'admin' ? 'bg-purple-100 text-purple-700' : ($msg->receiver->role === 'vendor' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}
                text-xs font-bold">
                {{ strtoupper(substr($msg->receiver->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-baseline justify-between gap-2">
                    <span class="text-sm font-medium text-gray-900 truncate">To: {{ $msg->receiver->name }}</span>
                    <span class="shrink-0 text-xs text-gray-400">{{ $msg->created_at->diffForHumans() }}</span>
                </div>
                <div class="text-sm text-gray-600 truncate">{{ $msg->subject }}</div>
                <div class="text-xs text-gray-400 truncate mt-0.5">{{ Str::limit($msg->body, 80) }}</div>
            </div>
            @if($msg->read_at)
                <span class="shrink-0 text-xs text-green-500">Read</span>
            @else
                <span class="shrink-0 text-xs text-gray-300">Unread</span>
            @endif
        </a>
        @empty
        <div class="px-5 py-14 text-center">
            <p class="text-sm text-gray-400">No sent messages.</p>
        </div>
        @endforelse
    </div>

    <div>{{ $messages->links() }}</div>

</div>
</x-app-layout>
