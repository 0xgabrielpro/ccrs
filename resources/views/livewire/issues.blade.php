<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-3xl font-bold">My Issues</h1>
                    <a href="{{ route('issues.create') }}" class="px-4 py-2 bg-indigo-500 text-white font-bold rounded-lg shadow-sm hover:bg-indigo-700">Create Issue</a>
                </div>
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <ul class="divide-y divide-gray-200">
                        @forelse($issues as $issue)
                            <a href="{{ route('issues.show', $issue) }}" class="block hover:bg-gray-50 dark:hover:bg-gray-700">
                                <li class="px-4 py-4 sm:px-6">
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
                                </li>
                            </a>
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
