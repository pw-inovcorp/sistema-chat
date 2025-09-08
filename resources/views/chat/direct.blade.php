<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }} - @ {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-white shadow-sm rounded-lg h-96">
                <div class="flex h-full">

                    <div class="w-80 border-r bg-gray-50 p-4">
                        <h3 class="font-semibold mb-3">Salas</h3>
                        <div class="space-y-2 mb-6">
                            @foreach($rooms as $room)
                                <a href="{{ route('chat.room', $room) }}"
                                   class="block p-2 hover:bg-gray-100 rounded text-gray-700">
                                    # {{ $room->name }}
                                </a>
                            @endforeach
                        </div>

                        <h3 class="font-semibold mb-3">Users Online</h3>
                        <div class="space-y-2">
                            @foreach($onlineUsers as $u)
                                <a href="{{ route('chat.direct', $u) }}"
                                   class="p-2 rounded flex items-center
                                          {{ $u->id == $user->id ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100 text-gray-700' }}">
                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                    {{ $u->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>


                    <div class="flex-1 flex flex-col">

                        <div class="border-b p-4">
                            <h3 class="font-semibold">@ {{ $user->name }}</h3>
                        </div>

                        <!-- WIP -->
                        <div class="flex-1 overflow-y-auto">
                            @forelse($messages as $message)

                            @empty
                                <div class="flex items-center justify-center h-full text-gray-500">
                                    <p>Sem mensagens no momento</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="border-t p-4">
                            <div class="flex space-x-4">
                                <input type="text"
                                       placeholder="Escreva algo..."
                                       class="flex-1 border border-gray-300 rounded-md px-3 py-2"
                                       disabled>
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md" disabled>
                                    Enviar
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
