<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
public function handle()
{
    $tomorrow = now()->addDay()->toDateString(); 
    
 
    $appointments = \App\Models\RendezVous::where('statut', 'confirme')
        ->whereDate('date_heure', $tomorrow)
        ->get();

    if ($appointments->isEmpty()) {
        $this->warn("Aucun rendez-vous trouvé pour le : " . $tomorrow);
        return;
    }

    foreach ($appointments as $rdv) {
        \Illuminate\Support\Facades\Mail::to($rdv->patient->user->email)
            ->send(new \App\Mail\AppointmentReminder($rdv));
            
        $this->info("Rappel envoyé à : " . $rdv->patient->user->email);
    }

    $this->info('Fin de l\'opération.');
}
}
