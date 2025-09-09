<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\Room;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = auth()->user()->rooms()->get();

        $onlineUsers = User::where('id', '!=', auth()->id())
            ->where('status', 'online')
            ->get();

        return view('chat/index', ['rooms' => $rooms, 'onlineUsers' => $onlineUsers]);
    }

    public function showRoom(Room $room)
    {
        if (!$room->users()->where('user_id', auth()->id())->exists()) {
            abort(403, 'Não tem permissão para entrar nesta sala');
        }

        $rooms = auth()->user()->rooms()->get();
        $onlineUsers = User::where('id', '!=', auth()->id())
            ->where('status', 'online')
            ->get();

        $messages = $room->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->limit(100)
            ->get();

        return view('chat/room', ['rooms' => $rooms, 'onlineUsers' => $onlineUsers, 'messages' => $messages, 'room' => $room]);
    }

    public function showDirectMessages(User $user)
    {
        $rooms = auth()->user()->rooms()->get();
        $onlineUsers = User::where('id', '!=', auth()->id())
            ->where('status', 'online')
            ->get();

        // Mensagens diretas entre os dois users
        $messages = Message::where(fn($q) => $q
            ->where('user_id', auth()->id())
            ->where('recipient_id', $user->id))
            ->orWhere(fn($q) => $q
                ->where('user_id', $user->id)
                ->where('recipient_id', auth()->id())
            )
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->limit(100)
            ->get();

        return view('chat/direct', ['rooms' => $rooms, 'onlineUsers' => $onlineUsers, 'messages' => $messages, 'user' => $user]);
    }

    public function sendRoomMessage(Request $request, Room $room)
    {
        if (!$room->users()->where('user_id', auth()->id())->exists()) {
            abort(403, 'Não tem permissão para entrar nesta sala');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $message = Message::create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'room_id' => $room->id,
        ]);

        return redirect()->route('chat.room', $room);
    }

    public function sendDirectMessage(Request $request, User $user)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $message = Message::create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'recipient_id' => $user->id,
        ]);

        return redirect()->route('chat.direct', $user);
    }
}

