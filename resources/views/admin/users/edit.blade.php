<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <br>
    <div class="container mx-auto">
        <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4">
                <h2 class="text-2xl font-semibold mb-2">Edit User</h2>
                <form action="{{ route('admin.users.edit', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="block text-gray-600 font-semibold">Name</label>
                        <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-input mt-1 block w-full">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-600 font-semibold">Email</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-input mt-1 block w-full">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-600 font-semibold">Password</label>
                        <input type="password" id="password" name="password" value="" class="form-input mt-1 block w-full">
                    </div>
                    <div class="mb-4">
                        <label for="role" class="block text-gray-600 font-semibold">Role</label>
                        <select id="role" name="role" class="form-select mt-1 block w-full">
                            <option value="citizen" {{ $user->role == 'citizen' ? 'selected' : '' }}>Citizen</option>
                            <option value="leader" {{ $user->role == 'leader' ? 'selected' : '' }}>Leader</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="country" class="block text-gray-600 font-semibold">Country</label>
                        <input type="text" id="country" name="country" value="{{ $user->country }}" class="form-input mt-1 block w-full">
                    </div>
                    <div class="mb-4">
                        <label for="region" class="block text-gray-600 font-semibold">Region</label>
                        <input type="text" id="region" name="region" value="{{ $user->region }}" class="form-input mt-1 block w-full">
                    </div>
                    <div class="mb-4">
                        <label for="ward" class="block text-gray-600 font-semibold">Ward</label>
                        <input type="text" id="ward" name="ward" value="{{ $user->ward }}" class="form-input mt-1 block w-full">
                    </div>
                    <div class="mb-4">
                        <label for="street" class="block text-gray-600 font-semibold">Street</label>
                        <input type="text" id="street" name="street" value="{{ $user->street }}" class="form-input mt-1 block w-full">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
