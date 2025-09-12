<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }} - @ {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-white shadow-sm rounded-lg h-128">
                <div class="flex h-full">

                    <div class="w-80 border-r bg-gray-50 p-4">
                        <h3 class="font-semibold mb-3">Salas</h3>
                        <div class="space-y-2 mb-6 max-h-48 overflow-y-auto">
                            @foreach($rooms as $room)
                                <a href="{{ route('chat.room', $room) }}"
                                   class="p-2 hover:bg-gray-100 rounded text-gray-700 flex items-center">

                                    @if($room->avatar)
                                        <img src="{{ asset('storage/' . $room->avatar) }}"
                                             alt="{{ $room->name }}"
                                             class="w-7 h-7 rounded-full mr-2 object-cover">
                                    @else
                                        <div class="w-7 h-7 bg-gray-300 rounded-full flex items-center justify-center mr-2">
                                            <span class="text-xs">#</span>
                                        </div>
                                    @endif

                                    {{ $room->name }}
                                </a>
                            @endforeach
                        </div>

                        <h3 class="font-semibold mb-3">Users Online</h3>
                        <div class="max-h-40 overflow-y-auto p-2 space-y-2">
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

{{--                        <div class="border-b p-4">--}}
{{--                            <h3 class="font-semibold">@ {{ $user->name }}</h3>--}}
{{--                        </div>--}}

{{--                        <!-- WIP -->--}}
{{--                        <div class="flex-1 overflow-y-auto p-4 space-y-3">--}}
{{--                            @forelse($messages as $message)--}}
{{--                                <div class="flex space-x-3">--}}
{{--                                    @if($message->user->avatar)--}}
{{--                                        <img src="{{ asset('storage/' . $message->user->avatar) }}"--}}
{{--                                             alt="{{ $message->user->name }}"--}}
{{--                                             class="w-8 h-8 rounded-full">--}}
{{--                                    @else--}}
{{--                                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-xs font-medium">--}}
{{--                                            {{ substr($message->user->name, 0, 1) }}--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                    <div class="flex-1">--}}
{{--                                        <div class="flex items-center space-x-2">--}}
{{--                                            <span class="font-medium text-sm">{{ $message->user->name }}</span>--}}
{{--                                            <span class="text-xs text-gray-500">{{ $message->created_at}}</span>--}}
{{--                                        </div>--}}
{{--                                        <p class="text-sm mt-1">{{ $message->content }}</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @empty--}}
{{--                                <div class="flex items-center justify-center h-full text-gray-500">--}}
{{--                                    <p>Sem mensagens no momento</p>--}}
{{--                                </div>--}}
{{--                            @endforelse--}}
{{--                        </div>--}}

{{--                        <div class="border-t p-4">--}}
{{--                            <form method="POST" action="{{ route('chat.direct.send', $user) }}" class="flex space-x-2">--}}
{{--                                @csrf--}}
{{--                                <input type="text"--}}
{{--                                       name="content"--}}
{{--                                       placeholder="Escreva algo..."--}}
{{--                                       class="flex-1 border border-gray-300 rounded-md px-3 py-2"--}}
{{--                                       required--}}
{{--                                       maxlength="500">--}}
{{--                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">--}}
{{--                                    Enviar--}}
{{--                                </button>--}}
{{--                            </form>--}}

{{--                            @error('content')--}}
{{--                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}
                        @livewire('direct-chat', ['user' => $user])
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
