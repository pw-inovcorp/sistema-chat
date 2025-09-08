<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-white shadow-sm rounded-lg h-96">
                <div class="flex h-full">

                    <div class="w-80 border-r bg-gray-50 p-4">
                        <h3 class="font-semibold mb-3">Salas</h3>
                        <div class="space-y-2 mb-6">
                            @forelse($rooms as $room)
                                <a href="{{ route('chat.room', $room) }}"
                                   class="block p-2 hover:bg-gray-100 rounded text-gray-700 hover:text-gray-900">
                                    # {{ $room->name }}
                                </a>
                            @empty
                                <p class="text-gray-500 text-sm">Sem salas no momento</p>
                            @endforelse
                        </div>

                        <h3 class="font-semibold mb-3">Users online</h3>
                        <div class="space-y-2">
                            @forelse($onlineUsers as $user)
                                <a href="{{ route('chat.direct', $user) }}"
                                   class="p-2 hover:bg-gray-100 rounded flex items-center text-gray-700">
                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                    {{ $user->name }}
                                </a>
                            @empty
                                <p class="text-gray-500 text-sm">Sem users online</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="flex-1 flex flex-col">
                        <div class="flex-1 flex items-center justify-center text-gray-500">
                            <div class="text-center">
                                <h3 class="text-lg font-medium mb-2">Bem-vindo ao chat</h3>
                                <p class="text-sm">Escolhe uma sala ou um user para começar</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
