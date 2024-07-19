<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method == 'PUT')
        @method('PUT')
    @endif

    <div class="mb-4">
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name ?? '')" required autofocus autocomplete="name" />
        <x-input-error for="name" class="mt-2" />
    </div>

    <div class="mb-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email ?? '')" required autocomplete="username" />
        <x-input-error for="email" class="mt-2" />
    </div>

    <div class="mb-4">
        <x-input-label for="password" :value="__('Password')" />
        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
        <x-input-error for="password" class="mt-2" />
    </div>

    <div class="mb-4">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" />
        <x-input-error for="password_confirmation" class="mt-2" />
    </div>

    <div class="mb-4">
        <x-input-label for="role" :value="__('Role')" />
        <select id="role" name="role" class="block mt-1 w-full form-select" required onchange="toggleLeaderDropdown()">
            <option value="citizen" {{ old('role', $user->role ?? '') == 'citizen' ? 'selected' : '' }}>{{ __('Citizen') }}</option>
            <option value="leader" {{ old('role', $user->role ?? '') == 'leader' ? 'selected' : '' }}>{{ __('Leader') }}</option>
            <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>{{ __('Admin') }}</option>
        </select>
        <x-input-error for="role" class="mt-2" />
    </div>

    <div class="mb-4" id="leaderDropdown" style="display: {{ old('role', $user->role ?? '') == 'leader' ? 'block' : 'none' }}">
        <x-input-label for="leader_id" :value="__('Leader')" />
        <select id="leader_id" name="leader_id" class="block mt-1 w-full form-select" onchange="toggleCategoryField()">
            <option value="">{{ __('Select Leader') }}</option>
            @foreach ($leaders as $leader)
                <option value="{{ $leader->id }}" {{ old('leader_id', $user->leader_id ?? '') == $leader->id ? 'selected' : '' }}>{{ $leader->name }}</option>
            @endforeach
        </select>
        <x-input-error for="leader_id" class="mt-2" />
    </div>

    <div class="mb-4" id="categoryField" style="display: {{ old('leader_id', $user->leader_id ?? '') == 7 ? 'block' : 'none' }}">
        <x-input-label for="category_id" :value="__('Category')" />
        <select id="category_id" name="category_id" class="block mt-1 w-full form-select">
            <option value="">{{ __('Select Category') }}</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $user->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        <x-input-error for="category_id" class="mt-2" />
    </div>

    <div class="mb-4">
        <x-input-label for="country_id" :value="__('Country')" />
        <select id="country_id" name="country_id" class="block mt-1 w-full form-select" required onchange="fetchRegions(this.value)">
            <option value="">{{ __('Select Country') }}</option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}" {{ old('country_id', $user->country_id ?? '') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
            @endforeach
        </select>
        <x-input-error for="country_id" class="mt-2" />
    </div>

    <div class="mb-4">
        <x-input-label for="region_id" :value="__('Region')" />
        <select id="region_id" name="region_id" class="block mt-1 w-full form-select" required onchange="fetchDistricts(this.value)" disabled>
            <option value="">{{ __('Select Region') }}</option>
        </select>
        <x-input-error for="region_id" class="mt-2" />
    </div>

    <div class="mb-4">
        <x-input-label for="district_id" :value="__('District')" />
        <select id="district_id" name="district_id" class="block mt-1 w-full form-select" required onchange="fetchWards(this.value)" disabled>
            <option value="">{{ __('Select District') }}</option>
        </select>
        <x-input-error for="district_id" class="mt-2" />
    </div>

    <div class="mb-4">
        <x-input-label for="ward_id" :value="__('Ward')" />
        <select id="ward_id" name="ward_id" class="block mt-1 w-full form-select" required onchange="fetchStreets(this.value)" disabled>
            <option value="">{{ __('Select Ward') }}</option>
        </select>
        <x-input-error for="ward_id" class="mt-2" />
    </div>

    <div class="mb-4">
        <x-input-label for="street_id" :value="__('Street')" />
        <select id="street_id" name="street_id" class="block mt-1 w-full form-select" required disabled>
            <option value="">{{ __('Select Street') }}</option>
        </select>
        <x-input-error for="street_id" class="mt-2" />
    </div>

    <div class="flex justify-end">
        <x-primary-button class="ms-4">
            {{ $buttonText }}
        </x-primary-button>
    </div>
</form>

<script>
    function toggleLeaderDropdown() {
        var roleSelect = document.getElementById('role');
        var leaderDropdown = document.getElementById('leaderDropdown');
        var categoryField = document.getElementById('categoryField');

        if (roleSelect.value === 'leader') {
            leaderDropdown.style.display = 'block';
        } else {
            leaderDropdown.style.display = 'none';
            categoryField.style.display = 'none';
        }
    }

    function toggleCategoryField() {
        var leaderSelect = document.getElementById('leader_id');
        var categoryField = document.getElementById('categoryField');

        if (leaderSelect.value == 7) {
            categoryField.style.display = 'block';
        } else {
            categoryField.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        toggleLeaderDropdown(); 
        toggleCategoryField();

        const countrySelect = document.getElementById('country_id');
        const regionSelect = document.getElementById('region_id');
        const districtSelect = document.getElementById('district_id');
        const wardSelect = document.getElementById('ward_id');
        const streetSelect = document.getElementById('street_id');
        const userCountry = "{{ old('country', $user->country ?? '') }}";
        const userRegion = "{{ old('region', $user->region ?? '') }}";
        const userDistrict = "{{ old('district', $user->district ?? '') }}";
        const userWard = "{{ old('ward', $user->ward ?? '') }}";
        const userStreet = "{{ old('street', $user->street ?? '') }}";
        console.log(userCountry);

        if (userCountry) {
            fetchRegions(userCountry, function() {
                if (userRegion) {
                    fetchDistricts(userRegion, function() {
                        if (userDistrict) {
                            fetchWards(userDistrict, function() {
                                if (userWard) {
                                    fetchStreets(userWard, function() {
                                        if (userStreet) {
                                            streetSelect.value = userStreet;
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            });
        }

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

        function fetchRegions(countryId, callback) {
            fetch(`/api2/regions?country_id=${countryId}`)
                .then(response => response.json())
                .then(data => {
                    regionSelect.innerHTML = '<option value="">{{ __('Select Region') }}</option>';
                    data.forEach(region => {
                        regionSelect.innerHTML += `<option value="${region.id}">${region.name}</option>`;
                    });
                    regionSelect.disabled = false;
                    if (userRegion) {
                        regionSelect.value = userRegion;
                    }
                    if (callback) callback();
                });
        }

        function fetchDistricts(regionId, callback) {
            fetch(`/api2/districts?region_id=${regionId}`)
                .then(response => response.json())
                .then(data => {
                    districtSelect.innerHTML = '<option value="">{{ __('Select District') }}</option>';
                    data.forEach(district => {
                        districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                    });
                    districtSelect.disabled = false;
                    if (userDistrict) {
                        districtSelect.value = userDistrict;
                    }
                    if (callback) callback();
                });
        }

        function fetchWards(districtId, callback) {
            fetch(`/api2/wards?district_id=${districtId}`)
                .then(response => response.json())
                .then(data => {
                    wardSelect.innerHTML = '<option value="">{{ __('Select Ward') }}</option>';
                    data.forEach(ward => {
                        wardSelect.innerHTML += `<option value="${ward.id}">${ward.name}</option>`;
                    });
                    wardSelect.disabled = false;
                    if (userWard) {
                        wardSelect.value = userWard;
                    }
                    if (callback) callback();
                });
        }

        function fetchStreets(wardId, callback) {
            fetch(`/api2/streets?ward_id=${wardId}`)
                .then(response => response.json())
                .then(data => {
                    streetSelect.innerHTML = '<option value="">{{ __('Select Street') }}</option>';
                    data.forEach(street => {
                        streetSelect.innerHTML += `<option value="${street.id}">${street.name}</option>`;
                    });
                    streetSelect.disabled = false;
                    if (userStreet) {
                        streetSelect.value = userStreet;
                    }
                    if (callback) callback();
                });
        }
    });
</script>
