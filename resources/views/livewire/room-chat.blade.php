<div class="flex flex-col h-full" wire:poll.3s="refreshChat">

    <div class="border-b p-4">
        <div class="flex items-center justify-between">
            <h3 class="font-semibold text-lg"># {{ $room->name }}</h3>
            <div class="text-sm text-gray-500">
                {{ $room->users()->count() }} membros
            </div>
        </div>
    </div>

    <div id="messages-container" class="flex-1 overflow-y-auto p-4 space-y-3 min-h-0">

        @forelse($messages as $message)
            <div class="flex {{ $message['user']['id'] === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="flex {{ $message['user']['id'] === auth()->id() ? 'flex-row-reverse' : '' }}">
                    @if($message['user']['avatar'])
                        <img src="{{ asset('storage/' . $message['user']['avatar']) }}"
                             alt="{{ $message['user']['name'] }}"
                             class="w-8 h-8 rounded-full flex-shrink-0">
                    @else
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-xs font-medium">
                            {{ substr($message['user']['name'], 0, 1) }}
                        </div>
                    @endif

                    <div class="flex-1 max-w-sm {{ $message['user']['id'] === auth()->id() ? 'mr-3' : 'ml-3' }}">
                        <div class="flex items-center space-x-2 mb-1 {{ $message['user']['id'] === auth()->id() ? 'flex-row-reverse space-x-reverse' : '' }}">
                            <span class="font-medium text-sm">{{ $message['user']['name'] }}</span>
                            <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($message['created_at'])->format('d/m/Y H:i') }}</span>
                        </div>

                        @if($message['message_type'] === 'image')
                            <div class="bg-gray-200 p-2 rounded-lg">
                                <img src="{{ asset('storage/' . $message['image_path']) }}"
                                     alt="Imagem enviada"
                                     class="max-w-full h-auto rounded cursor-pointer">
                                @if($message['content'])
                                    <p class="text-xs text-gray-600 mt-1 break-words">{{ $message['content'] }}</p>
                                @endif
                            </div>
                        @else
                            @if($message['content'])
                                <div class="bg-gray-200 p-2 rounded-lg max-w-full">
                                    <p class="text-sm break-words">{{ $message['content'] }}</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="flex items-center justify-center h-full text-gray-500">
                <p>Sem mensagens no momento</p>
            </div>
        @endforelse
    </div>


    <div class="border-t p-4">
        @if($selectedImage)
            <div class="mb-4 p-3 bg-gray-100 rounded-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="{{ $selectedImage->temporaryUrl() }}"
                             alt="Preview"
                             class="w-16 h-16  rounded">
                        <span class="ml-3 text-sm text-gray-600">Imagem pronta para enviar</span>
                    </div>
                    <button wire:click="removeImage"
                            class="text-red-600 hover:text-red-800">
                        Remover
                    </button>
                </div>
            </div>
        @endif

        <form wire:submit="sendMessage" class="flex space-x-4">
            <input type="text"
                   wire:model="newMessage"
                   wire:key="message-input-{{ $messageInputKey }}"
                   placeholder="{{ $selectedImage ? 'Comentário opcional...' : 'Escreva algo...' }}"
                   class="flex-1 border border-gray-300 rounded-lg px-4 py-2"
                {{ $selectedImage ? '' : 'required' }}>

            <input type="file"
                   wire:model="selectedImage"
                   accept="image/*"
                   id="imageInput"
                   class="hidden">

            <label for="imageInput"
                   class="cursor-pointer bg-gray-600 text-white px-3 py-2 rounded-lg hover:bg-gray-700">
                Upload
            </label>

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

        @error('selectedImage')
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
