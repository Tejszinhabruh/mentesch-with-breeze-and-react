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
                            <th class="px-6 py-4 font-semibold text-center">Csatlakozás</th>
                            <th class="px-6 py-4 font-semibold text-center">E-mail megerősítés dátuma</th>
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
                            <td class="px-6 py-4 text-sm text-center">
                                {{ \Carbon\Carbon::parse($user->created_at)->format('Y.m.d') }}
                            </td>
                            @if($user->email_verified_at == null)
                            <td class="px-6 py-4 font-bold text-red-500 text-center">Nincs megerősítve!</td>
                            @else
                            <td class="px-6 py-4 font-bold text-center text-green-500">{{ $user->email_verified_at }}</td>
                            @endif
                            <td class="px-6 py-4 text-right">
                                <form id="delete-form-{{$user->id}}" action="/users/{{ $user->id }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="openDeleteModal({{ $user->id }})" class="p-2 text-red-500 hover:bg-red-500/50 rounded-lg transition-colors border border-red-500">
                                        <span class="text-xl">🗑️</span>
                                    </button>
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