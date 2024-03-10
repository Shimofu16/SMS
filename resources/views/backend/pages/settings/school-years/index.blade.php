@extends('backend.pages.settings.index')
@section('header')
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
@endsection
@section('contents')
    <div class="py-12">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <livewire:pages.settings.school-year>
                </div>
    </div>
@endsection
