<x-slot name="header">
    <div class="navbar justify-between min-h-0 py-0">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('School Year') }}
        </h2>
        <div class="text-sm breadcrumbs">
            <ul>
                <li class="text-gray-800 dark:text-gray-200">Settings</li>
                <li class="text-gray-800 dark:text-gray-200">School Year</li>
                <li class="text-gray-800 dark:text-gray-200">List</li>
            </ul>
        </div>
    </div>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{ $this->table }}
            </div>
        </div>
    </div>
</div>
