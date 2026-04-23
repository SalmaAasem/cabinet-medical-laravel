<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet Médical - Gestion RDV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap');
        body { font-family: 'Nunito', sans-serif; background-color: #f3f4f6; }
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="flex min-h-screen">

    <aside class="w-64 bg-indigo-900 text-white flex flex-col fixed h-full shadow-2xl">
        <div class="p-6 text-2xl font-bold border-b border-indigo-800 flex items-center">
            <i class="fas fa-stethoscope mr-3 text-indigo-400"></i> Cabinet
        </div>
        <nav class="flex-1 mt-6">
            <a href="{{ route('secretaire.dashboard') }}" class="flex items-center py-3 px-6 {{ request()->routeIs('secretaire.dashboard') ? 'bg-white/10 border-l-4 border-white' : 'text-indigo-300 hover:bg-indigo-800' }}">
                <i class="fas fa-calendar-alt mr-3"></i> Gestion RDV
            </a>
            <a href="#" class="flex items-center py-3 px-6 text-indigo-300 hover:bg-indigo-800 hover:text-white transition">
                <i class="fas fa-users mr-3"></i> Liste patients
            </a>
        </nav>
        
        <div class="p-6 border-t border-indigo-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-red-500/20 text-red-300 py-3 rounded-xl hover:bg-red-500 hover:text-white transition flex items-center justify-center gap-2 font-bold">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 ml-64 p-8">
        
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-8 mb-8 text-white relative overflow-hidden shadow-lg">
            <div class="relative z-10">
                <h1 class="text-3xl font-bold mb-2">Gestion des rendez-vous</h1>
                <p class="opacity-80">Bienvenue, {{ Auth::user()->name }}</p>
            </div>
            <i class="fas fa-calendar-check absolute right-10 top-1/2 -translate-y-1/2 text-9xl opacity-10"></i>
        </div>

        <div class="bg-white rounded-2xl p-4 shadow-sm mb-8">
            <form action="{{ route('secretaire.dashboard') }}" method="GET" class="flex gap-4 items-center">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-indigo-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un patient..." 
                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition">
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-md">
                    Chercher
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-50 flex flex-col items-center stat-card border-b-4 border-yellow-400">
                <div class="w-12 h-12 bg-yellow-100 text-yellow-500 rounded-full flex items-center justify-center mb-3 text-xl"><i class="fas fa-clock"></i></div>
                <div class="text-3xl font-bold text-gray-800">{{ $stats['en_attente'] }}</div>
                <div class="text-gray-400 text-sm font-medium uppercase tracking-wider">En attente</div>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-50 flex flex-col items-center stat-card border-b-4 border-green-500">
                <div class="w-12 h-12 bg-green-100 text-green-500 rounded-full flex items-center justify-center mb-3 text-xl"><i class="fas fa-check-circle"></i></div>
                <div class="text-3xl font-bold text-gray-800">{{ $stats['confirmes'] }}</div>
                <div class="text-gray-400 text-sm font-medium uppercase tracking-wider">Confirmés</div>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-50 flex flex-col items-center stat-card border-b-4 border-red-500">
                <div class="w-12 h-12 bg-red-100 text-red-500 rounded-full flex items-center justify-center mb-3 text-xl"><i class="fas fa-times-circle"></i></div>
                <div class="text-3xl font-bold text-gray-800">{{ $stats['annules'] }}</div>
                <div class="text-gray-400 text-sm font-medium uppercase tracking-wider">Annulés</div>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-50 flex flex-col items-center stat-card border-b-4 border-blue-500">
                <div class="w-12 h-12 bg-blue-100 text-blue-500 rounded-full flex items-center justify-center mb-3 text-xl"><i class="fas fa-flag-checkered"></i></div>
                <div class="text-3xl font-bold text-gray-800">{{ $stats['termines'] }}</div>
                <div class="text-gray-400 text-sm font-medium uppercase tracking-wider">Terminés</div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-50 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-800 flex items-center italic">
                    <i class="fas fa-list-ul mr-3 text-indigo-600"></i> Liste des rendez-vous
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-widest">
                            <th class="px-6 py-4 font-semibold italic">Patient</th>
                            <th class="px-6 py-4 font-semibold italic">Médecin</th>
                            <th class="px-6 py-4 font-semibold italic">Date & Heure</th>
                            <th class="px-6 py-4 font-semibold italic text-center">Statut</th>
                            <th class="px-6 py-4 text-center font-semibold italic">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($rendezVous as $rdv)
                        <tr class="hover:bg-indigo-50/30 transition">
                            <td class="px-6 py-4 font-bold text-gray-800">{{ $rdv->patient->user->name }}</td>
                            <td class="px-6 py-4 text-gray-600 font-medium italic">Dr. {{ $rdv->medecin->user->name ?? 'Rayane' }}</td>
                            <td class="px-6 py-4 text-gray-600 font-mono">{{ \Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('gestion-rdv.update', $rdv->id) }}" method="POST" class="flex justify-center">
                                    @csrf @method('PUT')
                                    <select name="statut" onchange="this.form.submit()" 
                                        class="rounded-full px-4 py-1 text-[10px] font-black border-0 shadow-sm ring-1 ring-inset cursor-pointer outline-none
                                        {{ $rdv->statut == 'Confirmé' ? 'ring-green-300 bg-green-50 text-green-700' : 
                                           ($rdv->statut == 'Annulé' ? 'ring-red-300 bg-red-50 text-red-700' : 'ring-yellow-300 bg-yellow-50 text-yellow-700') }}">
                                        <option value="En attente" {{ $rdv->statut == 'En attente' ? 'selected' : '' }}>● EN ATTENTE</option>
                                        <option value="Confirmé" {{ $rdv->statut == 'Confirmé' ? 'selected' : '' }}>● CONFIRMÉ</option>
                                        <option value="Annulé" {{ $rdv->statut == 'Annulé' ? 'selected' : '' }}>● ANNULÉ</option>
                                        <option value="Terminé" {{ $rdv->statut == 'Terminé' ? 'selected' : '' }}>● TERMINÉ</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('gestion-rdv.destroy', $rdv->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-[10px] font-bold transition shadow-md shadow-red-100">
                                        ANNULER
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>