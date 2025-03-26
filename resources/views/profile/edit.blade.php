@extends('layouts.app')
@section('title', 'Edit Profile')

@section('content')
    <div class="p-4">

        <div class="mb-8 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Profile Information -->
            <div class="col-span-1">
                <h4 class="mb-1">Profile Information</h4>
                <p class="text-gray-600">Update your name and email address</p>
            </div>
            <div class="card shadow col-span-3">
                <div class="card-body">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')
                        <div class="mb-4 inline-flex md:flex md:items-center gap-3 flex-col md:flex-row w-full">
                            <label for="name" class="flex-1 text-gray-800 font-semibold">Name</label>
                            <div class="flex-[3] w-full">
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                    class="border border-gray-300 text-gray-900 rounded focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2 px-3"
                                    required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                        </div>
                        <div class="mb-4 inline-flex md:flex md:items-center gap-3 flex-col md:flex-row w-full">
                            <label for="email" class="flex-1 text-gray-800 font-semibold">Email</label>
                            <div class="flex-[3] w-full">
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="border border-gray-300 text-gray-900 rounded focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2 px-3"
                                    required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="btn bg-indigo-600 text-white">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="mb-8 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Password Update -->
            <div class="col-span-1">
                <h4 class="mb-1">Change Password</h4>
                <p class="text-gray-600">Make sure your password is secure</p>
            </div>
            <div class="card shadow col-span-3">
                <div class="card-body">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')
                        <div class="mb-4 inline-flex md:flex md:items-center gap-3 flex-col md:flex-row w-full">
                            <label for="current_password" class="flex-1 text-gray-800 font-semibold">Current
                                Password</label>
                            <div class="flex-[3] w-full">
                                <input type="password" id="current_password" name="current_password"
                                    class="border border-gray-300 text-gray-900 rounded focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2 px-3"
                                    autocomplete="current-password" />
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>
                        </div>
                        <div class="mb-4 inline-flex md:flex md:items-center gap-3 flex-col md:flex-row w-full">
                            <label for="password" class="flex-1 text-gray-800 font-semibold">New Password</label>
                            <div class="flex-[3] w-full">
                                <input type="password" id="password" name="password"
                                    class="border border-gray-300 text-gray-900 rounded focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2 px-3"
                                    autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>
                        </div>
                        <div class="mb-4 inline-flex md:flex md:items-center gap-3 flex-col md:flex-row w-full">
                            <label for="password_confirmation" class="flex-1 text-gray-800 font-semibold">Confirm
                                Password</label>
                            <div class="flex-[3] w-full">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="border border-gray-300 text-gray-900 rounded focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2 px-3"
                                    autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="btn bg-indigo-600 text-white">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="mb-8 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Delete Account -->
            <div class="col-span-1">
                <h4 class="mb-1">Delete Account</h4>
                <p class="text-gray-600">Permanently delete your account</p>
            </div>
            <div class="card shadow col-span-3">
                <div class="card-body">
                    <h4 class="mb-1">Danger Zone</h4>
                    <p class="mb-4">Delete your account and all related data. Please confirm your password to continue.
                    </p>
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')
                        <div class="mb-4">
                            <input type="password" name="password" placeholder="Enter your password"
                                class="border border-gray-300 text-gray-900 rounded focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2 px-3" />
                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                        </div>
                        <button type="submit" class="btn bg-red-600 text-white">Delete Account</button>
                    </form>
                </div>
            </div>
        </div>

    @endsection
