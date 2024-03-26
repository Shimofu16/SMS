<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/login', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 dark:bg-gray-800 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block w-auto text-gray-800 fill-current h-9 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <ul class="items-center hidden p-4 space-x-8 sm:ms-10 sm:flex">
                    @can('view-dashboard')
                        <li>
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        </li>
                    @endcan
                    @can('view-students')
                        <li class="relative group ">
                            <x-nav-link :href="route('students.enrollee.index')" :active="request()->routeIs('students.enrolled.index')" :active="request()->routeIs('students.enrollee.index')">
                                {{ __('Students') }}
                            </x-nav-link>
                            <div class="absolute hidden overflow-auto group-hover:block max-h-64 w-100">
                                <div class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                    <ul class="py-2 text-sm text-gray-900" aria-labelledby="dropdownLargeButton">
                                        @can('view-enrolled-students')
                                            <li>
                                                <a href="{{ route('students.enrolled.index') }}"
                                                    class="block px-4 py-2 hover:bg-gray-300 ">Enrolled Students</a>
                                            </li>
                                        @endcan
                                        @can('view-enrollee-students')
                                            <li>
                                                <a href="{{ route('students.enrollee.index') }}"
                                                    class="block px-4 py-2 hover:bg-gray-300 ">Enrollee Students</a>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endcan
                    @can('view-payments')
                        <li class="relative group ">
                            <x-nav-link :href="route('payments.fees.index')" :active="request()->routeIs('payments.fees.index')">
                                {{ __('Payments') }}
                            </x-nav-link>
                            <div class="absolute hidden overflow-auto group-hover:block max-h-64 w-100">
                                <div class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                    <ul class="py-2 text-sm text-gray-900" aria-labelledby="dropdownLargeButton">
                                        @can('view-fees')
                                            <li>
                                                <a href="{{ route('payments.fees.index') }}"
                                                    class="block px-4 py-2 hover:bg-gray-300 " wire:navigate>Annual Fees</a>
                                            </li>
                                        @endcan
                                        @can('view-transactions')
                                            <li>
                                                <a href="#" class="block px-4 py-2 hover:bg-gray-300 "
                                                    wire:navigate>Transactions</a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endcan
                    @can('view-academics')
                        <li class="relative group ">
                            <x-nav-link :href="route('academics.academic.index')" :active="request()->routeIs('academics.academic.index')">
                                {{ __('Academic Management') }}
                            </x-nav-link>
                            <div class="absolute hidden overflow-auto group-hover:block max-h-64 w-100">
                                <div class="z-[100px] bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                    <ul class="py-2 text-sm text-gray-900" aria-labelledby="dropdownLargeButton">
                                        @can('view-subjects')
                                            <li>
                                                <a href="{{ route('academics.subjects.index') }}"
                                                    class="block px-4 py-2 hover:bg-gray-300 " wire:navigate>{{ __('Subjects') }}</a>
                                            </li>
                                        @endcan
                                        @can('view-sections')
                                            <li>
                                                <a href="{{ route('academics.sections.index') }}"
                                                    class="block px-4 py-2 hover:bg-gray-300 " wire:navigate>{{ __('Sections') }}</a>
                                            </li>
                                        @endcan
                                        @can('view-schedules')
                                            <li>
                                                <a href="{{ route('academics.schedules.index') }}"
                                                    class="block px-4 py-2 hover:bg-gray-300 " wire:navigate>{{ __('Schedules') }}</a>
                                            </li>
                                        @endcan
                                        @can('view-school-years')
                                            <li>
                                                <a href="{{ route('academics.school-years.index') }}"
                                                    class="block px-4 py-2 hover:bg-gray-300 " wire:navigate>{{ __('School Years') }}</a>
                                            </li>
                                        @endcan
                                        @can('view-teachers')
                                            <li>
                                                <a href="{{ route('academics.teachers.index') }}"
                                                    class="block px-4 py-2 hover:bg-gray-300 " wire:navigate>{{ __('Teechers') }}</a>
                                            </li>
                                        @endcan
                                    </ul>

                                </div>
                            </div>
                        </li>
                    @endcan
                    @can('view-settings')
                        <li class="relative group ">
                            <x-nav-link :href="route('settings.enrollment.index')" :active="request()->routeIs('settings.enrollment.index')">
                                {{ __('Settings') }}
                            </x-nav-link>
                            <div class="absolute hidden overflow-auto group-hover:block max-h-64 w-100">
                                <div class="z-[100px] bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                    <ul class="py-2 text-sm text-gray-900" aria-labelledby="dropdownLargeButton">
                                        @can('view-enrollment-settings')
                                            <li>
                                                <a href="{{ route('settings.enrollment.index') }}"
                                                    class="block px-4 py-2 hover:bg-gray-300 " wire:navigate>{{ __('Enrollment') }}</a>
                                            </li>
                                        @endcan
                                        @can('view-announcements')
                                            <li>
                                                <a href="{{ route('settings.announcements.index') }}"
                                                    class="block px-4 py-2 hover:bg-gray-300 " wire:navigate>{{ __('Announcements') }}</a>
                                            </li>
                                        @endcan

                                    </ul>

                                </div>
                            </div>
                        </li>
                    @endcan
                    @can('view-access-controls')
                        <li class="relative group ">
                            <x-nav-link :href="route('access-controls.users.index')" :active="request()->routeIs('access-controls.users.index')">
                                {{ __('Access Controls') }}
                            </x-nav-link>
                            <div class="absolute hidden overflow-auto group-hover:block max-h-64 w-100">
                                <div class="z-100 bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                    <ul class="py-2 text-sm text-gray-900" aria-labelledby="dropdownLargeButton">
                                        @can('view-users')
                                            <li>
                                                <a href="{{ route('access-controls.users.index') }}"
                                                    class="block px-4 py-2 hover:bg-gray-300 " wire:navigate>{{ __('Users') }}</a>
                                            </li>
                                        @endcan
                                    </ul>

                                </div>
                            </div>
                        </li>
                    @endcan

                </ul>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                                x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -me-2 sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800 dark:text-gray-200" x-data="{{ json_encode(['name' => auth()->user()->name]) }}"
                    x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
