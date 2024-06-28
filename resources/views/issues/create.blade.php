<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Issue') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <form method="POST" action="{{ route('issues.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="px-6 py-4">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 dark:text-gray-200">Title</label>
                        <input type="text" name="title" id="title" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 dark:text-gray-200">Description</label>
                        <textarea name="description" id="description" rows="5" class="w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="category_id" class="block text-gray-700 dark:text-gray-200">Category</label>
                        <select name="category_id" id="category_id" class="w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="file_path" class="block text-gray-700 dark:text-gray-200">Upload File</label>
                        <input type="file" name="file_path" id="file_path" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <input type="hidden" name="status" value="open">
                    <input type="hidden" name="visibility" value="1">
                    <input type="hidden" name="to_user_id" value="{{ \App\Helpers\UserHelper::findMatchingUserId(auth()->user()->id, 'leader', 1) }}">

                </div>
                <div class="bg-gray-50 px-6 py-4">
                    <button type="submit" class="inline-block px-4 py-2 bg-green-500 text-white font-bold rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Create Issue
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
