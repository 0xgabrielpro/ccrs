<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-3xl font-bold">Leader's tagged Issues</h1>
                    </div>
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
                        <h2 class="text-2xl font-semibold mb-4">Issues</h2>
                        <ul class="divide-y divide-gray-200">
                            @forelse($issues as $issue)
                                <a href="{{ route('issues.show', $issue) }}" class="block hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <li class="px-4 py-4 sm:px-6 {{ $issue->read_at ? 'bg-gray-100' : 'bg-white' }}">
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
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <h2 class="text-2xl font-semibold mb-4">Anonymous Issues</h2>
                        <ul class="divide-y divide-gray-200">
                            @forelse($anonIssues as $anonIssue)
                                <a href="{{ route('anon-issues.show', $anonIssue) }}" class="block hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <li class="px-4 py-4 sm:px-6 {{ $anonIssue->read_at ? 'bg-gray-100' : 'bg-white' }}">
                                        <div class="flex items-center justify-between">
                                            <div class="text-sm font-medium text-indigo-600 truncate">
                                                {{ $anonIssue->title }}
                                            </div>
                                            <div class="ml-2 flex-shrink-0 flex">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $anonIssue->status == 'open' ? 'bg-green-100 text-green-800' : ($anonIssue->status == 'inprogress' ? 'bg-yellow-100 text-yellow-800' : ($anonIssue->status == 'resolved' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                                    {{ $anonIssue->status }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mt-2 sm:flex sm:justify-between">
                                            <div class="sm:flex">
                                                <div class="mr-6 flex items-center text-sm text-gray-500">
                                                    <p>{{ $anonIssue->description }}</p>
                                                </div>
                                            </div>
                                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                                <p>Created at: {{ $anonIssue->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                    </li>
                                </a>
                            @empty
                                <li class="px-4 py-4 sm:px-6">
                                    <div class="text-sm text-gray-500">No anonymous issues found.</div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
