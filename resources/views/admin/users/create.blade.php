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
                <h2 class="text-2xl font-semibold mb-2">Add User</h2>
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="mb-4">
                        <label for="name" class="block text-gray-600 font-semibold">Name</label>
                        <input type="text" id="name" name="name" value="" class="form-input mt-1 block w-full">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-600 font-semibold">Email</label>
                        <input type="email" id="email" name="email" value="" class="form-input mt-1 block w-full">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-600 font-semibold">Password</label>
                        <input type="password" id="password" name="password" value="" class="form-input mt-1 block w-full">
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-gray-600 font-semibold">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" value="" class="form-input mt-1 block w-full">
                    </div>
                    <div class="mb-4">
                        <label for="role" class="block text-gray-600 font-semibold">Role</label>
                        <select id="role" name="role" class="form-select mt-1 block w-full">
                            <option value="citizen">Citizen</option>
                            <option value="leader">Leader</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="country" class="block text-gray-600 font-semibold">Arusha</label>
                        <select id="country" name="country" class="form-select mt-1 block w-full">
                            <option value="Tanzania">Tanzania</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="region" class="block text-gray-600 font-semibold">Arusha</label>
                        <select id="region" name="region" class="form-select mt-1 block w-full">
                            <option value="Arusha">Arusha</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="ward" class="block text-gray-600 font-semibold">Arusha</label>
                        <select id="ward" name="ward" class="form-select mt-1 block w-full">
                            <option value="Muriet">Muriet</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="street" class="block text-gray-600 font-semibold">Arusha</label>
                        <select id="street" name="street" class="form-select mt-1 block w-full">
                            <option value="Muriet">Muriet</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
