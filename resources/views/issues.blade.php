<!-- resources/views/issues.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Issues') }}
        </h2>
    </x-slot>

    <div>
        @livewire('issues')
    </div>
</x-app-layout>
