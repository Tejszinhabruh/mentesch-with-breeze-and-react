<x-layout>
    <x-slot:title>Felhasználók</x-slot:title>
    <x-slot:heading>Felhasználók</x-slot:heading>
    <x-slot>
        <div class="relative py-12 mb-10 overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-800 via-teal-700 to-blue-900 shadow-2xl">
            <h1 class="text-5xl md:text-7xl font-extrabold  tracking-tight drop-shadow-md">Felhasználók</h1>
        </div>
        <div class="relative py-12 mb-10">
            <div class="w-full overflow-x-auto rounded-lg border border-black/2 dark:border-white/10 shadow-xl">
                <table class="w-full text-left border-collapse bg-slate-300 dark:bg-zinc-900 text-black dark:text-white">
                    <thead class="bg-emerald-800 text-emerald-50 uppercase text-sm">
                        <tr>
                            <th class="px-6 py-4 font-semibold">ID</th>
                            <th class="px-6 py-4 font-semibold">Felhasználó neve</th>
                            <th class="px-6 py-4 font-semibold text-center">Admin státusz</th>
                            <th class="px-6 py-4 font-semibold">Csatlakozás</th>
                            <th class="px-6 py-4 text-right"></th>
                        </tr>
                    </thead>


                    <tbody class="divide-y divide-zinc-700">
                        @foreach ($users as $user)
                        <tr class="hover:bg-zinc-800/50 transition-colors duration-200">
                            <td class="px-6 py-4 font-mono text-emerald-500 text-sm">#{{ $user->id }}</td>
                            <td class="px-6 py-4 font-medium">{{ $user->username }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($user->is_admin)
                                    <span class="px-3 py-1 text-xs font-bold text-emerald-900 bg-emerald-400 rounded-full">Igen</span>
                                @else
                                    <span class="px-3 py-1 text-xs font-bold text-white dark:text-zinc-400 bg-slate-700 dark:bg-zinc-800 rounded-full border border-zinc-600">Nem</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ \Carbon\Carbon::parse($user->created_at)->format('Y.m.d') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="/api/users/{{ $user->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xl p-2 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white border border-red-500/50 rounded-lg transition-all transform active:scale-95 shadow-sm">🗑️</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-slot>
</x-layout>