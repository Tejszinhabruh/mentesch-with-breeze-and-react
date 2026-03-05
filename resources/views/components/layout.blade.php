<!DOCTYPE html> 
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Amarna:ital,wght@0,100..700;1,100..700&family=Nothing+You+Could+Do&display=swap" rel="stylesheet">
  <title>{{$title}}</title>
  @vite(['resources/css/rotate.css', 'resources/js/rotate.jsx','resources/css/commentwall.css'])
</head>

<body class="flex flex-col min-h-screen text-white">
  <nav class="sticky top-0 z-50 backdrop-blur-md bg-[#49ab6d]/60 border-b border-white/10">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">
        <div class="flex items-center">
          <img src="/logo_ver_2.png" alt="Mentesch logo" class="h-20 w-auto" />
          <div class="hidden sm:ml-6 sm:block">
            <div class="flex space-x-4 ml-4">
              @if (Route::has('login'))
              @auth
              <a href="/" aria-current="page" class="rounded-md px-3 py-2 text-sm font-medium text-white transition hover:bg-white/10">Kezdőlap</a>
              <a href="/allergens" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white transition hover:bg-white/10">Allergének</a>
              <a href="/restaurants" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white transition hover:bg-white/10">Étterem kereső</a>
              <a href="/myallergenlist" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white transition hover:bg-white/10">Allergénlistám</a>
              @endauth
              @endif
            </div>
          </div>
        </div>
        @if (Route::has('login'))
                <div class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/profile') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Profil
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Belépés
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Regisztráció
                            </a>
                        @endif
                    @endauth
                  </div>
            @endif
      </div>
    </div>
  </nav>
  <div class="w-full text-gray-200 flex-grow flex flex-col">
    
    @yield('content')
    @guest
    <header class="w-full min-h-screen flex items-center justify-center bg-gradient-to-br from-emerald-700 via-teal-600 to-blue-700">
      <div class="relative w-full h-[60vh] flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <h1 class="text-white text-7xl font-bold drop-shadow-lg flex items-center justify-center gap-4">
          {{$heading}}
        </h1>
      </div>
    </header>
    @endguest
    @stack('scripts')

    <main class="flex-grow">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 text-gray-300">
          <h2 class="text-center">{{$slot}}</h2>
          </div>
    </main>

  </div>

  
  <footer class="bg-[#40694f] text-gray-300 px-8 py-6">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
      <div>
        <h2 class="text-xl font-semibold text-white">Mentesch</h2>
        <p class="text-sm mt-1">© 2025 Mentesch, Inc. Minden jog fenntartva.</p>
        <p class="text-sm">Ez az oldal iskolai vizsgamunka részeként készült, nem kereskedelmi célból. Az oldalon megjelenő információk csak demonstráció jellegűek.</p>
        <p class="text-sm">Készítők: Farkas Vanessza és Pintér Kitti Kíra.</p>
      </div>
      <div class="flex space-x-6">
        @if (Route::has('login'))
        @auth
        <a href="/allergens" class="hover:text-indigo-400 hover:bg-white/5 hover:text-white transition hover:bg-white/10">Allergének</a>
        <a href="/restaurants" class="hover:text-indigo-400 hover:bg-white/5 hover:text-white transition hover:bg-white/10">Étterem kereső</a>
        <a href="/myallergenlist" class="hover:text-indigo-400 hover:bg-white/5 hover:text-white transition hover:bg-white/10">Allergénlistám</a>
        @endauth
        @endif
      </div>
    </div>
  </footer>
</body>
</html>
