<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create') }} Anon Issue
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Create') }} Anon Issue</h1>
                            <p class="mt-2 text-sm text-gray-700">Add a new {{ __('Anon Issue') }}.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('anon-issues.index') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Back</a>
                        </div>
                    </div>

                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="max-w-xl py-2 align-middle">
                                <form method="POST" action="{{ route('anon-issues.store') }}" role="form" enctype="multipart/form-data">
                                    @csrf

                                    @include('anon-issue.form')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popup Modal -->
    @if(session('issue_code'))
    <div id="popup-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full relative">
            <h2 class="text-xl font-bold mb-4">Issue Created Successfully</h2>
            <p class="mb-4">Your issue has been created. Here is your unique code:</p>
            <div class="bg-gray-100 p-3 rounded-lg mb-4">
                <code class="text-lg font-mono">{{ session('issue_code') }}</code>
            </div>
            <p class="mt-4 text-sm text-gray-700">This code is important for tracking your complaint and cannot be retrieved again. Please make sure to save it somewhere safe.</p>
            <button onclick="redirectToIssue()" class="absolute top-2 right-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Close</button>
        </div>
    </div>

    <script>
        function redirectToIssue() {
            var issueUrl = "{{ session('issue_url') }}";
            window.location.href = issueUrl;
        }
    </script>
    @endif

</x-app-layout>
