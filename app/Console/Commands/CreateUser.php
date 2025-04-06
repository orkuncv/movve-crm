<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user {name} {email} {password} {--team-name= : De naam van het team dat moet worden aangemaakt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Maak een nieuwe gebruiker aan met optioneel een team';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');
        $teamName = $this->option('team-name');
        
        // Controleer of de gebruiker al bestaat
        if (User::where('email', $email)->exists()) {
            $this->error("Een gebruiker met e-mail {$email} bestaat al!");
            return 1;
        }
        
        // Maak de gebruiker aan
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();
        
        // Maak een persoonlijk team aan (standaard in Jetstream)
        $user->ownedTeams()->create([
            'name' => $user->name . "'s Team",
            'personal_team' => true,
        ]);
        
        // Maak een extra team aan als de optie is opgegeven
        if ($teamName) {
            $team = $user->ownedTeams()->create([
                'name' => $teamName,
                'personal_team' => false,
            ]);
            
            // Stel het nieuwe team in als het huidige team van de gebruiker
            $user->switchTeam($team);
            $this->info("Team '{$teamName}' is aangemaakt en ingesteld als het huidige team.");
        }
        
        $this->info("Gebruiker {$name} ({$email}) is succesvol aangemaakt!");
        return 0;
    }
}
