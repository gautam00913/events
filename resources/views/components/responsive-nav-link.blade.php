@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block pl-3 pr-4 py-2 border-l-4 border-yellow-400 text-base font-medium text-purple-800 bg-purple-50 focus:outline-none focus:text-yellow-800 focus:bg-purple-100 focus:border-purple-700 transition duration-150 ease-in-out'
            : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium hover:text-yellow-800 hover:bg-purple-50 hover:border-purple-300 focus:outline-none focus:text-purple-800 focus:bg-yellow-50 focus:border-yellow-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
