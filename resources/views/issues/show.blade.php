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
                        @if(in_array(pathinfo($issue->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                            <div class="max-w-md overflow-hidden">
                                <img src="{{ asset('storage/' . $issue->file_path) }}" alt="Evidence" class="w-full h-auto">
                            </div>
                        @else
                            <a href="{{ route('evidence.download', ['file' => basename($issue->file_path)]) }}" class="text-blue-500">{{ basename($issue->file_path) }}</a>
                        @endif
                    </div>
                @endif

                <!-- Chat section -->
                <div class="mb-8">
                    <h4 class="font-bold text-lg text-gray-800 dark:text-gray-200">Chat Messages:</h4>
                    <div class="mt-4 space-y-4">
                        @foreach($issue->chats as $chat)
                            <div class="{{ $chat->user_id == auth()->id() ? 'ml-auto' : '' }} flex items-start">
                                <div class="bg-gray-200 p-3 rounded-lg max-w-xs">
                                    <div class="mb-2">
                                        <span class="inline-block px-2 py-1 bg-{{ $chat->user_id == auth()->id() ? 'blue' : 'green' }}-200 text-{{ $chat->user_id == auth()->id() ? 'blue' : 'green' }}-800 font-semibold rounded">{{ $chat->user->name }}</span>
                                        <span class="inline-block px-2 py-1 bg-{{ $chat->user_id == auth()->id() ? 'green' : 'blue' }}-200 text-{{ $chat->user_id == auth()->id() ? 'green' : 'blue' }}-800 font-semibold rounded ml-2">{{ $chat->user->role }}</span>
                                    </div>
                                    <p class="text-sm text-gray-700 dark:text-gray-200">
                                        {{ $chat->msg }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">{{ $chat->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Chat box for sending messages -->
                @if(auth()->check() && !in_array($issue->status, ['resolved', 'closed']))
                    <form action="{{ route('issue_chats.store', ['issue' => $issue->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="issue_id" value="{{ $issue->id }}">
                        <div class="flex">
                            <textarea name="msg" id="msg" rows="3" class="w-full px-4 py-2 rounded-lg shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 resize-none" placeholder="Type your message here..." required></textarea>
                            <button type="submit" class="ml-2 px-4 py-2 bg-indigo-500 text-white font-bold rounded-lg shadow-sm hover:bg-indigo-700">Send</button>
                        </div>
                    </form>
                @else
                    <p class="text-gray-500">You cannot send messages on this issue.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
