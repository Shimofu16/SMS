<x-app-layout>
    <x-slot name="header">
        @yield('header')
    </x-slot>
    <div class="px-4 mx-auto max-w-8xl sm:px-6 lg:px-8">
        @include('livewire.layout.sidebar')
        <div class="sm:ml-64">
            @yield('contents')
        </div>

    </div>
</x-app-layout>
