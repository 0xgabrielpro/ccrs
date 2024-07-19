<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <br>
    <div class="container mx-auto">
        <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4">
                <h2 class="text-2xl font-semibold mb-2">Edit User</h2>
                @include('components.form', [
                    'action' => route('admin.users.update', $user->id),
                    'method' => 'PUT',
                    'buttonText' => 'Update User',
                    'leaders' => $leaders,
                    'user' => $user
                ])
            </div>
        </div>
    </div>
</x-app-layout>
