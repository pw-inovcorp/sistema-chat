<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Room;
use App\Models\Message;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class RoomChat extends Component
{
    use WithFileUploads;

    public $room;
    public $newMessage = '';
    public $messages = [];
    public $messageInputKey = 0;
    public $selectedImage = null;

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
        $rules = [];

        if ($this->selectedImage) {
            $rules['selectedImage'] = 'required|image|mimes:jpeg,png,jpg,gif|max:5120'; // 5MB
        } else {
            $rules['newMessage'] = 'required|string|max:500';
        }

        $this->validate($rules);

        $messageData = [
            'user_id' => auth()->id(),
            'room_id' => $this->room->id,
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
        return view('livewire/room-chat');
    }
}
