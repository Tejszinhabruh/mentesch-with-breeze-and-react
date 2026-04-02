<x-layout>
    <x-slot:title>Étteremkereső</x-slot:title>
    
    <x-slot>
        <div class="relative py-12 mb-10 overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-800 via-teal-700 to-blue-900 shadow-2xl">
            <div class="relative z-10 text-center">
                <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight drop-shadow-md">
                    Étteremkereső
                </h1>
                <p class="mt-4 text-emerald-100 text-lg font-medium">Találd meg a legjobb ízeket a környéken!</p>
            </div>
            <div class="absolute -top-10 -right-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-2xl mx-auto mb-16">
            <div class="relative group">
                <input name="search" id="search" 
                    placeholder="Keress rá egy étteremre..." 
                    class="w-full bg-[#24221f] border-2 border-[#3b3834] text-lg rounded-full py-4 px-8 pl-14 
                           focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all duration-300
                           group-hover:border-[#4d4a45] text-black dark:text-white bg-gray-300 dark:bg-zinc-900">
                <div class="absolute left-5 top-1/2 -translate-y-1/2 text-2xl grayscale group-focus-within:grayscale-0 transition-all">
                    🔎
                </div>
                <button onclick="searchRestaurant()" class="absolute right-3 top-1/2 -translate-y-1/2 bg-emerald-600 hover:bg-emerald-500  px-6 py-2 rounded-full font-bold transition-colors">
                    Keresés
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10" id="restaurantsContainer" data-is-admin="{{ auth()->check() && auth()->user()->is_admin ? 'true' : 'false' }}">

        </div>

    </x-slot>
</x-layout>