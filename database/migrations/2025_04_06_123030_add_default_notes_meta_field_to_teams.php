<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Jetstream;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Voeg het standaard "Notities" meta veld toe aan alle bestaande teams
        $teams = DB::table('teams')->get();
        
        foreach ($teams as $team) {
            // Controleer of het "Notities" meta veld al bestaat voor dit team
            $exists = DB::table('crm_team_meta_fields')
                ->where('team_id', $team->id)
                ->where('key', 'notes')
                ->exists();
                
            if (!$exists) {
                DB::table('crm_team_meta_fields')->insert([
                    'team_id' => $team->id,
                    'name' => 'Notities',
                    'key' => 'notes',
                    'type' => 'field', // Gebruik 'field' type voor tekstvelden
                    'description' => 'Notities over deze contactpersoon',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Verwijder alle "Notities" meta velden
        DB::table('crm_team_meta_fields')
            ->where('key', 'notes')
            ->delete();
    }
};
