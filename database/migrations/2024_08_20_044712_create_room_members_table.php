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
        Schema::create('room_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reserve_id')->comment('reserve by id');
            $table->foreign('reserve_id')->references('id')->on('reserves');
            $table->unsignedBigInteger('user_id')->comment('user by id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('seat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_members');
    }
};
