<div class="space-y-6">
    
    <div>
        <x-input-label for="title" :value="__('Title')"/>
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $anonIssue?->title)" autocomplete="title" placeholder="Title"/>
        <x-input-error class="mt-2" for="title"/>
    </div>
    
    <div>
        <x-input-label for="description" :value="__('Description')"/>
        <textarea id="description" name="description" class="mt-1 block w-full" autocomplete="description" placeholder="Description">{{ old('description', $anonIssue?->description) }}</textarea>
        <x-input-error class="mt-2" for="description"/>
    </div>

    <div>
        <x-input-label for="country" :value="__('Country')"/>
        <select id="country" name="country_id" class="mt-1 block w-full form-select" required>
            <option value="">{{ __('Select Country') }}</option>
        </select>
        <x-input-error class="mt-2" for="country"/>
    </div>

    <div>
        <x-input-label for="region" :value="__('Region')"/>
        <select id="region" name="region_id" class="mt-1 block w-full form-select" required disabled>
            <option value="">{{ __('Select Region') }}</option>
        </select>
        <x-input-error class="mt-2" for="region"/>
    </div>

    <div>
        <x-input-label for="district" :value="__('District')"/>
        <select id="district" name="district_id" class="mt-1 block w-full form-select" required disabled>
            <option value="">{{ __('Select District') }}</option>
        </select>
        <x-input-error class="mt-2" for="district"/>
    </div>

    <div>
        <x-input-label for="ward" :value="__('Ward')"/>
        <select id="ward" name="ward_id" class="mt-1 block w-full form-select" required disabled>
            <option value="">{{ __('Select Ward') }}</option>
        </select>
        <x-input-error class="mt-2" for="ward"/>
    </div>

    <div>
        <x-input-label for="street" :value="__('Street')"/>
        <select id="street" name="street_id" class="mt-1 block w-full form-select" required disabled>
            <option value="">{{ __('Select Street') }}</option>
        </select>
        <x-input-error class="mt-2" for="street"/>
    </div>
    
    <div>
        <x-input-label for="category_id" :value="__('Category')"/>
        <select id="category_id" name="category_id" class="mt-1 block w-full form-select">
            <!-- Populate with categories from the database -->
            <option value="">{{ __('Select Category') }}</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $anonIssue?->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        <x-input-error class="mt-2" for="category_id"/>
    </div>

    <div>
        <x-input-label for="file_path" :value="__('Upload File')"/>
        <input id="file_path" name="file_path" type="file" class="mt-1 block w-full">
        <x-input-error class="mt-2" for="file_path"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const countrySelect = document.getElementById('country');
        const regionSelect = document.getElementById('region');
        const districtSelect = document.getElementById('district');
        const wardSelect = document.getElementById('ward');
        const streetSelect = document.getElementById('street');

        // Fetch countries initially
        fetch('/api2/countries')
            .then(response => response.json())
            .then(data => {
                countrySelect.innerHTML = '<option value="">{{ __('Select Country') }}</option>';
                data.forEach(country => {
                    countrySelect.innerHTML += `<option value="${country.id}">${country.name}</option>`;
                });
            });

        countrySelect.addEventListener('change', function () {
            fetchRegions(this.value);
        });

        regionSelect.addEventListener('change', function () {
            fetchDistricts(this.value);
        });

        districtSelect.addEventListener('change', function () {
            fetchWards(this.value);
        });

        wardSelect.addEventListener('change', function () {
            fetchStreets(this.value);
        });

        function fetchRegions(countryId) {
            fetch(`/api2/regions?country_id=${countryId}`)
                .then(response => response.json())
                .then(data => {
                    regionSelect.innerHTML = '<option value="">{{ __('Select Region') }}</option>';
                    data.forEach(region => {
                        regionSelect.innerHTML += `<option value="${region.id}">${region.name}</option>`;
                    });
                    regionSelect.disabled = false;
                });
        }

        function fetchDistricts(regionId) {
            fetch(`/api2/districts?region_id=${regionId}`)
                .then(response => response.json())
                .then(data => {
                    districtSelect.innerHTML = '<option value="">{{ __('Select District') }}</option>';
                    data.forEach(district => {
                        districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                    });
                    districtSelect.disabled = false;
                });
        }

        function fetchWards(districtId) {
            fetch(`/api2/wards?district_id=${districtId}`)
                .then(response => response.json())
                .then(data => {
                    wardSelect.innerHTML = '<option value="">{{ __('Select Ward') }}</option>';
                    data.forEach(ward => {
                        wardSelect.innerHTML += `<option value="${ward.id}">${ward.name}</option>`;
                    });
                    wardSelect.disabled = false;
                });
        }

        function fetchStreets(wardId) {
            fetch(`/api2/streets?ward_id=${wardId}`)
                .then(response => response.json())
                .then(data => {
                    streetSelect.innerHTML = '<option value="">{{ __('Select Street') }}</option>';
                    data.forEach(street => {
                        streetSelect.innerHTML += `<option value="${street.id}">${street.name}</option>`;
                    });
                    streetSelect.disabled = false;
                });
        }
    });
</script>
