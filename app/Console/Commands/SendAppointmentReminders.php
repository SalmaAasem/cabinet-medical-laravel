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
        $tomorrow = now()->addDay()->format('Y-m-d H:i');
    
        $appointments = \App\Models\RendezVous::where('statut', 'confirme')
            ->whereRaw("DATE_FORMAT(date_heure, '%Y-%m-%d %H:%i') = ?", [$tomorrow])
            ->get();

        foreach ($appointments as $rdv) {
           \Illuminate\Support\Facades\Mail::to($rdv->patient->user->email)
                 ->send(new \App\Mail\AppointmentReminder($rdv));
        }

        $this->info('Rappels envoyés avec succès !');
    }
}
