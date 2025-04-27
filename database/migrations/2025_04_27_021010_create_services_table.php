<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('service_categories')->nullOnDelete();
            $table->string('name');
            $table->text('info')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('duration')->nullable(); // duration in minutes
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
