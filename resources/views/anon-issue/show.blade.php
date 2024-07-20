<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Issue Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="mb-6 flex items-center justify-between">
                        <h1 class="text-3xl font-bold">{{ $anonIssue->title }}</h1>
                        <a href="{{ route('anon-issues.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Back</a>
                    </div>

                    <div class="mb-4">
                        <span class="inline-block px-4 py-2 bg-{{ $anonIssue->status == 'open' ? 'green' : ($anonIssue->status == 'inprogress' ? 'yellow' : ($anonIssue->status == 'resolved' ? 'blue' : 'red')) }}-500 text-white font-bold rounded-lg shadow-sm">{{ ucfirst($anonIssue->status) }}</span>
                    </div>
                    <div class="mb-4">
                        <p class="text-gray-700 dark:text-gray-200">{{ $anonIssue->description }}</p>
                    </div>

                    @if($anonIssue->file_path)
                        <div class="mt-4">
                            <h2 class="text-xl font-semibold mb-2">Evidence File</h2>
                            <a href="{{ asset('storage/' . $anonIssue->file_path) }}" class="text-blue-500 hover:underline" target="_blank">View/Download File</a>
                        </div>
                    @endif

                    @if(auth()->check() && auth()->user()->role == 'leader')
                        <div class="mt-4">
                            <h4 class="font-bold text-lg text-gray-800 dark:text-gray-200">Change Status:</h4>
                            <form action="{{ route('anon-issues.update_status', $anonIssue->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="px-4 py-2 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="open" {{ $anonIssue->status == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="inprogress" {{ $anonIssue->status == 'inprogress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $anonIssue->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="closed" {{ $anonIssue->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-sm hover:bg-blue-700">Update Status</button>
                            </form>
                        </div>

                        <div class="mt-4">
                            <h4 class="font-bold text-lg text-gray-800 dark:text-gray-200">Forward Issue:</h4>
                            <form action="{{ route('anon-issues.forward', $anonIssue->id) }}" method="POST">
                                @csrf
                                <select name="forward_to" class="px-4 py-2 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @foreach($leaders as $leader)
                                        <option value="{{ $leader->id }}" {{ $anonIssue->forward_to == $leader->id ? 'selected' : '' }}>{{ $leader->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="ml-2 px-4 py-2 bg-green-500 text-white font-bold rounded-lg shadow-sm hover:bg-green-700">Forward</button>
                            </form>
                        </div>

                        <div class="mt-4">
                            <h4 class="font-bold text-lg text-gray-800 dark:text-gray-200">Change Visibility:</h4>
                            <form action="{{ route('anon-issues.update_visibility', $anonIssue->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="visibility" class="px-4 py-2 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="1" {{ $anonIssue->visibility ? 'selected' : '' }}>Visible</option>
                                    <option value="0" {{ !$anonIssue->visibility ? 'selected' : '' }}>Hidden</option>
                                </select>
                                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-sm hover:bg-blue-700">Update Visibility</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
