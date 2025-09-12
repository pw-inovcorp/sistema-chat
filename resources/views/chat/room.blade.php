<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }} - # {{ $room->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-white shadow-sm rounded-lg h-128">
                <div class="flex h-full">

                    <div class="w-80 border-r bg-gray-50 p-4">
                        <h3 class="font-semibold mb-3">Salas</h3>
                        <div class="space-y-2 mb-6 max-h-48 overflow-y-auto">
                            @foreach($rooms as $r)
                                <a href="{{ route('chat.room', $r) }}"
                                   class="p-2 rounded flex items-center
                                    {{ $r->id === $room->id ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">

                                    @if($r->avatar)
                                        <img src="{{ asset('storage/' . $r->avatar) }}"
                                             alt="{{ $r->name }}"
                                             class="w-7 h-7 rounded-full mr-2">
                                    @else
                                        <div class="w-7 h-7 bg-gray-300 rounded-full flex items-center justify-center mr-2">
                                            <span class="text-xs">#</span>
                                        </div>
                                    @endif

                                    {{ $r->name }}
                                </a>
                            @endforeach
                        </div>

                        <h3 class="font-semibold mb-3">Users Online</h3>
                        <div class="max-h-40 overflow-y-auto p-2 space-y-2">
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

                        @livewire('room-chat', ['room' => $room])

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
