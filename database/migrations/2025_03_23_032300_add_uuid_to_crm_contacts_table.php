<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Movve\Crm\Models\Contact;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('crm_contacts', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->nullable();
        });

        // Genereer UUIDs voor bestaande contacten
        $contacts = Contact::all();
        foreach ($contacts as $contact) {
            $contact->uuid = (string) Str::uuid();
            $contact->save();
        }

        // Maak de kolom verplicht nadat alle bestaande contacten een UUID hebben
        Schema::table('crm_contacts', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crm_contacts', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
