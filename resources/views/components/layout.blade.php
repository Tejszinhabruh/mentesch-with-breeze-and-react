<!DOCTYPE html> 
<html lang="hu" id="page" class="text-black dark:text-white bg-white dark:bg-gray-900">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="{{ asset('logo_ver_2.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Amarna:ital,wght@0,100..700;1,100..700&family=Nothing+You+Could+Do&display=swap" rel="stylesheet">
  <title>{{$title}}</title>
  @vite(['resources/css/rotate.css', 'resources/js/rotate.jsx','resources/css/commentwall.css','resources/js/colorscheme.js','resources/js/createReview.js','resources/js/editAllergenlist.js','resources/js/getRestaurants.js','resources/js/getAllergens.js'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="flex flex-col min-h-screen m-0 p-0">
  <nav class="sticky top-0 z-50 backdrop-blur-md bg-[#49ab6d]/60 border-b border-white/10 text-black dark:text-white">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">
        <div class="flex items-center">
          <img src="/logo_ver_2.png" alt="Mentesch logo" title="Mentesch logo" class="h-20 w-auto" />
          <div class="hidden sm:ml-6 sm:block">
            <div class="flex space-x-4 ml-4">
              @if (Route::has('login'))
              @auth
              <a href="/" aria-current="page" class="rounded-md px-3 py-2 text-sm font-medium transition hover:bg-white/10">Kezdőlap</a>
              <a href="/allergens" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-white/5 hover: transition hover:bg-white/10">Allergének</a>
              <a href="/restaurants" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-white/5 hover: transition hover:bg-white/10">Étterem kereső</a>
              <a href="/myallergenlist" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-white/5 hover: transition hover:bg-white/10">Allergénlistám</a>
              @if(Auth::user()->is_admin)
                  <a href="/users" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-white/5 hover: transition hover:bg-white/10">Felhasználók</a>
                @endif
            </div>
          </div>
        </div>
        <div class="flex items-center justify-end gap-4">
          <a>
            <button id="themeBtn" class="inline-block w-10 h-10 flex-shrink-0 transition-all duration-300 focus:outline-none bg-center bg-[url(/sun.png)] dark:bg-[url(/moon.png)] bg-contain bg-no-repeat origin-top-right rounded-full"></button>
          </a>
        <div class="relative ml-3" x-data="{ open: false }">
            <div>
                <button @click="open = !open" @click.outside="open = false" type="button" class="flex items-center gap-2 max-w-xs rounded-full bg-white/10 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-white/50 transition hover:bg-white/20" id="user-menu-button">
                    <span class="font-medium ">{{  Auth::user()->username }}</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </div>

            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-gray-400 dark:bg-zinc-900 py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" 
                 style="display: none;">

                

                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-100 transition">
                    {{ __('Profil szerkesztése') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Kijelentkezés') }}
                    </button>
                </form>
                </div>
                  </div>
                  @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 rounded-sm text-sm leading-normal"
                        >
                            Belépés
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 bg-green-500 rounded-sm text-sm leading-normal">
                                Regisztráció
                            </a>
                        @endif
                        <a>
                          <button id="themeBtn" class="absolute right-0 ml-auto w-10 h-10 flex-shrink-0 transition-all duration-300 focus:outline-none bg-center bg-[url(/sun.png)] dark:bg-[url(/moon.png)] bg-contain bg-no-repeat origin-top-right rounded-full"></button>
                        </a>
                    @endauth
                    @endif
                  </div>
              </div>
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
        <a href="/allergens" class="hover:text-indigo-400 hover:bg-white/5 hover: transition hover:bg-white/10">Allergének</a>
        <a href="/restaurants" class="hover:text-indigo-400 hover:bg-white/5 hover: transition hover:bg-white/10">Étterem kereső</a>
        <a href="/myallergenlist" class="hover:text-indigo-400 hover:bg-white/5 hover: transition hover:bg-white/10">Allergénlistám</a>
        @endauth
        @endif
      </div>
    </div>
  </footer>
</body>
</html>
