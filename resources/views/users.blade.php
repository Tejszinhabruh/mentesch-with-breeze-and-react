<x-layout>
    <x-slot:title>Felhasználók</x-slot:title>
    <x-slot:heading>Felhasználók</x-slot:heading>
    <x-slot>
        <div class="relative py-12 mb-10 overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-800 via-teal-700 to-blue-900 shadow-2xl">
            <h1 class="text-5xl md:text-7xl font-extrabold  tracking-tight drop-shadow-md">Felhasználók</h1>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-4 max-w-7xl mx-auto">
            <table>
                <tr>
                    <td>Felhasználó id</td>
                    <td>Felhasználó neve</td>
                    <td>Admin-e?</td>
                    <td>Csatlakozás dátuma</td>
                    <td></td>
                </tr>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->is_admin }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        <div class="text-right">
                            <button class="bg-red-600 text-2xl rounded border border-red-700">🗑️</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
    </div>
    </x-slot>
</x-layout>