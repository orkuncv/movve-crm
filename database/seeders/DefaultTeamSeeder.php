<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DefaultTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Controleer of er al een admin gebruiker is
        $user = DB::table('users')->where('email', 'admin@movve.nl')->first();
        
        // Als er geen admin gebruiker is, maak er een aan
        if (!$user) {
            $userId = DB::table('users')->insertGetId([
                'name' => 'Admin',
                'email' => 'admin@movve.nl',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $userId = $user->id;
        }
        
        // Controleer of er al een default team is
        $team = DB::table('teams')->where('name', 'Movve CRM')->first();
        
        // Als er geen default team is, maak er een aan
        if (!$team) {
            $teamId = DB::table('teams')->insertGetId([
                'user_id' => $userId,
                'name' => 'Movve CRM',
                'personal_team' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Koppel de gebruiker aan het team
            DB::table('team_user')->insert([
                'team_id' => $teamId,
                'user_id' => $userId,
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $this->command->info('Default team created successfully!');
        } else {
            $this->command->info('Default team already exists.');
        }
    }
}
