<x-layout>
    <x-slot:title>Kezdőlap</x-slot:title>
    <x-slot:heading>
        @auth
        
        @else
        <section class="relative w-full min-h-[50vh] md:min-h-[60vh] flex flex-col items-center justify-center overflow-hidden">
  
    <div class="absolute inset-0 opacity-[0.03] bg-[linear-gradient(to_right,#ffffff_1px,transparent_1px),linear-gradient(to_bottom,#ffffff_1px,transparent_1px)] bg-[size:4rem_4rem]"></div>

    <div class="flex items-center justify-center ">
        
        <div class="relative z-10 flex items-center justify-center gap-3 text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight dark:text-white text-white">
            Mentes <span id="rotating-text-root"></span>
        </div>
        </div> 
        </section>
        @push('scripts')
            @vite(['resources/js/rotate.jsx'])
        @endpush
        @endauth
    </x-slot:heading>
    <x-slot>
        <div class="p-10 font-sans text-white flex flex-col items-center">
  
            @auth
            <div class="relative py-12 mb-10 overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-800 via-teal-700 to-blue-900 shadow-2xl">
              <h1 class="p-5 text-5xl md:text-7xl font-extrabold text-white tracking-tight drop-shadow-md">Mit szeretnél ma csinálni {{ Auth::user()->username }}? :)</h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl w-full px-4">
    
    <div class="group bg-[#24221f] border border-[#3b3834] rounded-2xl overflow-hidden shadow-lg 
                hover:-translate-y-2 hover:border-emerald-500/50 hover:shadow-emerald-900/20 transition-all duration-300 flex flex-col">
        
        <div class="p-6 flex-grow text-center">
            <div class="overflow-hidden rounded-xl mb-6 shadow-inner bg-[#1c1a17]">
                <img src="/penandpaper.png" alt="Véleményírás" 
                     class="w-full h-48 object-contain p-4 group-hover:scale-110 transition-transform duration-500">
            </div>
            
            <h2 class="text-xl font-bold mb-4 uppercase tracking-widest text-white group-hover:text-emerald-400 transition-colors">
                Véleményírás
            </h2>
            
            <p class="text-sm text-gray-400 leading-relaxed mb-4">
                Írj egy véleményt a kedvenc éttermedhez és segíts másoknak a választásban!
            </p>
        </div>

        <div class="p-4 bg-[#1c1a17] border-t border-[#3b3834]">
            <a href="/restaurants" class="block w-full text-center py-3 rounded-xl bg-transparent border border-emerald-500/30 text-emerald-400 font-semibold
                                          hover:bg-emerald-500 hover:text-white transition-all duration-300">
                Kezdés most
            </a>
        </div>
    </div>

    <div class="group bg-[#24221f] border border-[#3b3834] rounded-2xl overflow-hidden shadow-lg 
                hover:-translate-y-2 hover:border-teal-500/50 hover:shadow-teal-900/20 transition-all duration-300 flex flex-col">
        
        <div class="p-6 flex-grow text-center">
            <div class="overflow-hidden rounded-xl mb-6 shadow-inner bg-[#1c1a17]">
                <img src="/search.png" alt="Étteremkeresés" 
                     class="w-full h-48 object-contain p-4 group-hover:scale-110 transition-transform duration-500">
            </div>
            
            <h2 class="text-xl font-bold mb-4 uppercase tracking-widest text-white group-hover:text-teal-400 transition-colors">
                Étteremkeresés
            </h2>
            
            <p class="text-sm text-gray-400 leading-relaxed mb-4">
                Találj egy számodra ideális éttermet és olvasd el a véleményeket, hogy biztosan jót válassz!
            </p>
        </div>

        <div class="p-4 bg-[#1c1a17] border-t border-[#3b3834]">
            <a href="/restaurants" class="block w-full text-center py-3 rounded-xl bg-transparent border border-teal-500/30 text-teal-400 font-semibold
                                          hover:bg-teal-500 hover:text-white transition-all duration-300">
                Keresés indítása
            </a>
        </div>
    </div>

         <div class="group bg-[#24221f] border border-[#3b3834] rounded-2xl overflow-hidden shadow-lg 
                     hover:-translate-y-2 hover:border-blue-500/50 hover:shadow-blue-900/20 transition-all duration-300 flex flex-col">

             <div class="p-6 flex-grow text-center">
                 <div class="overflow-hidden rounded-xl mb-6 shadow-inner bg-[#1c1a17]">
                     <img src="/list.png" alt="Allergénlista" 
                          class="w-full h-48 object-contain p-4 group-hover:scale-110 transition-transform duration-500">
                 </div>

                 <h2 class="text-xl font-bold mb-4 uppercase tracking-widest text-white group-hover:text-blue-400 transition-colors">
                     Allergénlista
                 </h2>

                 <p class="text-sm text-gray-400 leading-relaxed mb-4">
                     Csinálj vagy szerkeszd meglévő allergénlistádat, hogy mindig naprakész legyen az étrended!
                 </p>
             </div>

             <div class="p-4 bg-[#1c1a17] border-t border-[#3b3834]">
                 <a href="/myallergenlist" class="block w-full text-center py-3 rounded-xl bg-transparent border border-blue-500/30 text-blue-400 font-semibold
                                               hover:bg-blue-500 hover:text-white transition-all duration-300">
                     Allergénlista megtekintése
                 </a>
             </div>
         </div>

        </div>
            @else
            <h1 class="text-3xl text-center mb-16 uppercase text-gray-100">
              Üdvözlünk a Mentesch weboldalán!
            </h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl w-full px-4">
    
    <div class="group bg-[#24221f] border border-[#3b3834] rounded-2xl overflow-hidden shadow-lg 
                hover:-translate-y-2 hover:border-emerald-500/40 hover:shadow-emerald-900/10 transition-all duration-300 flex flex-col">
        
        <div class="relative h-56 overflow-hidden">
            <img src="/elet.jpeg" alt="Élet" 
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-[#24221f] to-transparent opacity-60"></div>
        </div>

        <div class="p-6 flex flex-col text-center flex-grow">
            <h2 class="text-xl font-bold mb-4 uppercase tracking-[0.2em] text-white group-hover:text-emerald-400 transition-colors">
                Élet
            </h2>
            <p class="text-sm text-gray-400 leading-relaxed mb-4">
                Ez az oldal azért jött létre, hogy allergiás embereket segíthessünk a mindennapjaik megkönnyítésében, legyen szó főzésről, bevásárlásról vagy éppenséggel megfelelő étterem megtalálásáról.
            </p>
        </div>
        
        <div class="h-1.5 w-full bg-emerald-600/20 group-hover:bg-emerald-500 transition-colors"></div>
    </div>

    <div class="group bg-[#24221f] border border-[#3b3834] rounded-2xl overflow-hidden shadow-lg 
                hover:-translate-y-2 hover:border-teal-500/40 hover:shadow-teal-900/10 transition-all duration-300 flex flex-col">
        
        <div class="relative h-56 overflow-hidden">
            <img src="/elmeny.jpg" alt="Élmény" 
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-[#24221f] to-transparent opacity-60"></div>
        </div>

        <div class="p-6 flex flex-col text-center flex-grow">
            <h2 class="text-xl font-bold mb-4 uppercase tracking-[0.2em] text-white group-hover:text-teal-400 transition-colors">
                Élmény
            </h2>
            <p class="text-sm text-gray-400 leading-relaxed mb-4">
                Keress a saját allergiádhoz igazított éttermeket, tudasd a pincérrel az igényeidet az egyéni listáddal, vagy könnyítsd meg az otthoni főzést a hozzávaló-alternatíva listánkkal!
            </p>
        </div>
        
        <div class="h-1.5 w-full bg-teal-600/20 group-hover:bg-teal-500 transition-colors"></div>
    </div>

                <div class="group bg-[#24221f] border border-[#3b3834] rounded-2xl overflow-hidden shadow-lg 
                            hover:-translate-y-2 hover:border-blue-500/40 hover:shadow-blue-900/10 transition-all duration-300 flex flex-col">
                    
                    <div class="relative h-56 overflow-hidden">
                        <img src="/segitseg.jpg" alt="Segítség" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#24221f] to-transparent opacity-60"></div>
                    </div>
            
                    <div class="p-6 flex flex-col text-center flex-grow">
                        <h2 class="text-xl font-bold mb-4 uppercase tracking-[0.2em] text-white group-hover:text-blue-400 transition-colors">
                            Segítség
                        </h2>
                        <p class="text-sm text-gray-300 font-semibold mb-2 italic">
                            Mire vársz még? Próbáld ki a funkciókat még ma!
                        </p>
                        <div class="mt-auto pt-4">
                            <p class="text-[10px] text-gray-500 border-t border-[#3b3834] pt-4">
                                * Az oldal funkcióinak eléréséhez regisztráció szükséges.
                            </p>
                        </div>
                    </div>
                    
                    <div class="h-1.5 w-full bg-blue-600/20 group-hover:bg-blue-500 transition-colors"></div>
                </div>
            
            </div>
            @endauth
        </div>
    </x-slot>
</x-layout>