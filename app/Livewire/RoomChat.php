<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Room;
use App\Models\Message;
use Livewire\Attributes\On;

class RoomChat extends Component
{

    public $room;
    public $newMessage = '';
    public $messages = [];
    public $messageInputKey = 0;


    public function mount(Room $room)
    {
        if (!$room->users()->where('user_id', auth()->id())->exists()) {
            abort(403, 'Não tem permissão para entrar nesta sala');
        }

        $this->room = $room;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = $this->room->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->limit(100)
            ->get()
            ->toArray();
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|string|max:500',
        ]);

        Message::create([
            'content' => $this->newMessage,
            'user_id' => auth()->id(),
            'room_id' => $this->room->id,
        ]);

        $this->resetValidation();
        $this->newMessage = '';
        $this->messageInputKey++;
        $this->loadMessages();

        $this->dispatch('scroll-to-bottom');
    }

    #[On('refresh-chat')]
    public function refreshChat()
    {

        $oldCount = count($this->messages);
        $this->loadMessages();
        $newCount = count($this->messages);

        if ($newCount > $oldCount) {
            $this->dispatch('scroll-to-bottom');
        }
    }

    public function render()
    {
        return view('livewire/room-chat');
    }
}
