<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800 dark:text-gray-200">Name</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800 dark:text-gray-200">Email</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800 dark:text-gray-200">Country</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->country }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800 dark:text-gray-200">Region</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->region }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800 dark:text-gray-200">Ward</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->ward }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800 dark:text-gray-200">Street</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->street }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="bg-gray-50 px-6 py-4">
                <a href="{{ route('admin.users.showEditForm', $user) }}" class="inline-block px-4 py-2 bg-green-500 text-white font-bold rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Edit User
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 -mr-1 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.825 16.175a3.5 3.5 0 0 1-5 0l-4.5-4.5a3.5 3.5 0 0 1 0-5l1.825-1.825a1 1 0 0 1 1.414 1.414l-4.5 4.5a1 1 0 0 0 0 1.414l1.825 1.825z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.25 8.25l-4.5 4.5a2 2 0 0 1-2.828 0l-1.75-1.75a2 2 0 0 1 0-2.828z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
