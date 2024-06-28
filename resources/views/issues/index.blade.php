<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-3xl font-bold mb-6">All Public Issues</h1>
                    <div class="mb-6 flex items-center justify-between">
                        <div class="flex ml-4 space-x-2">
                            <a href="{{ route('issues.create') }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-700">Report Anonymously</a>
                        </div>

                        <form method="GET" action="{{ route('issues.index') }}" class="flex w-full max-w-md">
                            <input type="text" name="search" placeholder="Search issues..." class="w-full border border-gray-300 rounded-l px-4 py-2 dark:text-gray-800">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r hover:bg-blue-700">Search</button>
                        </form>
                        
                    </div>
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <ul class="divide-y divide-gray-200">
                            @forelse($issues as $issue)
                                <li class="px-4 py-4 sm:px-6">
                                    <a href="{{ route('issues.show', $issue) }}" class="block hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div class="text-sm font-medium text-indigo-600 truncate">
                                                {{ $issue->title }}
                                            </div>
                                            <div class="ml-2 flex-shrink-0 flex">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $issue->status == 'open' ? 'bg-green-100 text-green-800' : ($issue->status == 'inprogress' ? 'bg-yellow-100 text-yellow-800' : ($issue->status == 'resolved' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                                    {{ $issue->status }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mt-2 sm:flex sm:justify-between">
                                            <div class="sm:flex">
                                                <div class="mr-6 flex items-center text-sm text-gray-500">
                                                    <p>{{ $issue->description }}</p>
                                                </div>
                                            </div>
                                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                                <p>{{ $issue->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="px-4 py-4 sm:px-6">
                                    <div class="text-sm text-gray-500">No issues found.</div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
