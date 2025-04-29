<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('crm_contact_note_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_note_id');
            $table->string('file_path');
            $table->string('original_name');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->timestamps();
            $table->foreign('contact_note_id')->references('id')->on('crm_contact_notes')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('crm_contact_note_files');
    }
};
