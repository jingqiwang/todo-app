<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div id="todolist"></div>

    @vite('resources/js/components/todo/index.js')
</x-app-layout>
