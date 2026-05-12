<?php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function inbox()
    {
        $messages = Message::where('receiver_id', auth()->user()->id)
            ->with('sender:id,name,role')
            ->orderByDesc('created_at')
            ->paginate(15);

        $unreadCount = Message::where('receiver_id', auth()->user()->id)
            ->whereNull('read_at')
            ->count();

        return view('messages.inbox', compact('messages', 'unreadCount'));
    }

    public function sent()
    {
        $messages = Message::where('sender_id', auth()->user()->id)
            ->with('receiver:id,name,role')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('messages.sent', compact('messages'));
    }

    public function compose(Request $request)
    {
        $toUser  = null;
        $subject = $request->query('subject', '');

        if ($request->has('to')) {
            $toUser = User::find($request->query('to'));
        }

        // Bakers can message vendors; vendors can message bakers; everyone can message admin
        $recipients = $this->getRecipients();

        return view('messages.compose', compact('toUser', 'subject', 'recipients'));
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => ['required', 'exists:users,id'],
            'subject'     => ['required', 'string', 'max:200'],
            'body'        => ['required', 'string', 'max:5000'],
        ]);

        if ((int) $data['receiver_id'] === auth()->user()->id) {
            return back()->withErrors(['receiver_id' => 'You cannot message yourself.'])->withInput();
        }

        Message::create([
            'sender_id'   => auth()->user()->id,
            'receiver_id' => $data['receiver_id'],
            'subject'     => $data['subject'],
            'body'        => $data['body'],
        ]);

        return redirect()->route('messages.sent')
            ->with('success', 'Message sent successfully.');
    }

    public function show(Message $message)
    {
        $userId = auth()->user()->id;

        if ($message->sender_id !== $userId && $message->receiver_id !== $userId) {
            abort(403);
        }

        if ($message->receiver_id === $userId && !$message->read_at) {
            $message->update(['read_at' => now()]);
        }

        return view('messages.show', compact('message'));
    }

    public function reply(Request $request, Message $message)
    {
        $userId = auth()->user()->id;

        if ($message->sender_id !== $userId && $message->receiver_id !== $userId) {
            abort(403);
        }

        $data = $request->validate(['body' => ['required', 'string', 'max:5000']]);

        $replyTo = $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;

        Message::create([
            'sender_id'   => $userId,
            'receiver_id' => $replyTo,
            'subject'     => 'Re: ' . ltrim(preg_replace('/^Re:\s*/i', '', $message->subject)),
            'body'        => $data['body'],
        ]);

        return redirect()->route('messages.inbox')
            ->with('success', 'Reply sent.');
    }

    private function getRecipients(): \Illuminate\Support\Collection
    {
        $user = auth()->user();

        return User::where('id', '!=', $user->id)
            ->when($user->isBaker(), fn($q) => $q->whereIn('role', ['vendor', 'admin']))
            ->when($user->isVendor(), fn($q) => $q->whereIn('role', ['baker', 'admin']))
            ->when($user->isAdmin(), fn($q) => $q)
            ->orderBy('role')
            ->orderBy('name')
            ->get(['id', 'name', 'role']);
    }
}
