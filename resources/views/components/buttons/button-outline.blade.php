@props(['type' => 'submit', 'color' => 'blue', 'size' => ''])

@php
    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-base',
        'lg' => 'px-5 py-2.5 text-lg',
    ][$size ?? 'md'];
@endphp

<button type="{{ $type }}"
    class="inline-flex items-center px-4 py-2 {{ $size }} bg-{{ $color }}-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-{{ $color }}-500 active:bg-{{ $color }}-900 focus:outline-none focus:border-{{ $color }}-900 focus:ring ring-{{ $color }}-300 disabled:opacity-25 transition ease-in-out duration-150"
    {{ $attributes->merge(['class' => 'primary-button']) }}>
    {{ $slot }}
</button>
