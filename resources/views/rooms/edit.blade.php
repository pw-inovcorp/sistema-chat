<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Sala') }} - {{ $room->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('rooms.update', $room) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nome')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $room->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="avatar" :value="__('Avatar')" />

                            @if($room->avatar)
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-2">Avatar atual:</p>
                                    <img src="{{ asset('storage/' . $room->avatar) }}"
                                         alt="{{ $room->name }}"
                                         class="w-16 h-16 object-cover">
                                </div>
                            @endif

                            <input id="avatar" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2" type="file" name="avatar" accept="image/*" />
                            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">
                                @if($room->avatar)
                                    Deixe em branco para manter o avatar atual. JPG, PNG, GIF até 2MB
                                @else
                                    Opcional. JPG, PNG, GIF até 2MB
                                @endif
                            </p>
                        </div>

                        <div class="flex items-center justify-between pt-4">
                            <div class="flex items-center gap-3">
                                <x-secondary-button onclick="window.location='{{ route('rooms.index') }}'">
                                    {{ __('Cancelar') }}
                                </x-secondary-button>
                                <x-primary-button>
                                    {{ __('Atualizar Sala') }}
                                </x-primary-button>
                            </div>

                            <form method="POST" action="{{ route('rooms.destroy', $room) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <x-primary-button
                                    class="bg-red-600 hover:bg-red-700 focus:ring-red-500 active:bg-red-900"
                                    onclick="return confirm(&quot;Tem certeza que deseja deletar a sala '{{ $room->name }}'? Esta ação não pode ser desfeita.&quot;)">
                                    Apagar
                                </x-primary-button>
                            </form>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
