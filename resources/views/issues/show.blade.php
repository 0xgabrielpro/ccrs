<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Issue Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4">
                <div class="mb-4">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $issue->title }}</h3>
                </div>
                <div class="mb-4">
                    <span class="inline-block px-4 py-2 bg-{{ $issue->status == 'open' ? 'green' : ($issue->status == 'inprogress' ? 'yellow' : ($issue->status == 'resolved' ? 'blue' : 'red')) }}-500 text-white font-bold rounded-lg shadow-sm">{{ ucfirst($issue->status) }}</span>
                </div>
                <div class="mb-4">
                    <p class="text-gray-700 dark:text-gray-200">{{ $issue->description }}</p>
                </div>
                @if($issue->file_path)
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200">Evidence File:</label>
                        <div class="max-w-md overflow-hidden border rounded-lg cursor-pointer">
                            @if(in_array(pathinfo($issue->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                <img src="{{ asset('storage/' . $issue->file_path) }}" alt="Evidence" class="w-full h-auto">
                            @else
                                <a href="{{ route('evidence.download', ['file' => basename($issue->file_path)]) }}" class="block px-4 py-2 text-center text-blue-500 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    {{ basename($issue->file_path) }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Chat section -->
                <div class="mb-8">
                    <h4 class="font-bold text-lg text-gray-800 dark:text-gray-200">Chat Messages:</h4>
                    <div class="mt-4 space-y-4">
                        @foreach($issue->chats as $chat)
                            <div class="{{ $chat->user_id == auth()->id() ? 'ml-auto' : '' }} flex items-start {{ $chat->user_id == auth()->id() ? 'flex-row-reverse' : '' }}">
                                <div class="bg-gray-200 p-4 rounded-lg shadow-sm flex flex-col w-full max-w-md {{ $chat->user_id == auth()->id() ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    <div class="relative">
                                        <div class="absolute top-0 right-0 {{ $chat->user_id == auth()->id() ? 'pr-2' : 'pl-2' }} mt-1">
                                            <span class="inline-block px-2 py-1 bg-{{ $chat->user_id == auth()->id() ? 'blue' : 'green' }}-200 text-{{ $chat->user_id == auth()->id() ? 'blue' : 'green' }}-800 font-semibold rounded">{{ $chat->user->role }}</span>
                                        </div>
                                        <div class="flex-grow">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2">
                                                    <span class="inline-block px-2 py-1 bg-{{ $chat->user_id == auth()->id() ? 'blue' : 'green' }}-200 text-{{ $chat->user_id == auth()->id() ? 'blue' : 'green' }}-800 font-semibold rounded">{{ $chat->user->name }}</span>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <p class="text-sm">
                                                    {{ $chat->msg }}
                                                </p>
                                                @if($chat->file_path)
                                                    @php
                                                        $extension = pathinfo($chat->file_path, PATHINFO_EXTENSION);
                                                        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif']);
                                                    @endphp
                                                    <div class="mt-2">
                                                        @if($isImage)
                                                            <a href="{{ asset('storage/' . $chat->file_path) }}" target="_blank">
                                                                <img src="{{ asset('storage/' . $chat->file_path) }}" alt="File" class="w-full h-auto rounded-lg shadow-md">
                                                            </a>
                                                        @else
                                                            <div class="flex items-center space-x-2">
                                                                <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" d="M4.293 3.293a1 1 0 0 1 1.414 0L10 7.586l4.293-4.293a1 1 0 1 1 1.414 1.414L11.414 9l4.293 4.293a1 1 0 1 1-1.414 1.414L10 10.414l-4.293 4.293a1 1 0 1 1-1.414-1.414L8.586 9 4.293 4.707a1 1 0 0 1 0-1.414z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                <a href="{{ asset('storage/' . $chat->file_path) }}" class="text-blue-500 hover:underline truncate" target="_blank">{{ basename($chat->file_path) }}</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-300 mt-2 {{ $chat->user_id == auth()->id() ? 'text-right' : 'text-left' }}">
                                            {{ $chat->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


                <!-- Chat box for sending messages -->
                @if(auth()->check() && !in_array($issue->status, ['resolved', 'closed']))
                    <form action="{{ route('issue_chats.store', ['issue' => $issue->id]) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                        @csrf
                        <input type="hidden" name="issue_id" value="{{ $issue->id }}">
                        <div class="flex flex-col">
                            <textarea name="msg" id="msg" rows="3" class="w-full px-4 py-2 mb-2 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 resize-none" placeholder="Type your message here..." required></textarea>
                            <div class="flex items-center">
                                <input type="file" name="file" id="file" class="mr-2">
                                <button type="submit" class="px-4 py-2 bg-indigo-500 text-white font-bold rounded-lg shadow-sm hover:bg-indigo-700">Send</button>
                            </div>
                        </div>
                    </form>
                @else
                    <p class="text-gray-500">You're not allowed to send messages.</p>
                @endif

                @if(auth()->check() && auth()->id() == $issue->user_id)
                    <div class="flex justify-end mt-4 space-x-2">
                        @if($issue->status != 'open' && $issue->status != 'inprogress')
                            <form action="{{ route('issues.reopen', $issue->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white font-bold rounded-lg shadow-sm hover:bg-yellow-700">Re-open Issue</button>
                            </form>
                        @endif
                        <form action="{{ route('issues.destroy', $issue->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white font-bold rounded-lg shadow-sm hover:bg-red-700">Delete Issue</button>
                        </form>
                    </div>
                @endif

                @if(auth()->check() && $issue->status == 'resolved' && auth()->id() == $issue->user_id)
                    <div class="mt-4">
                        <h4 class="font-bold text-lg text-gray-800 dark:text-gray-200">Rate the Service:</h4>
                        <form action="{{ route('issues.rate', $issue->id) }}" method="POST">
                            @csrf
                            <div class="flex space-x-2 mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="submit" name="rating" value="{{ $i }}" class="px-4 py-2 bg-gray-300 text-gray-800 font-bold rounded-lg shadow-sm hover:bg-gray-400">{{ $i }}</button>
                                @endfor
                            </div>
                        </form>
                    </div>
                @endif

                @if(auth()->check() && auth()->user()->role == 'leader')
                    <div class="mt-4">
                        <h4 class="font-bold text-lg text-gray-800 dark:text-gray-200">Change Status:</h4>
                        <form action="{{ route('issues.update_status', $issue->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" class="px-4 py-2 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="inprogress">In Progress</option>
                                <option value="resolved">Resolved</option>
                                <option value="closed">Closed</option>
                            </select>
                            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-sm hover:bg-blue-700">Update Status</button>
                        </form>
                    </div>

                    <div class="mt-4">
                        <h4 class="font-bold text-lg text-gray-800 dark:text-gray-200">Forward Issue:</h4>
                        <form action="{{ route('issues.forward', $issue->id) }}" method="POST">
                            @csrf
                            <select name="forward_to" class="px-4 py-2 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach($leaders as $leader)
                                    <option value="{{ $leader->id }}">{{ $leader->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="ml-2 px-4 py-2 bg-green-500 text-white font-bold rounded-lg shadow-sm hover:bg-green-700">Forward</button>
                        </form>
                    </div>

                    <div class="mt-4">
                        <h4 class="font-bold text-lg text-gray-800 dark:text-gray-200">Change Visibility:</h4>
                        <form action="{{ route('issues.update_visibility', $issue->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="visibility" class="px-4 py-2 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="1" {{ $issue->visibility ? 'selected' : '' }}>Visible</option>
                                <option value="0" {{ !$issue->visibility ? 'selected' : '' }}>Hidden</option>
                            </select>
                            <button type="submit" class="ml-2 px-4 py-2 bg-yellow-500 text-white font-bold rounded-lg shadow-sm hover:bg-yellow-700">Update Visibility</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
