<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar Sala') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('rooms.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nome')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>


                        <div class="mb-4">
                            <x-input-label for="avatar" :value="__('Avatar')" />
                            <input id="avatar" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2"  type="file" name="avatar" accept="image/*" />
                            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Opcional. JPG, PNG, GIF até 2MB</p>
                        </div>


                        <div class="flex items-center gap-3 pt-4">
                            <x-secondary-button onclick="window.location='{{ route('rooms.index') }}'">
                                {{ __('Cancelar') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Criar Sala') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

