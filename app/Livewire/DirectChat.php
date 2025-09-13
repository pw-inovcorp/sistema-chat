<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Message;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class DirectChat extends Component
{
    use WithFileUploads;

    public $user;
    public $newMessage = '';
    public $messages = [];
    public $messageInputKey = 0;

    public $selectedImage = null;


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
        $rules = [];

        if ($this->selectedImage) {
            $rules['selectedImage'] = 'required|image|mimes:jpeg,png,jpg,gif|max:5120';
        } else {
            $rules['newMessage'] = 'required|string|max:500';
        }

        $this->validate($rules);

        $messageData = [
            'user_id' => auth()->id(),
            'recipient_id' => $this->user->id,
            'room_id' => null
        ];

        if ($this->selectedImage) {
            $imagePath = $this->selectedImage->store('chat-images', 'public');
            $messageData['image_path'] = $imagePath;
            $messageData['message_type'] = 'image';
            $messageData['content'] = $this->newMessage;
        } else {
            $messageData['content'] = $this->newMessage;
            $messageData['message_type'] = 'text';
        }

        Message::create($messageData);

        $this->resetValidation();
        $this->newMessage = '';
        $this->selectedImage = null;
        $this->messageInputKey++;
        $this->loadMessages();

        $this->dispatch('scroll-to-bottom');
    }

    public function removeImage()
    {
        $this->selectedImage = null;
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
