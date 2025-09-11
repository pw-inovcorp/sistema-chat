<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestão de Salas') }}
            </h2>
            @if(auth()->user()->isAdmin())
                <x-primary-button onclick="window.location='{{ route('rooms.create') }}'">
                    {{ __('Criar Sala') }}
                </x-primary-button>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-alert type="success" />
            <x-alert type="error" />

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Minhas Salas</h3>

                        @forelse($userRooms as $room)
                            <div class="flex items-center justify-between p-3 border rounded-lg mb-3">
                                <div class="flex items-center">
                                    @if($room->avatar)
                                        <img src="{{ asset('storage/' . $room->avatar) }}"
                                             alt="{{ $room->name }}"
                                             class="w-10 h-10 rounded-full mr-3">
                                    @else
                                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-sm">#</span>
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="font-medium">{{ $room->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $room->users()->count() }} membros</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('chat.room', $room) }}"
                                       class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                        Entrar
                                    </a>
                                    <form method="POST" action="{{ route('rooms.leave', $room) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Tem certeza que deseja sair desta sala?')"
                                                class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                            Sair
                                        </button>
                                    </form>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('rooms.edit', $room) }}"
                                           class="bg-gray-600 text-white px-3 py-1 rounded text-sm hover:bg-gray-700">
                                            Editar
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">Ainda não está em nenhuma sala.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Salas Disponíveis</h3>

                        @forelse($availableRooms as $room)
                            <div class="flex items-center justify-between p-3 border rounded-lg mb-3">
                                <div class="flex items-center">
                                    @if($room->avatar)
                                        <img src="{{ asset('storage/' . $room->avatar) }}"
                                             alt="{{ $room->name }}"
                                             class="w-10 h-10 rounded-full mr-3">
                                    @else
                                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-sm">#</span>
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="font-medium">{{ $room->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $room->users()->count() }} membros</p>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('rooms.join', $room) }}">
                                    @csrf
                                    <button type="submit"
                                            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                        Entrar
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">Não há salas disponíveis no momento.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
