<!DOCTYPE html> 
<html lang="hu" id="page" class="text-black dark:text-white bg-white dark:bg-gray-900">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="{{ asset('logo_ver_2.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Amarna:ital,wght@0,100..700;1,100..700&family=Nothing+You+Could+Do&display=swap" rel="stylesheet">
  <title>{{$title}}</title>
  @vite(['resources/css/rotate.css', 'resources/js/rotate.jsx','resources/css/commentwall.css','resources/js/colorscheme.js','resources/js/createReview.js','resources/js/editAllergenlist.js','resources/js/getRestaurants.js','resources/js/getAllergens.js','resources/js/toggleMobileMenu.js','resources/js/deleteWindow.js','resources/js/statusMessageBoxAnimation.js'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="flex flex-col min-h-screen m-0 p-0">
  <nav class="sticky top-0 z-50 backdrop-blur-md bg-[#49ab6d]/70 border border-white/10 text-black dark:text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            
            <div class="flex items-center">
                <img src="/logo_ver_2.png" alt="Mentesch logo" title="Mentesch logo" class="h-20 w-auto" />
            </div>

            <div class="hidden md:flex items-center space-x-2 lg:space-x-4 ml-6">
                @if (Route::has('login'))
                    @auth
                        <a href="/" aria-current="page" class="rounded-md px-3 py-2 text-sm font-medium transition hover:bg-white/10">Kezdőlap</a>
                        <a href="/allergens" class="rounded-md px-3 py-2 text-sm font-medium transition hover:bg-white/10">Allergének</a>
                        <a href="/restaurants" class="rounded-md px-3 py-2 text-sm font-medium transition hover:bg-white/10">Étterem kereső</a>
                        <a href="/myallergenlist" class="rounded-md px-3 py-2 text-sm font-medium transition hover:bg-white/10">Allergénlistám</a>
                        @if(Auth::user()->is_admin)
                            <a href="/users" class="rounded-md px-3 py-2 text-sm font-medium transition hover:bg-white/10">Felhasználók</a>
                        @endif
                    @endauth
                @endif
            </div>

            <div class="flex items-center gap-3 md:gap-4 ml-auto">
                
                <button id="themeBtn" class="inline-block w-10 h-10 flex-shrink-0 transition-all duration-300 focus:outline-none bg-center bg-[url(/sun.png)] dark:bg-[url(/moon.png)] bg-contain bg-no-repeat rounded-full"></button>

                @if (Route::has('login'))
                    @auth
                        <div class="hidden md:block relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false" type="button" class="flex items-center gap-2 max-w-xs rounded-full bg-white/10 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-white/50 transition hover:bg-white/20" id="user-menu-button">
                                <span class="font-medium">{{ Auth::user()->username }}</span>
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>

                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-gray-200 dark:bg-zinc-900 py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none text-black dark:text-white" 
                                 style="display: none;">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-black/5 dark:hover:bg-white/10 transition">
                                    {{ __('Profil szerkesztése') }}
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Kijelentkezés') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="hidden md:flex items-center gap-2">
                            <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 rounded-md text-sm font-medium hover:bg-white/10 transition">
                                Belépés
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-block px-5 py-1.5 bg-green-500 hover:bg-green-600 transition rounded-md text-sm font-medium text-black dark:text-white">
                                    Regisztráció
                                </a>
                            @endif
                        </div>
                    @endauth
                @endif

                <div class="md:hidden flex items-center">
                    <button onclick="toggleMobileMenu()" class="text-2xl p-2 rounded-lg hover:bg-white/10 transition-colors focus:outline-none">
                        <img src="/hamburgermenuicon.png" alt="Hamburger menü ikon" height="50px" width="50px">
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-gray-400 dark:bg-zinc-900 border-t border-white/10 px-4 pt-2 pb-4 space-y-1 shadow-xl absolute w-full">
        @if (Route::has('login'))
            @auth
                <a href="/" class="block rounded-md px-3 py-3 text-base font-medium hover:bg-white/10 transition">Kezdőlap</a>
                <a href="/allergens" class="block rounded-md px-3 py-3 text-base font-medium hover:bg-white/10 transition">Allergének</a>
                <a href="/restaurants" class="block rounded-md px-3 py-3 text-base font-medium hover:bg-white/10 transition">Étterem kereső</a>
                <a href="/myallergenlist" class="block rounded-md px-3 py-3 text-base font-medium hover:bg-white/10 transition">Allergénlistám</a>
                @if(Auth::user()->is_admin)
                    <a href="/users" class="block rounded-md px-3 py-3 text-base font-medium hover:bg-white/10 transition">Felhasználók</a>
                @endif
                
                <hr class="border-white/20 my-2">
                
                <div class="px-3 py-2 text-sm font-bold opacity-70 uppercase">Bejelentkezve mint: {{ Auth::user()->username }}</div>
                <a href="{{ route('profile.edit') }}" class="block rounded-md px-3 py-3 text-base font-medium hover:bg-white/10 transition">Profil szerkesztése</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left rounded-md px-3 py-3 text-base font-medium text-red-500 hover:bg-red-500/10 transition" onclick="event.preventDefault(); this.closest('form').submit();">
                        Kijelentkezés
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block rounded-md px-3 py-3 text-base font-medium hover:bg-white/10 transition">Belépés</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="block rounded-md px-3 py-3 text-base font-medium bg-green-500 text-white hover:bg-green-600 transition mt-2">Regisztráció</a>
                @endif
            @endauth
        @endif
    </div>
</nav>
          <div class="w-full flex-grow flex flex-col">
    
    @yield('content')
    @guest
    <header class="w-full min-h-screen flex items-center justify-center bg-gradient-to-br from-emerald-700 via-teal-600 to-blue-700">
      <div class="relative w-full h-[60vh] flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <h1 class=" text-7xl font-bold drop-shadow-lg flex items-center justify-center gap-4">
          {{$heading}}
        </h1>
      </div>
    </header>
    @endguest
    @stack('scripts')

    <main class="flex-grow text-black dark:text-white bg-white dark:bg-zinc-950">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 text-black dark:text-white bg-white dark:bg-zinc-950">
          <h2 class="text-center">{{$slot}}</h2>
          </div>
    </main>

  </div>

  
  <footer class="w-full bg-[#40694f] px-8 py-6 text-black dark:text-white">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
      <div>
        <h2 class="text-xl font-semibold ">Mentesch</h2>
        <p class="text-sm mt-1">© 2025 Mentesch, Inc. Minden jog fenntartva.</p>
        <p class="text-sm">Ez az oldal iskolai vizsgamunka részeként készült, nem kereskedelmi célból. Az oldalon megjelenő információk csak demonstráció jellegűek.</p>
        <p class="text-sm">Készítők: Farkas Vanessza és Pintér Kitti Kíra.</p>
      </div>
      <div class="flex space-x-6">
        @if (Route::has('login'))
        @auth
        <a href="/allergens" class="hover:text-emerald-400 hover:bg-white/5 hover: transition hover:bg-white/10">Allergének</a>
        <a href="/restaurants" class="hover:text-emerald-400 hover:bg-white/5 hover: transition hover:bg-white/10">Étterem kereső</a>
        <a href="/myallergenlist" class="hover:text-emerald-400 hover:bg-white/5 hover: transition hover:bg-white/10">Allergénlistám</a>
        @endauth
        @endif
      </div>
    </div>
  </footer>

  <div id="delete-modal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center bg-black/60 backdrop-blur-sm">
    <div class="isolate bg-white dark:bg-zinc-900 rounded-2xl p-8 max-w-sm w-full mx-4 shadow-2xl border border-emerald-500/20">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 dark:bg-emerald-900/30 mb-4">
                <span class="text-3xl">🍃</span>
            </div>
            <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-2 leading-tight">Biztos vagy benne?</h3>
            @if(request()->is('restaurants'))
            <p class="text-zinc-500 dark:text-zinc-400 mb-6 text-sm leading-relaxed">Ez a művelet nem vonható vissza. Az étterem és a hozzá tartozó értékelések véglegesen törlődnek.</p>
            @elseif(request()->is('restaurants/*'))
            <p class="text-zinc-500 dark:text-zinc-400 mb-6 text-sm leading-relaxed">Ez a művelet nem vonható vissza. Az értékelés véglegesen törlődik.</p>
            @else
            <p class="text-zinc-500 dark:text-zinc-400 mb-6 text-sm leading-relaxed">Ez a művelet nem vonható vissza. Az allergén véglegesen törlődik.</p>
            @endif
            
            <div class="flex gap-3 mt-4">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-2.5 bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-xl hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors font-semibold text-sm">
                    Mégse
                </button>
                <button type="button" id="confirm-delete-btn" class="flex-1 px-4 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-all font-semibold text-sm">
                    Igen, töröld
                </button>
            </div>
        </div>
    </div>
</div>

@if (session('success') || session('error'))
    <div id="toast-notification" 
         class="fixed top-5 left-1/2 -translate-x-1/2 z-[100] min-w-[300px] transform transition-all duration-500 ease-in-out">
        <div class="{{ session('success') ? 'bg-emerald-500' : 'bg-red-500' }} text-white px-6 py-3 rounded-xl shadow-2xl flex items-center justify-between border border-white/20 backdrop-blur-sm">
            <div class="flex items-center gap-3">
                <p class="font-semibold text-sm">{{ session('success') ?? session('error') }}</p>
            </div>
            <button onclick="document.getElementById('toast-notification').remove()" class="ml-4 hover:opacity-70 transition-opacity">
                X
            </button>
        </div>
    </div>
@endif
</body>
</html>
