<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Issues</h1>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <ul class="divide-y divide-gray-200">
            @foreach($issues as $issue)
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
                        <p>Created at: {{ $issue->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
