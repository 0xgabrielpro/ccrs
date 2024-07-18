<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div>
                <x-label for="country" value="{{ __('Country') }}" />
                <select id="country" name="country" class="block mt-1 w-full form-select" required>
                    <option value="">{{ __('Select Country') }}</option>
                </select>
            </div>

            <div>
                <x-label for="region" value="{{ __('Region') }}" />
                <select id="region" name="region" class="block mt-1 w-full form-select" required disabled>
                    <option value="">{{ __('Select Region') }}</option>
                </select>
            </div>

            <div>
                <x-label for="district" value="{{ __('District') }}" />
                <select id="district" name="district" class="block mt-1 w-full form-select" required disabled>
                    <option value="">{{ __('Select District') }}</option>
                </select>
            </div>

            <div>
                <x-label for="ward" value="{{ __('Ward') }}" />
                <select id="ward" name="ward" class="block mt-1 w-full form-select" required disabled>
                    <option value="">{{ __('Select Ward') }}</option>
                </select>
            </div>

            <div>
                <x-label for="street" value="{{ __('Street') }}" />
                <select id="street" name="street" class="block mt-1 w-full form-select" required disabled>
                    <option value="">{{ __('Select Street') }}</option>
                </select>
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>

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
    </x-authentication-card>
</x-guest-layout>
