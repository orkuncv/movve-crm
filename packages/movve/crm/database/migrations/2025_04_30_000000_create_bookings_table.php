<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('crm_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('staff_member_id');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('staff_member_id')->references('id')->on('staff_members')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
            $table->foreign('contact_id')->references('id')->on('crm_contacts')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
