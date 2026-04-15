<x-layout>
    <x-slot:title>Allergének</x-slot:title>
    <x-slot:heading>Allergének</x-slot:heading>
    <x-slot>
        <div class="relative py-12 mb-10 overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-800 via-teal-700 to-blue-900 shadow-2xl">
            <h1 class="text-5xl md:text-7xl font-extrabold  tracking-tight drop-shadow-md">Allergének</h1>
        </div>
        <div id="allergens-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-4 max-w-7xl mx-auto" data-is-admin="{{ auth()->check() && auth()->user()->is_admin ? 'true' : 'false' }}">
    </div>
    <div id="status-message-container" class="fixed top-5 left-1/2 -translate-x-1/2 z-[100] flex flex-col gap-3 w-full max-w-md px-4 pointer-events-none"></div>
    </x-slot>
</x-layout>