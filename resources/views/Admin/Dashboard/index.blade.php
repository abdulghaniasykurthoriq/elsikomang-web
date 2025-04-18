@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-16 flex justify-between items-center mb-3 -mx-6">
        <!-- title -->
        <h1 class="text-xl text-white">Project</h1>
        <a href="#"
            class="btn bg-white text-gray-800 border-gray-600 hover:bg-gray-100 hover:text-gray-800 hover:border-gray-200 active:bg-gray-100 active:text-gray-800 active:border-gray-200 focus:outline-none focus:ring-4 focus:ring-indigo-300">
            Create New Project
        </a>
    </div>


    <div class="-mt-12 mx-6 mb-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 xl:grid-cols-4">
        <!-- card -->
        <div class="card shadow">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <h4>Projects</h4>
                    <div
                        class="bg-indigo-600 bg-opacity-10 rounded-md w-10 h-10 flex items-center justify-center text-center text-indigo-600">
                        <i data-feather="briefcase"></i>
                    </div>
                </div>
                <div class="mt-4 flex flex-col gap-0 text-base">
                    <h2 class="text-xl font-bold">18</h2>
                    <div>
                        <span>2</span>
                        <span class="text-gray-500">Completed</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- card -->
        <div class="card shadow">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <h4>Active Task</h4>
                    <div
                        class="bg-indigo-600 bg-opacity-10 rounded-md w-10 h-10 flex items-center justify-center text-center text-indigo-600">
                        <i data-feather="list"></i>
                    </div>
                </div>
                <div class="mt-4 flex flex-col gap-0 text-base">
                    <h2 class="text-xl font-bold">132</h2>
                    <div>
                        <span>28</span>
                        <span class="text-gray-500">Completed</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- card -->
        <div class="card shadow">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <h4>Teams</h4>
                    <div
                        class="bg-indigo-600 bg-opacity-10 rounded-md w-10 h-10 flex items-center justify-center text-center text-indigo-600">
                        <i data-feather="users"></i>
                    </div>
                </div>
                <div class="mt-4 flex flex-col gap-0 text-base">
                    <h2 class="text-xl font-bold">12</h2>
                    <div>
                        <span>1</span>
                        <span class="text-gray-500">Completed</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- card -->
        <div class="card shadow">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <h4>Productivity</h4>
                    <div
                        class="bg-indigo-600 bg-opacity-10 rounded-md w-10 h-10 flex items-center justify-center text-center text-indigo-600">
                        <i data-feather="target"></i>
                    </div>
                </div>
                <div class="mt-4 flex flex-col gap-0 text-base">
                    <h2 class="text-xl font-bold">76%</h2>
                    <div>
                        <span class="text-green-600">5%</span>
                        <span class="text-gray-500">Completed</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
