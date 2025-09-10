<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Message;
use Livewire\Attributes\On;

class DirectChat extends Component
{

    public $user;
    public $newMessage = '';
    public $messages = [];
    public $messageInputKey = 0;


    public function mount(User $user)
    {
        $this->user = $user;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = Message::where(fn($q) => $q
            ->where('user_id', auth()->id())
            ->where('recipient_id', $this->user->id))
            ->orWhere(fn($q) => $q
                ->where('user_id', $this->user->id)
                ->where('recipient_id', auth()->id())
            )
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
            'recipient_id' => $this->user->id,
            'room_id' => null
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
        return view('livewire.direct-chat');
    }
}
