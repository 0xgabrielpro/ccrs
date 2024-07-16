<div class="space-y-6">
    <div>
        <x-input-label for="title" :value="__('Title')"/>
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $anonIssue?->title)" autocomplete="title" placeholder="Title"/>
        <x-input-error class="mt-2" for="title"/>
    </div>
    <div>
        <x-input-label for="description" :value="__('Description')"/>
        <textarea id="description" name="description" class="mt-1 block w-full resize-none border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" autocomplete="description" placeholder="Description">{{ old('description', $anonIssue?->description) }}</textarea>
        <x-input-error class="mt-2" for="description"/>
    </div>
    <div>
        <x-input-label for="country" :value="__('Country')"/>
        <select id="country" name="country" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option value="Tanzania" {{ old('country', $anonIssue?->country) == 'Tanzania' ? 'selected' : '' }}>Tanzania</option>
        </select>
        <x-input-error class="mt-2" for="country"/>
    </div>
    <div>
        <x-input-label for="region" :value="__('Region')"/>
        <select id="region" name="region" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option value="Arusha" {{ old('region', $anonIssue?->region) == 'Arusha' ? 'selected' : '' }}>Arusha</option>
        </select>
        <x-input-error class="mt-2" for="region"/>
    </div>
    <div>
        <x-input-label for="ward" :value="__('Ward')"/>
        <select id="ward" name="ward" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option value="Muriet" {{ old('ward', $anonIssue?->ward) == 'Muriet' ? 'selected' : '' }}>Muriet</option>
        </select>
        <x-input-error class="mt-2" for="ward"/>
    </div>
    <div>
        <x-input-label for="street" :value="__('Street')"/>
        <select id="street" name="street" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option value="Muriet" {{ old('street', $anonIssue?->street) == 'Muriet' ? 'selected' : '' }}>Muriet</option>
        </select>
        <x-input-error class="mt-2" for="street"/>
    </div>
    <div>
        <x-input-label for="file_path" :value="__('File Path')"/>
        <x-text-input id="file_path" name="file_path" type="file" class="mt-1 block w-full" :value="old('file_path', $anonIssue?->file_path)" autocomplete="file_path" placeholder="File Path"/>
        <x-input-error class="mt-2" for="file_path"/>
    </div>
    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>
