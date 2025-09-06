<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar User') }} - {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nome')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="permission" :value="__('Permissão')" />
                            <select id="permission" name="permission" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="user" {{ old('permission', $user->permission) === 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('permission', $user->permission) === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <x-input-error :messages="$errors->get('permission')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="password" :value="__('Password (Deixar em branco para usar o atual)')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="password_confirmation" :value="__('Confirmar Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-3 pt-4">
                            <x-secondary-button type="button" onclick="window.location='{{ route('admin.users.index') }}'">
                                {{ __('Cancelar') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Atualizar User') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
