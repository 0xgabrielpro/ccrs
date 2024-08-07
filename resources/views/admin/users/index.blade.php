<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <br>
    <div class="container mx-auto">
        <!-- Add User Button -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white font-bold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Add User
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 -mr-1 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($users as $user)
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="mb-4">
                    <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->email }}</p>
                </div>
                <div>
                    <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold uppercase mr-2">{{ $user->role }}</span>
                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('admin.users.show', $user) }}" class="text-blue-500 hover:underline mr-2">View</a>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 hover:underline mr-2">Edit</a>                        
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
