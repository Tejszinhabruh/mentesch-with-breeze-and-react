<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="text-black bg-white dark:text-white dark:bg-black">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Profil</title>

        <!-- Fonts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="icon" type="image/png" href="{{ asset('logo_ver_2.png') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/colorscheme.js','resources/js/toggleMobileMenu.js'])
    </head>
    <body class="font-sans antialiased">
        <nav class="sticky top-0 z-50 backdrop-blur-md bg-[#49ab6d]/70 border-b border-white/10">
                <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
                  <div class="relative flex h-16 items-center justify-between">
                    <div class="flex items-center">
                      <img src="/logo_ver_2.png" alt="Mentesch logo" class="h-20 w-auto" />
                      <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4 ml-4">
                          @if (Route::has('login'))
                          @auth
                          <a href="/" aria-current="page" class="rounded-md px-3 py-2 text-sm font-medium text-black dark:text-white transition hover:bg-white/10">Kezdőlap</a>
                          <a href="/allergens" class="rounded-md px-3 py-2 text-sm font-medium text-black dark:text-white hover:bg-white/5 transition hover:bg-white/10">Allergének</a>
                          <a href="/restaurants" class="rounded-md px-3 py-2 text-sm font-medium text-black dark:text-white hover:bg-white/5 transition hover:bg-white/10">Étterem kereső</a>
                          <a href="/myallergenlist" class="rounded-md px-3 py-2 text-sm font-medium text-black dark:text-white hover:bg-white/5 transition hover:bg-white/10">Allergénlistám</a>
                          @endauth
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="flex items-center gap-3 md:gap-4 ml-auto">
                    <a>
                        <button id="themeBtn" class="inline-block w-10 h-10 flex-shrink-0 transition-all duration-300 focus:outline-none bg-center bg-[url(/sun.png)] dark:bg-[url(/moon.png)] bg-contain bg-no-repeat rounded-full"></button>
                    </a>
                    @if (Route::has('login'))
                            <div class="flex items-center justify-end gap-4">
                                @auth
                                
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
                        <div class="md:hidden flex items-center">
                    <button onclick="toggleMobileMenu()" class="text-2xl p-2 rounded-lg hover:bg-white/10 transition-colors focus:outline-none">
                        <img src="/hamburgermenuicon.png" alt="Hamburger menü ikon" height="50px" width="50px">
                    </button>
                </div>
                  </div>
                </div>
                <div id="mobile-menu" class="hidden md:hidden bg-gray-400 dark:bg-zinc-900 border-t border-white/10 px-4 pt-2 pb-4 space-y-1 shadow-xl absolute w-full text-black dark:text-white">
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
        <div class="min-h-screen text-black bg-white dark:text-white dark:bg-zinc-950">
            

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
