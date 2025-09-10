<div class="flex flex-col h-full" wire:poll.3s="refreshChat">

    <div class="border-b p-4 ">
        <div class="flex items-center justify-between">
            <h3 class="font-semibold text-lg">@ {{ $user->name }}</h3>
        </div>
    </div>

    <div id="messages-container"  class="flex-1 overflow-y-auto p-4 space-y-3"
         style="max-height: calc(100vh - 200px);">

        @forelse($messages as $message)
            <div class="flex space-x-3">
                @if($message['user']['avatar'])
                    <img src="{{ asset('storage/' . $message['user']['avatar']) }}"
                         alt="{{ $message['user']['name'] }}"
                         class="w-8 h-8 rounded-full flex-shrink-0">
                @else
                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-xs font-medium">
                        {{ substr($message['user']['name'], 0, 1) }}
                    </div>
                @endif

                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-1">
                        <span class="font-medium text-sm">{{ $message['user']['name'] }}</span>
                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($message['created_at'])->format('d/m/Y H:i') }}</span>
                    </div>
                    <p class="text-sm mt-1">{{ $message['content'] }}</p>
                </div>
            </div>
        @empty
            <div class="flex items-center justify-center h-full text-gray-500">
                <p>Sem mensagens no momento</p>
            </div>
        @endforelse
    </div>


    <div class="border-t p-4">
        <form wire:submit="sendMessage" class="flex space-x-4">
            <input type="text"
                   wire:model="newMessage"
                   wire:key="message-input-{{ $messageInputKey }}"
                   placeholder="Escreva algo..."
                   class="flex-1 border border-gray-300 rounded-lg px-4 py-2"
                   autocomplete="off">

            <button type="submit"
                    wire:loading.attr="disabled"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">

                <span wire:loading.remove wire:target="sendMessage">Enviar</span>
                <span wire:loading wire:target="sendMessage">Enviando...</span>
            </button>
        </form>

        @error('newMessage')
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('messages-container');
        if (!container) return;

        // Scroll inicial
        container.scrollTop = container.scrollHeight;

        // Evento Livewire
        if (typeof Livewire !== 'undefined') {
            window.addEventListener('scroll-to-bottom', () => {
                setTimeout(() => {
                    container.scrollTop = container.scrollHeight;
                }, 50);
            });
        }
    });
</script>

