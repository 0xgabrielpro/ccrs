<div class="space-y-6">
    
    <div>
        <x-input-label for="title" :value="__('Title')"/>
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $anonIssue?->title)" autocomplete="title" placeholder="Title"/>
        <x-input-error class="mt-2" for="title"/>
    </div>
    <div>
        <x-input-label for="description" :value="__('Description')"/>
        <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description', $anonIssue?->description)" autocomplete="description" placeholder="Description"/>
        <x-input-error class="mt-2" for="description"/>
    </div>
    <div>
        <x-input-label for="status" :value="__('Status')"/>
        <x-text-input id="status" name="status" type="text" class="mt-1 block w-full" :value="old('status', $anonIssue?->status)" autocomplete="status" placeholder="Status"/>
        <x-input-error class="mt-2" for="status"/>
    </div>
    <div>
        <x-input-label for="country_id" :value="__('Country Id')"/>
        <x-text-input id="country_id" name="country_id" type="text" class="mt-1 block w-full" :value="old('country_id', $anonIssue?->country_id)" autocomplete="country_id" placeholder="Country Id"/>
        <x-input-error class="mt-2" for="country_id"/>
    </div>
    <div>
        <x-input-label for="region_id" :value="__('Region Id')"/>
        <x-text-input id="region_id" name="region_id" type="text" class="mt-1 block w-full" :value="old('region_id', $anonIssue?->region_id)" autocomplete="region_id" placeholder="Region Id"/>
        <x-input-error class="mt-2" for="region_id"/>
    </div>
    <div>
        <x-input-label for="district_id" :value="__('District Id')"/>
        <x-text-input id="district_id" name="district_id" type="text" class="mt-1 block w-full" :value="old('district_id', $anonIssue?->district_id)" autocomplete="district_id" placeholder="District Id"/>
        <x-input-error class="mt-2" for="district_id"/>
    </div>
    <div>
        <x-input-label for="ward_id" :value="__('Ward Id')"/>
        <x-text-input id="ward_id" name="ward_id" type="text" class="mt-1 block w-full" :value="old('ward_id', $anonIssue?->ward_id)" autocomplete="ward_id" placeholder="Ward Id"/>
        <x-input-error class="mt-2" for="ward_id"/>
    </div>
    <div>
        <x-input-label for="street_id" :value="__('Street Id')"/>
        <x-text-input id="street_id" name="street_id" type="text" class="mt-1 block w-full" :value="old('street_id', $anonIssue?->street_id)" autocomplete="street_id" placeholder="Street Id"/>
        <x-input-error class="mt-2" for="street_id"/>
    </div>
    <div>
        <x-input-label for="category_id" :value="__('Category Id')"/>
        <x-text-input id="category_id" name="category_id" type="text" class="mt-1 block w-full" :value="old('category_id', $anonIssue?->category_id)" autocomplete="category_id" placeholder="Category Id"/>
        <x-input-error class="mt-2" for="category_id"/>
    </div>
    <div>
        <x-input-label for="file_path" :value="__('File Path')"/>
        <x-text-input id="file_path" name="file_path" type="text" class="mt-1 block w-full" :value="old('file_path', $anonIssue?->file_path)" autocomplete="file_path" placeholder="File Path"/>
        <x-input-error class="mt-2" for="file_path"/>
    </div>
    <div>
        <x-input-label for="code" :value="__('Code')"/>
        <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code', $anonIssue?->code)" autocomplete="code" placeholder="Code"/>
        <x-input-error class="mt-2" for="code"/>
    </div>
    <div>
        <x-input-label for="citizen_satisfied" :value="__('Citizen Satisfied')"/>
        <x-text-input id="citizen_satisfied" name="citizen_satisfied" type="text" class="mt-1 block w-full" :value="old('citizen_satisfied', $anonIssue?->citizen_satisfied)" autocomplete="citizen_satisfied" placeholder="Citizen Satisfied"/>
        <x-input-error class="mt-2" for="citizen_satisfied"/>
    </div>
    <div>
        <x-input-label for="sealed_by" :value="__('Sealed By')"/>
        <x-text-input id="sealed_by" name="sealed_by" type="text" class="mt-1 block w-full" :value="old('sealed_by', $anonIssue?->sealed_by)" autocomplete="sealed_by" placeholder="Sealed By"/>
        <x-input-error class="mt-2" for="sealed_by"/>
    </div>
    <div>
        <x-input-label for="to_user_id" :value="__('To User Id')"/>
        <x-text-input id="to_user_id" name="to_user_id" type="text" class="mt-1 block w-full" :value="old('to_user_id', $anonIssue?->to_user_id)" autocomplete="to_user_id" placeholder="To User Id"/>
        <x-input-error class="mt-2" for="to_user_id"/>
    </div>
    <div>
        <x-input-label for="read" :value="__('Read')"/>
        <x-text-input id="read" name="read" type="text" class="mt-1 block w-full" :value="old('read', $anonIssue?->read)" autocomplete="read" placeholder="Read"/>
        <x-input-error class="mt-2" for="read"/>
    </div>
    <div>
        <x-input-label for="visibility" :value="__('Visibility')"/>
        <x-text-input id="visibility" name="visibility" type="text" class="mt-1 block w-full" :value="old('visibility', $anonIssue?->visibility)" autocomplete="visibility" placeholder="Visibility"/>
        <x-input-error class="mt-2" for="visibility"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>