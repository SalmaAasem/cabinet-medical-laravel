<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Secrétaire | Cabinet Médical</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans">

    <div class="flex h-screen">
        <div class="w-64 bg-indigo-900 text-white flex flex-col">
            <div class="p-6 text-2xl font-bold border-b border-indigo-800 text-center">
                <i class="fas fa-hospital-user mr-2"></i>Cabinet Pro
            </div>
            <nav class="flex-1 mt-6">
                <a href="{{ route('secretaire.dashboard') }}" class="flex items-center py-3 px-6 bg-indigo-800 text-white">
                    <i class="fas fa-calendar-check mr-3"></i> Rendez-vous
                </a>
                <a href="#" class="flex items-center py-3 px-6 text-indigo-300 hover:bg-indigo-800 hover:text-white transition">
                    <i class="fas fa-users mr-3"></i> Patients
                </a>
                <a href="#" class="flex items-center py-3 px-6 text-indigo-300 hover:bg-indigo-800 hover:text-white transition">
                    <i class="fas fa-user-md mr-3"></i> Médecins
                </a>
            </nav>
            <div class="p-4 border-t border-indigo-800">
                <p class="text-xs text-indigo-400 text-center">Connecté en tant que Secrétaire</p>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm py-4 px-8 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-800">Gestion des Rendez-vous</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Bienvenue, <strong>{{ Auth::user()->name ?? 'Mme. Salma' }}</strong></span>
                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold border">
                        {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}
                    </div>
                </div>
            </header>

            <main class="p-8 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
                        <div class="text-sm text-gray-500 uppercase font-bold">Total RDV</div>
                        <div class="text-2xl font-bold">{{ $total_rdv ?? 0 }}</div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
                        <div class="text-sm text-gray-500 uppercase font-bold">RDV Aujourd'hui</div>
                        <div class="text-2xl font-bold">{{ $rdv_today ?? 0 }}</div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                        <div class="text-sm text-gray-500 uppercase font-bold">Total Patients</div>
                        <div class="text-2xl font-bold">{{ $total_patients ?? 0 }}</div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                        <h2 class="text-lg font-bold text-gray-700">Demandes de Rendez-vous</h2>
                        <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-plus mr-2"></i>Nouveau RDV
                        </button>
                    </div>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-400 uppercase text-xs">
                                <th class="p-4 font-medium">Patient</th>
                                <th class="p-4 font-medium">Spécialité</th>
                                <th class="p-4 font-medium">Date & Heure</th>
                                <th class="p-4 font-medium">Statut</th>
                                <th class="p-4 font-medium text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recent_rdvs ?? [] as $rdv)
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-4">
                                    <div class="font-bold text-gray-800">{{ $rdv->patient->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $rdv->patient->email }}</div>
                                </td>
                                <td class="p-4 text-gray-600 italic">{{ $rdv->specialite }}</td>
                                <td class="p-4 text-gray-600">{{ $rdv->date_rdv->format('d M Y | H:i') }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">En attente</span>
                                </td>
                                <td class="p-4 flex justify-center space-x-2">
                                    <button class="p-2 bg-green-100 text-green-600 rounded-md hover:bg-green-600 hover:text-white transition"><i class="fas fa-check"></i></button>
                                    <button class="p-2 bg-red-100 text-red-600 rounded-md hover:bg-red-600 hover:text-white transition"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-400">Aucun rendez-vous trouvé.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

</body>
</html>