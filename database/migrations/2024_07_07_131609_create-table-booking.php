<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('room_id');
            $table->string('status');
            $table->timestamps();
            $table->date('date_created');
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('total_guest');
            $table->unsignedBigInteger('personal_id');
            $table->foreign('personal_id')
                    ->references('personal_id')
                    ->on('personal_information');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
