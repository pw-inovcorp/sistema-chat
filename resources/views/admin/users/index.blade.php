{{-- Lista de Users --}}
{{-- Arquivo: resources/views/admin/users/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">

        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800">
                {{ __('Users') }}
            </h2>
            <x-primary-button onclick="window.location='{{ route('admin.users.create') }}'">
                {{ __('Criar User') }}
            </x-primary-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <x-alert type="success" />
                    <x-alert type="error" />

                    @if(auth()->user()->permission === 'admin')
                        <div class="mb-4 p-4">
                            <h4 class="font-medium text-blue-900 mb-2">Link de Convite</h4>
                            <input type="text"
                                   value="{{ route('invite.show',$token) }}"
                                   readonly
                                   class="w-full text-sm border-gray-300 rounded-md bg-gray-50">
                        </div>
                    @endif

                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                        <tr class="bg-gray-50">
                            <th class="border border-gray-300 px-4 py-2 text-left font-semibold">User</th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Email</th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Permissão</th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Estado</th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-3 font-medium">{{ $user->name }}</td>
                                <td class="border border-gray-300 px-4 py-3">{{ $user->email }}</td>
                                <td class="border border-gray-300 px-4 py-3">
                                    @if($user->permission === 'admin')
                                        <span class="bg-yellow-200 text-yellow-700 px-2 py-1 rounded text-sm font-medium">
                                                Admin
                                            </span>
                                    @else
                                        <span class="bg-green-200 text-green-800 px-2 py-1 rounded text-sm font-medium">
                                                User
                                            </span>
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-3">
                                    @if($user->status === 'online')
                                        <span class="bg-green-200 text-green-800 px-2 py-1 rounded text-sm font-medium">
                                                Online
                                            </span>
                                    @else
                                        <span class="bg-gray-200 text-gray-800 px-2 py-1 rounded text-sm font-medium">
                                                Offline
                                            </span>
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-3">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                                    @if ($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @if($users->hasPages())
                        <div class="mt-6">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
