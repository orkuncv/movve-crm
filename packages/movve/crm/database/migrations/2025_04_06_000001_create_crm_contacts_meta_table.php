<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('crm_contacts_meta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained('crm_contacts')->onDelete('cascade');
            $table->foreignId('team_meta_field_id')->constrained('crm_team_meta_fields')->onDelete('cascade');
            $table->text('value')->nullable(); // Voor tekst of JSON waarden
            $table->integer('counter')->default(0); // Specifiek voor counter type velden zoals shop_visited
            $table->timestamps();
            
            // Zorg ervoor dat elke contact maar één record per meta veld heeft
            $table->unique(['contact_id', 'team_meta_field_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_contacts_meta');
    }
};
