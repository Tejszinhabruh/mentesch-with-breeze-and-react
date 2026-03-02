
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
            <h1 class="text-3xl text-center mb-16 uppercase text-gray-100">
              Mit szeretnél ma csinálni? :)
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl w-full">
              
              <div class="bg-[#24221f] border border-[#3b3834] p-5 flex flex-col text-center">
                <img src="/penandpaper.png" alt="Véleményírás" class="w-full h-56 mb-6 shadow-md">
                <h2 class="text-lg font-bold mb-4 uppercase tracking-widest text-white">Véleményírás</h2>
                <a href="/restaurantsearch" class="text-sm text-gray-300 mb-8 leading-relaxed flex-grow">
                  Írj egy véleményt a kedvenc éttermedhez!
                </a>
              </div>
            
              <div class="bg-[#24221f] border border-[#3b3834] p-5 flex flex-col text-center">
                <img src="/search.png" alt="Étteremkeresés" class="w-full h-56 mb-6 shadow-md">
                <h2 class="text-lg font-bold mb-4 uppercase tracking-widest text-white">Étteremkeresés</h2>
                <a href="/restaurantsearch" class="text-sm text-gray-300 mb-8 leading-relaxed flex-grow">
                  Találj egy számodra ideális éttermet s olvasd el annak véleményeit hogy biztosan jót válassz!
                </a>
              </div>
            
              <div class="bg-[#24221f] border border-[#3b3834] p-5 flex flex-col text-center">
                <img src="/list.png" alt="Allergénlista" class="w-full h-56 mb-6 shadow-md">
                <h2 class="text-lg font-bold mb-4 uppercase tracking-widest text-white">Allergénlista</h2>
                <a href="/profile" class="text-sm text-gray-300 mb-8 leading-relaxed flex-grow">
                    Csinálj vagy szerkeszd meglévő allergénlistád hogy mindig naprakész legyél!
                </a>
              </div>
            
            </div>
            @else
            <h1 class="text-3xl text-center mb-16 uppercase text-gray-100">
              Üdvözlünk a Mentesch weboldalán!
            </h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl w-full">
              
              <div class="bg-[#24221f] border border-[#3b3834] p-5 flex flex-col text-center">
                <img src="/elet.jpeg" alt="Élet" class="w-full h-56 object-cover mb-6 shadow-md">
                <h2 class="text-lg font-bold mb-4 uppercase tracking-widest text-white">Élet</h2>
                <p class="text-sm text-gray-300 mb-8 leading-relaxed flex-grow">
                  Ez az oldal azért jött létre hogy allergiás embereket segíthessünk a mindennapjaik megkönnyítésében, legyen szó főzésről, bevásárlásról vagy éppenséggel megfelelő étterem megtalálásáról.
                </p>
              </div>
            
              <div class="bg-[#24221f] border border-[#3b3834] p-5 flex flex-col text-center">
                <img src="/elmeny.jpg" alt="Élmény" class="w-full h-56 object-cover mb-6 shadow-md">
                <h2 class="text-lg font-bold mb-4 uppercase tracking-widest text-white">Élmény</h2>
                <p class="text-sm text-gray-300 mb-8 leading-relaxed flex-grow">
                  Keress a saját allergiádhoz igazított éttermeket, tudasd a pincérrel az allergiáidat a saját egyéni allergia listáddal, vagy csak egyszerűen könnyítsd meg az otthoni főzést a hozzávaló-alternatíva listával!
                </p>
              </div>
            
              <div class="bg-[#24221f] border border-[#3b3834] p-5 flex flex-col text-center">
                <img src="/segitseg.jpg" alt="Segítség" class="w-full h-56 object-cover mb-6 shadow-md">
                <h2 class="text-lg font-bold mb-4 uppercase tracking-widest text-white">Segítség</h2>
                <p class="text-sm text-gray-300 mb-8 leading-relaxed flex-grow">
                    Mire vársz még? Próbáld ki a funkciókat még ma!*
                </p>
                <p class="text-xs text-gray-400 mb-8 leading-relaxed flex-grow flex items-center justify-center">
                  *Az oldal funkcióinak eléréséhez regisztráció szükséges.
                </p>
              </div>
            
            </div>
            @endauth
        </div>
    </x-slot>
</x-layout>