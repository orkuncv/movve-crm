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
        Schema::create('crm_team_meta_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->string('name');
            $table->string('key')->index(); // Unieke sleutel voor het meta veld (bijv. shop_visited)
            $table->string('type')->default('counter'); // Type van het meta veld (counter, text, boolean, etc.)
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes(); // Voeg direct soft deletes toe
            
            // Zorg ervoor dat elke team maar één meta veld met dezelfde key kan hebben
            $table->unique(['team_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_team_meta_fields');
    }
};
