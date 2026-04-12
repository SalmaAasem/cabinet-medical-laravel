<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion Utilisateurs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen">
        <div class="w-64 bg-slate-900 text-white flex flex-col">
            <div class="p-6 text-2xl font-bold border-b border-slate-800 text-center text-indigo-400">
                <i class="fas fa-user-shield mr-2"></i>Admin Panel
            </div>
            <nav class="flex-1 mt-6">
                <a href="{{ route('admin.users') }}" class="flex items-center py-3 px-6 bg-slate-800 text-white border-l-4 border-indigo-500">
                    <i class="fas fa-users mr-3"></i> Utilisateurs
                </a>
                <a href="#" class="flex items-center py-3 px-6 text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <i class="fas fa-chart-line mr-3"></i> Statistiques
                </a>
            </nav>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm py-4 px-8 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-slate-800">Gestion des Utilisateurs</h1>
                <div class="flex items-center space-x-2">
                    <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold">Mode Administrateur</span>
                </div>
            </header>

            <main class="p-8 overflow-y-auto">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-200">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white">
                        <div>
                            <h2 class="text-lg font-bold text-slate-700">Liste des comptes</h2>
                            <p class="text-sm text-slate-400 font-medium">Total: {{ $users->count() }} utilisateurs</p>
                        </div>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 shadow-md transition font-medium">
                            <i class="fas fa-user-plus mr-2"></i>Nouvel Utilisateur
                        </a>
                    </div>

                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                                <th class="p-4 font-semibold">Nom</th>
                                <th class="p-4 font-semibold">Email</th>
                                <th class="p-4 font-semibold">Rôle</th>
                                <th class="p-4 font-semibold text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($users as $user)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold mr-3 text-xs">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <span class="font-bold text-slate-700">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="p-4 text-slate-600 text-sm font-medium">{{ $user->email }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-[10px] font-black uppercase tracking-widest border border-purple-200">
                                        {{ $user->role ?? 'Patient' }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-center space-x-3">
                                        <a href="#" class="text-slate-400 hover:text-indigo-600"><i class="fas fa-eye"></i></a>
                                        
                                        <form action="{{ route('profile.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-red-500 transition">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>