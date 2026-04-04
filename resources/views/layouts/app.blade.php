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
        @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/colorscheme.js'])
    </head>
    <body class="font-sans antialiased">
        <nav class="sticky top-0 z-50 backdrop-blur-md bg-[#49ab6d]/60 border-b border-white/10">
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
                    <div class="flex-none flex items-center absolute right-0">
                    <a>
                        <button id="themeBtn" class="ml-auto w-10 h-10 transition-all duration-300 focus:outline-none bg-center bg-[url(sun.png)] dark:bg-[url(moon.png)] bg-contain bg-no-repeat origin-top-right rounded-full"></button>
                    </a>
                    </div>
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
                  </div>
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
